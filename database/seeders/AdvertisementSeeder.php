<?php

namespace Database\Seeders;

use App\Models\Marketing\Advertisement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        $employeeId = DB::table('employees')->value('id');

        $translations = [
            [
                'title' => [
                    'ar' => 'افتتاح المرحلة الثالثة من مجمع ديار الشام السكني',
                    'en' => 'Opening of Phase 3 in Diyar Al-Sham Residential Complex'
                ],
                'description' => [
                    'ar' => 'يسرنا أن نعلن عن بدء الحجز في المرحلة الثالثة مع إطلالات ساحرة وتسهيلات كبرى في الدفع.',
                    'en' => 'We are pleased to announce the opening of bookings for Phase 3 with stunning views and great payment plans.'
                ]
            ],
            [
                'title' => [
                    'ar' => 'حسم حصري 10% على الشقق السكنية في برج الياسمين',
                    'en' => 'Exclusive 10% Discount on Apartments in Al-Yasmin Tower'
                ],
                'description' => [
                    'ar' => 'لفترة محدودة جداً، امتلك شقة أحلامك في أرقى الأبراج السكنية مع خصم خاص عند الدفع الكاش.',
                    'en' => 'For a very limited time, own your dream apartment in the finest residential towers with a special cash discount.'
                ]
            ],
            [
                'title' => [
                    'ar' => 'بدء استقبال طلبات الاكتتاب على سكن واحة دمشق الذكي',
                    'en' => 'Applications Open for Damascus Smart Oasis Housing'
                ],
                'description' => [
                    'ar' => 'مشروعنا الجديد يعتمد بالكامل على تقنيات الطاقة البديلة والأنظمة الذكية، بادر بحجز مساحتك الآن.',
                    'en' => 'Our new project relies entirely on alternative energy and smart systems. Book your space now.'
                ]
            ],
            [
                'title' => [
                    'ar' => 'شقق فاخرة جاهزة للتسليم الفوري مع سند تمليك أخضر',
                    'en' => 'Luxury Apartments Ready for Imattachmentste Handover with Clean Title Deed'
                ],
                'description' => [
                    'ar' => 'كل الشقق مجهزة بأحدث الديكورات الهندسية ومستندات الملكية جاهزة للنقل الفوري باسم المشتري.',
                    'en' => 'All apartments are equipped with modern designs, and ownership documents are ready for imattachmentste transfer.'
                ]
            ]
        ];

        for ($i = 1; $i <= 30; $i++) {

            $data = $translations[array_rand($translations)];

            $startsAt = Carbon::now()->addDays(rand(-5, 10));
            $endsAt = (clone $startsAt)->addDays(rand(10, 45));
            $durationDays = $startsAt->diffInDays($endsAt);

            $advertisement = Advertisement::create([
                'title'         => [
                    'ar' => $data['title']['ar'] . " #{$i}",
                    'en' => $data['title']['en'] . " #{$i}"
                ],
                'description'   => $data['description'],
                'starts_at'     => $startsAt,
                'ends_at'       => $endsAt,
                'duration_days' => $durationDays,
                'status'        => rand(0, 1),
                'created_by'    => $employeeId,
            ]);

            $numberOfImages = rand(1, 2);
            for ($j = 1; $j <= $numberOfImages; $j++) {

                $imagePath = 'advertisements/ad_' . Str::random(5) . '.png';

                ob_start();
                $im = imagecreatetruecolor(400, 250);
                $bg = imagecolorallocate($im, 41, 128, 185);
                imagefill($im, 0, 0, $bg);
                imagestring($im, 5, 20, 110, "Ad Image #{$j}", imagecolorallocate($im, 255, 255, 255));
                imagepng($im);
                $imgContent = ob_get_clean();
                imagedestroy($im);

                try {
                    Storage::disk('s3')->put($imagePath, $imgContent, 'public');

                    $advertisement->attachments()->create([
                        'uuid'              => (string) Str::uuid(),
                        'path'              => $imagePath,
                        'original_name'     => "advertisement_banner_{$j}.png",
                        'type'              => 'image',
                        'custom_properties' => null,
                        'recorded_at'       => now(),
                    ]);
                } catch (\Exception $e) {
                }
            }
        }

        $this->command->info('🎉 AdvertisementSeeder executed successfully with Dual-Language data!');
    }
}
