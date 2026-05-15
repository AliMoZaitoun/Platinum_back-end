<?php

namespace Database\Seeders;

use App\Models\RealEstate\Unit;
use App\Models\RealEstate\Building;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $buildings = Building::take(2)->get();

        $buildingA1 = $buildings->first();
        $buildingA2 = $buildings->where('building_number', 'A-2')->first() ?? $buildings->first();

        // شقق المبنى A-1
        Unit::create([
            'building_id' => $buildingA1->id,
            'unit_number' => 'VIP-101',
            'floor' => 5,
            'rooms_count' => 4,
            'area' => 180.5,
            'type' => 'vip',
            'price' => 750000000.00,
            'status' => 'available',
            'description' => [
                'ar' => 'شقة VIP مطلة على الشارع الرئيسي مع صالون مفتوح ونظام ذكي.',
                'en' => 'VIP apartment overlooking the main street with an open concept living room and smart home system.'
            ]
        ]);

        Unit::create([
            'building_id' => $buildingA1->id,
            'unit_number' => 'VIP-102',
            'floor' => 5,
            'rooms_count' => 3,
            'area' => 145.0,
            'type' => 'vip',
            'price' => 620000000.00,
            'status' => 'maintenance',
            'description' => [
                'ar' => 'شقة VIP تخضع لأعمال الصيانة الدورية للتكييف المركزي.',
                'en' => 'VIP apartment undergoing routine maintenance for central air conditioning.'
            ]
        ]);

        Unit::create([
            'building_id' => $buildingA1->id,
            'unit_number' => 'SOC-202',
            'floor' => 2,
            'rooms_count' => 3,
            'area' => 110.0,
            'type' => 'social',
            'price' => 320000000.00,
            'status' => 'reserved',
            'description' => null
        ]);

        // شقق المبنى A-2
        Unit::create([
            'building_id' => $buildingA2->id,
            'unit_number' => 'VIP-PENT',
            'floor' => 10,
            'rooms_count' => 6,
            'area' => 320.0,
            'type' => 'vip',
            'price' => 1500000000.00,
            'status' => 'available',
            'description' => [
                'ar' => 'شقة بنتهاوس فاخرة تغطي الطابق كاملاً مع مسبح خاص وتراس دائرى.',
                'en' => 'Luxury penthouse apartment covering the entire floor with a private pool and a wrap-around terrace.'
            ]
        ]);

        Unit::create([
            'building_id' => $buildingA2->id,
            'unit_number' => 'SOC-303',
            'floor' => 3,
            'rooms_count' => 2,
            'area' => 95.0,
            'type' => 'social',
            'price' => 280000000.00,
            'status' => 'sold',
            'description' => [
                'ar' => 'شقة سكن اقتصادي مناسبة للمتزوجين حديثاً، تم بيعها.',
                'en' => 'Social housing apartment suitable for newlyweds, already sold.'
            ]
        ]);

        Unit::create([
            'building_id' => $buildingA2->id,
            'unit_number' => 'SOC-104',
            'floor' => 1,
            'rooms_count' => 3,
            'area' => 120.0,
            'type' => 'social',
            'price' => 340000000.00,
            'status' => 'available',
            'description' => [
                'ar' => 'شقة سكن اقتصادي أرضية مريحة مع حديقة صغيرة.',
                'en' => 'Comfortable ground-floor social housing apartment with a small garden.'
            ]
        ]);
    }
}
