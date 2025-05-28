<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'avatar' => 'https://ui-avatars.com/api/?name=Admin',
                'nama' => 'Atep Suryana',
                'no_induk_karyawan' =>'I00353',
                'no_hp' => '081234567890',
                'email' => 'atepriandipahmi@gmail.com',
                'alamat' => 'Jl. Raya No. 123',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'negara' => 'Indonesia',
                'kode_pos' => '40123',
                'password' => bcrypt('password123'),
                'role_id' => 1, // Admin
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'avatar' => 'https://ui-avatars.com/api/?name=Petugas+Registrasi',
                'nama' => 'Budi Santoso',
                'no_induk_karyawan' =>'I00354',
                'no_hp' => '081234567891',
                'email' => 'budi@example.com',
                'alamat' => 'Jl. Kebon Jeruk No. 456',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'negara' => 'Indonesia',
                'kode_pos' => '11530',
                'password' => bcrypt('password123'),
                'role_id' => 2, // Petugas Registrasi
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'avatar' => 'https://ui-avatars.com/api/?name=Dokter',
                'nama' => 'Dr. Siti Aminah',
                'no_induk_karyawan' =>'I00355',
                'no_hp' => '081234567892',
                'email' => 'siti@email.com',
                'alamat' => 'Jl. Melati No. 789',
                'kota' => 'Yogyakarta',
                'provinsi' => 'DI Yogyakarta',
                'negara' => 'Indonesia',
                'kode_pos' => '55281',
                'password' => bcrypt('password123'),
                'role_id' => 3, // Dokter
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'avatar' => 'https://ui-avatars.com/api/?name=Perawat',
                'nama' => 'Rina Wulandari',
                'no_induk_karyawan' =>'I00356',
                'no_hp' => '081234567893',
                'email' => 'rina@gmail.com',
                'alamat' => 'Jl. Anggrek No. 101',
                'kota' => 'Surabaya',
                'provinsi' => 'Jawa Timur',
                'negara' => 'Indonesia',
                'kode_pos' => '60234',
                'password' => bcrypt('password123'),
                'role_id' => 4, // Perawat
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'avatar' => 'https://ui-avatars.com/api/?name=Kasir',
                'nama' => 'Andi Prasetyo',
                'no_induk_karyawan' =>'I00357',
                'no_hp' => '081234567894',
                'email' => 'andi@gmail.com',
                'alamat' => 'Jl. Mawar No. 202',
                'kota' => 'Medan',
                'provinsi' => 'Sumatera Utara',
                'negara' => 'Indonesia',
                'kode_pos' => '20111',
                'password' => bcrypt('password123'),
                'role_id' => 5, // Kasir
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
