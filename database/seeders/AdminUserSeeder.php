<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Princess Mae Banoy',
            'email'    => 'admin@supplymanager.local',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Optional: You can also create a test supplier here
        // User::create([
        //     'name'     => 'Test Supplier',
        //     'email'    => 'supplier@supplymanager.local',
        //     'password' => Hash::make('supplier123'),
        //     'role'     => 'supplier',
        // ]);
    }
}