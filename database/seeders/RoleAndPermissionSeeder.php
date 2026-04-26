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
        $employee->syncPermissions([
            'read.warehouse',
            'read.item',
            'create.item',
            'update.item',
            'read.solution',
            'read.project',
            'read.building',
            'read.unit',
            'create.appointment',
            'read.appointment',
            'update.appointment',
            'delete.appointment',
            'create.advertisment',
            'update.advertisment',
            'read.advertisment',
            'delete.advertisment',
            'create.location',
            'update.location',
            'read.location',
            'delete.location',
            'read.order',
            'update.order',
            'delete.order',
            'create.availableSlot',
            'read.availableSlot',
            'update.availableSlot',
            'delete.availableSlot'
        ]);

        // Engineer
        $engineer = Role::firstOrCreate(['name' => 'engineer']);
        $engineer->syncPermissions([
            'read.project',
            'read.building',
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
    }
}
