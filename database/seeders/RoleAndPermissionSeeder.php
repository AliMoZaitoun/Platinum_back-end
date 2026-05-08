<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $resources = [
            'client',
            'engineer',
            'employee',
            'warehouse',
            'item',
            'department',
            'role',

            'solution',
            'project',
            'building',
            'unit',
            'favorite',
            'appointment',
            'order',
            'availableSlot',
            'advertisment',
            'location',
            'report'
        ];

        $actions = ['read', 'create', 'update', 'delete'];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::create(['name' => "$action.$resource"]);
            }
        }

        // Admin — gets everything
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        // Employee
        $employee = Role::firstOrCreate(['name' => 'employee']);
        $employee->syncPermissions([]);

        // Engineer
        $engineer = Role::firstOrCreate(['name' => 'engineer']);
        $engineer->syncPermissions([
            'read.project',
            'read.building',
            'create.report',
            'read.report'
        ]);

        // Client
        $client = Role::firstOrCreate(['name' => 'client']);
        $client->syncPermissions([
            'read.solution',
            'read.unit',
            'read.building',
            'create.favorite',
            'read.favorite',
            'delete.favorite',
            'read.appointment',
            'create.order',
            'read.advertisment',
            'read.location',
        ]);

        $marketing_staff = Role::firstOrCreate(['name' => 'marketing_staff']);
        $marketing_staff->syncPermissions([
            'create.solution',
            'read.solution',
            'update.solution',
            'delete.solution',

            'create.location',
            'read.location',
            'update.location',
            'delete.location',

            'create.project',
            'read.project',
            'update.project',
            'delete.project',

            'create.building',
            'read.building',
            'update.building',
            'delete.building',

            'create.unit',
            'read.unit',
            'update.unit',
            'delete.unit',

            'create.advertisment',
            'read.advertisment',
            'update.advertisment',
            'delete.advertisment',
        ]);

        $legal = Role::firstOrCreate(['name' => 'legal_staff']);
        $legal->syncPermissions([
            'create.availableSlot',
            'read.availableSlot',
            'update.availableSlot',
            'delete.availableSlot'
        ]);

        $customer_service = Role::firstOrCreate(['name' => 'customer_service_staff']);
        $customer_service->syncPermissions([
            'read.order',
            'update.order',
            'delete.order',

            'create.appointment',
            'read.appointment',
            'update.appointment',
            'delete.appointment',
        ]);

        $finance = Role::firstOrCreate(['name' => 'finance_staff']);
        $finance->syncPermissions([
            'create.availableSlot',
            'read.availableSlot',
            'update.availableSlot',
            'delete.availableSlot'
        ]);
    }
}
