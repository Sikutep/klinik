<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'nama' => 'Admin',
                'slug' => 'admin',
                'deskripsi' => 'Administrator sistem',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Petugas Registrasi',
                'slug' => 'petugas-registrasi',
                'deskripsi' => 'Petugas yang menangani pendaftaran pasien',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dokter',
                'slug' => 'dokter',
                'deskripsi' => 'Dokter yang menangani pasien',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Perawat',
                'slug' => 'perawat',
                'deskripsi' => 'Perawat yang membantu dokter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kasir',
                'slug' => 'kasir',
                'deskripsi' => 'Petugas kasir untuk transaksi pembayaran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
