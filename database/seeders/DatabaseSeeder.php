<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            AdminSeeder::class,
            WarehouseSeeder::class,
            ItemSeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,
            EmployeeDepartmentSeeder::class,
            SolutionSeeder::class,
            LocationSeeder::class,
            ProjectSeeder::class,
            BuildingSeeder::class,
            UnitSeeder::class,
            ClientSeeder::class
        ]);
    }
}
