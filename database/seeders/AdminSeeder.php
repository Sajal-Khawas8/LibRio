<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@librio.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin@123'),
            ]
        );

        $admin->assignRole('super-admin');
    }
}
