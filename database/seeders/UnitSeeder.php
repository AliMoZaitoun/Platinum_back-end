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
        $buildings = Building::take(2)->get();
        if ($buildings->isEmpty()) {
            $this->command->error('يرجى تشغيل BuildingSeeder أولاً!');
            return;
        }

        $disk = 's3';
        $buildingA1 = $buildings->first();
        $buildingA2 = $buildings->where('building_number', 'A-2')->first() ?? $buildings->first();

        $unitsData = [
            ['b_id' => $buildingA1->id, 'num' => 'VIP-101', 'floor' => 5, 'type' => 'vip', 'price' => 750000000.00, 'status' => 'available'],
            ['b_id' => $buildingA2->id, 'num' => 'VIP-PENT', 'floor' => 10, 'type' => 'vip', 'price' => 1500000000.00, 'status' => 'available'],
            ['b_id' => $buildingA1->id, 'num' => 'SOC-202', 'floor' => 2, 'type' => 'social', 'price' => 320000000.00, 'status' => 'reserved']
        ];

        foreach ($unitsData as $uData) {
            $unit = Unit::create([
                'building_id' => $uData['b_id'],
                'unit_number' => $uData['num'],
                'floor'       => $uData['floor'],
                'rooms_count' => 4,
                'area'        => 150.0,
                'type'        => $uData['type'],
                'price'       => $uData['price'],
                'status'      => $uData['status'],
                'description' => ['ar' => 'شقة مميزة ومصممة بأحدث الأساليب الهندسة.', 'en' => 'Premium unit designed with modern engineering standards.']
            ]);

            // توليد صورتين لكل شقة (مخطط طابقي وصورة بانورامية 360 افتراضية)
            $images = ['floor_plan' => '230, 126, 34', 'interior_360' => '142, 68, 173']; // Orange & Purple

            foreach ($images as $nameType => $rgb) {
                $imagePath = 'units/' . $nameType . '_' . Str::random(5) . '.png';
                $colors = explode(', ', $rgb);

                ob_start();
                $im = imagecreatetruecolor(400, 250);
                $bg = imagecolorallocate($im, $colors[0], $colors[1], $colors[2]);
                imagefill($im, 0, 0, $bg);
                imagestring($im, 5, 20, 110, "Unit {$uData['num']} - {$nameType}", imagecolorallocate($im, 255, 255, 255));
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
                        'recorded_at'   => now(),
                    ]);
                } catch (\Exception $e) {
                    $this->command->error("Failed to upload unit attachment: " . $e->getMessage());
                }
            }
        }
    }
}
