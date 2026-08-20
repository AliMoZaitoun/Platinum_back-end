<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            AdminSeeder::class,
            LocationSeeder::class,
            WarehouseSeeder::class,
            ItemSeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,
            EmployeeDepartmentSeeder::class,
            // AdvertisementSeeder::class,
            SolutionSeeder::class,
            ProjectSeeder::class,
            BuildingSeeder::class,
            UnitSeeder::class,
            ClientSeeder::class,
            // EngineerSystemSeeder::class,

            AvailabilitySlotSeeder::class,
            OrderSeeder::class,
            // AppointmentSeeder::class,
            // ContractSeeder::class,
            // PaymentSeeder::class,
            // TransactionSeeder::class,
            // // UnitOwnershipSeeder::class,
            // NotificationSeeder::class,

            FaqNodeSeeder::class
        ]);
    }
}
