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
        $permissions = [
            'create warehouse',
            'read warehouse',
            'update warehouse',
            'delete warehouse',

            'create item',
            'read item',
            'update item',
            'delete item',

            'create role',
            'read role',
            'update role',
            'delete role',

            'create permission',
            'read permission',
            'update permission',
            'delete permission',

            'create offering',
            'read offering',
            'update offering',
            'delete offering',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin — gets everything
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions);

        // Employee — limited access
        $employee = Role::firstOrCreate(['name' => 'employee']);
        $employee->syncPermissions([
            'read warehouse',
            'read item',
            'create item',
            'update item',
            'read offering',
        ]);

        // Client — read only
        $client = Role::firstOrCreate(['name' => 'client']);
        $client->syncPermissions([
            'read offering',
        ]);
    }
}
