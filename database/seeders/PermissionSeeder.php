<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'view-customers',
            'create-customers',
            'edit-customers',
            'delete-customers',
            'view-medicines',
            'create-medicines',
            'edit-medicines',
            'delete-medicines',
            'view-invoices',
            'create-invoices',
            'edit-invoices',
            'delete-invoices',
            'view-staff',
            'create-staff',
            'edit-staff',
            'delete-staff',
            'view-salary',
            'create-salary',
            'edit-salary',
            'delete-salary',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $managerRole = Role::findByName('quản lý');
        $staffRole = Role::findByName('nhân viên');

        // Manager gets all permissions
        $managerRole->givePermissionTo($permissions);

        // Staff gets limited permissions
        $staffRole->givePermissionTo([
            'view-customers',
            'create-customers',
            'edit-customers',
            'view-medicines',
            'view-invoices',
            'create-invoices',
        ]);
    }
}
