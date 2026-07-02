<?php

namespace Database\Seeders;

use App\Models\RealEstate\Solution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SolutionSeeder extends Seeder
{
    public function run(): void
    {
        $disk = 's3';
        $solutions = [
            [
                'name' => ['ar' => 'بيع العقارات السكنية', 'en' => 'Residential Property Sale'],
                'description' => ['ar' => 'خدمة وساطة متكاملة لشراء وبيع العقارات السكنية.', 'en' => 'Full-service brokerage for buying and selling residential properties.'],
                'price' => 3500.00,
            ],
            [
                'name' => ['ar' => 'إنتاج جولات عقارية افتراضية', 'en' => 'Virtual Property Tour Production'],
                'description' => ['ar' => 'إنتاج جولات افتراضية ثلاثية الأبعاد (3D) عالية الجودة وتصوير جوي بطائرات الدرون.', 'en' => 'Production of high-quality virtual 3D tours and aerial drone photography.'],
                'price' => 600.00,
            ]
        ];

        foreach ($solutions as $sData) {
            $solution = Solution::create([
                'name'        => $sData['name'],
                'description' => $sData['description'],
                'price'       => $sData['price']
            ]);

            // // رفع غلاف أو أيقونة للخدمة المقدمة
            // $imagePath = 'solutions/service_' . Str::random(5) . '.png';
            // ob_start();
            // $im = imagecreatetruecolor(400, 250);
            // $bg = imagecolorallocate($im, 52, 73, 94); // Dark Navy
            // imagefill($im, 0, 0, $bg);
            // imagestring($im, 4, 10, 110, "Service: " . substr($sData['name']['en'], 0, 30), imagecolorallocate($im, 255, 255, 255));
            // imagepng($im);
            // $imgContent = ob_get_clean();
            // imagedestroy($im);

            // try {
            //     Storage::disk($disk)->put($imagePath, $imgContent, 'public');
            //     $solution->attachments()->create([
            //         'uuid'          => (string) Str::uuid(),
            //         'path'          => $imagePath,
            //         'original_name' => 'service_cover.png',
            //         'type'          => 'image',
            //         'recorded_at'   => now(),
            //     ]);
            // } catch (\Exception $e) {
            //     $this->command->error("Failed to upload service solution icon: " . $e->getMessage());
            // }
        }
    }
}
