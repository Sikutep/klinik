<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            RuanganSeeder::class,
            PoliSeeder::class,
            ObatSeeder::class,
            LayananSeeder::class,
            TindakanSeeder::class
            
            // Tambahkan seeder lain yang diperlukan
        ]);
    }
}
