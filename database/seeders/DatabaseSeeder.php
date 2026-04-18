<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // This tells Laravel to run your Princess Mae Banoy account seeder
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}