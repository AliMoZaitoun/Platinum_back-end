<?php

namespace Database\Seeders;

use App\Models\RealEstate\Unit;
use App\Models\RealEstate\Building;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UnitSeeder extends Seeder
{
    public function run()
    {
        // جلب جميع الأبنية لضمان توزيع الشقق عليها بالتساوي
        $buildings = Building::all();
        if ($buildings->isEmpty()) {
            $this->command->error('يرجى تشغيل BuildingSeeder أولاً!');
            return;
        }

        $disk = 's3';

        // 💡 الالتزام التام بالـ Enums الخاصة بك بالملّي
        $types = ['social', 'vip'];
        $statuses = ['available', 'reserved', 'sold', 'maintenance'];

        // مصفوفة الأوصاف المترجمة (عربي وإنجليزي) بناءً على النوع
        $descriptions = [
            'social' => [
                'ar' => 'شقة سكنية مريحة ومناسبة للعائلات بتشطيبات قياسية وأسعار مدروسة تناسب الجميع.',
                'en' => 'Comfortable residential unit suitable for families with standard finishing and affordable pricing.'
            ],
            'vip' => [
                'ar' => 'شقة فاخرة (بنتهاوس) بنظام ذكي، إطلالة بانورامية ساحرة، وتصميم هندسي راقٍ جداً.',
                'en' => 'Premium luxury unit (Penthouse) with smart system, breathtaking panoramic view, and high-end architectural design.'
            ],
        ];

        $totalUnitsCreated = 0;

        foreach ($buildings as $building) {
            // توليد من 5 إلى 8 شقق بداخل كل مبنى ليتخطى المجموع حاجز الـ 50 شقة بسهولة
            $unitsToCreate = rand(5, 8);

            for ($i = 1; $i <= $unitsToCreate; $i++) {
                $type = $types[array_rand($types)];
                $status = $statuses[array_rand($statuses)];

                // تحديد الطابق بناءً على الارتفاع الفعلي للمبنى المخزن بالداتابيز
                $floor = rand(1, $building->floors_count);

                // صياغة رقم الشقة (الاسم)
                $unitNumber = "A-{$floor}0{$i}";

                // حساب المساحة والسعر ديناميكياً بناءً على نوع الشقة (Social أو VIP)
                $area = $type === 'social' ? rand(90, 140) : rand(185, 350);
                $price = $type === 'social' ? rand(250000000, 450000000) : rand(850000000, 2200000000);

                // 💡 تذكرنا أن السعر decimal(15,2) unsigned، لذا نمرره كقيمة صافية
                $unit = Unit::create([
                    'building_id' => $building->id,
                    'unit_number' => $unitNumber,
                    'floor'       => $floor,
                    'rooms_count' => $type === 'social' ? rand(3, 4) : rand(4, 6),
                    'area'        => (float) $area,
                    'type'        => $type,
                    'price'       => (float) $price,
                    'status'      => $status,
                    'description' => $descriptions[$type] // 👈 تمرير الـ array مباشرة ولارافيل بيعملها toJson تلقائياً
                ]);

                $totalUnitsCreated++;

                // توليد الصور الملونة وضخها للـ S3 (مخطط هندسي وصورة داخلية)
                $images = ['floor_plan' => '230, 126, 34', 'interior_view' => '142, 68, 173'];

                foreach ($images as $nameType => $rgb) {
                    $imagePath = 'units/' . $nameType . '_' . Str::random(5) . '.png';
                    $colors = explode(', ', $rgb);

                    ob_start();
                    $im = imagecreatetruecolor(400, 250);
                    $bg = imagecolorallocate($im, (int)$colors[0], (int)$colors[1], (int)$colors[2]);
                    imagefill($im, 0, 0, $bg);
                    imagestring($im, 5, 20, 110, "Unit {$unitNumber} - {$nameType}", imagecolorallocate($im, 255, 255, 255));
                    imagepng($im);
                    $imgContent = ob_get_clean();
                    imagedestroy($im);

                    try {
                        Storage::disk($disk)->put($imagePath, $imgContent, 'public');
                        $unit->attachments()->create([
                            'uuid'          => (string) Str::uuid(),
                            'path'          => $imagePath,
                            'original_name' => "{$nameType}.png",
                            'type'          => 'image',
                            'custom_properties' => ['size_bytes' => 1024 * rand(50, 200)], // داتا تجريبية للـ json
                            'recorded_at'   => now(),
                        ]);
                    } catch (\Exception $e) {
                    }
                }
            }
        }

        $this->command->info("🎯 Done Seeding! Successfully created {$totalUnitsCreated} units matching your exact schema.");
    }
}
