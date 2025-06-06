<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      
    public function run(): void
    {
        // Array nama ruangan sesuai permintaan
        $ruanganList = [
            'Ruang Tunggu',
            'Ruang Periksa 1',
            'Ruang Periksa 2',
            'Ruang Tindakan',
            'Ruang Observasi',
            'Ruang UGD',
            'Ruang Radiologi',
            'Ruang Laboratorium',
            'Ruang Apotek',
            'Ruang Administrasi',
        ];

        $now = Carbon::now();

        $data = [];
        foreach ($ruanganList as $nama) {
            $data[] = [
                'nama'       => $nama,
                'deskripsi'  => null,          // bisa diisi jika diperlukan
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert data ke tabel ruangans
        DB::table('ruangans')->insert($data);
    }
}
