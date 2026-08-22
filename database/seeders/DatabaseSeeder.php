<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // تعطيل فحص المفاتيح الأجنبية لتسريع عملية الـ Seeding (اختياري ولكن مفضل في بيئة التطوير)
        Schema::disableForeignKeyConstraints();

        $this->call([
            // Phase 1: Base Lookup Data
            RoleAndPermissionSeeder::class,
            LocationSeeder::class,
            DepartmentSeeder::class,
            SolutionSeeder::class,
            ComplaintTypeSeeder::class,
            FaqNodeSeeder::class,
            PanoramaProjectSeeder::class,

            // Phase 2: Core Users & Profiles
            UserSeeder::class,
            UserDeviceTokenSeeder::class,

            // Phase 3: Real Estate Infrastructure & Inventory
            ProjectSeeder::class,
            BuildingSeeder::class,
            UnitSeeder::class,
            WarehouseSeeder::class,
            ItemSeeder::class,

            // Phase 4: HR, Allocations & Working Hours
            EmployeeDepartmentSeeder::class,
            ProjectEngineerAllocationSeeder::class,
            AvailabilitySlotSeeder::class,

            // Phase 5: CRM, Sales & Communications
            OrderSeeder::class,
            AppointmentSeeder::class,
            FavoriteSeeder::class,
            ComplaintSeeder::class,
            ChatRoomSeeder::class,
            MessageSeeder::class,

            // Phase 6: Marketing & Promotions
            OfferSeeder::class,
            AdvertisementSeeder::class,
            LotterySeeder::class,

            // Phase 7: Financials & Contracts (السيناريو الأهم)
            ContractSeeder::class,
            ContractExceptionSeeder::class,
            UnitOwnershipSeeder::class,
            PaymentSeeder::class,
            TransactionSeeder::class,

            // Phase 8: Field Operations & Engineering Reports
            ConstructionReportSeeder::class,
            ConstructionInsightSeeder::class,
            AttendanceSeeder::class,

            // Phase 9: Polymorphic & Media
            MediaSeeder::class,
            NoteSeeder::class,
            NotificationSeeder::class,
            ApartmentDesignSuggestionSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
