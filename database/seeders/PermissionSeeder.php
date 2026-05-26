<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'rent books',
            'manage books',
            'manage categories',
            'manage readers',
            'manage admins',
            'manage payments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $reader = Role::firstOrCreate(['name' => 'reader']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);

        $reader->syncPermissions([
            'rent books',
        ]);

        $admin->syncPermissions([
            'manage books',
            'manage categories',
            'manage readers',
        ]);

        // Super-admin gets everything
        $superAdmin->syncPermissions(Permission::all());
    }
}