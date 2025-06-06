<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polis = [
            'Poli Umum',
            'Poli Anak',
            'Poli Gigi',
            'Poli Kebidanan dan Kandungan',
            'Poli Penyakit Dalam',
            'Poli Bedah',
            'Poli Ortopedi',
            'Poli Kulit dan Kelamin',
            'Poli Mata',
            'Poli THT',
            'Instalasi Gawat Darurat'
        ];

        foreach ($polis as $poli) {
            DB::table('polis')->insert([
                'nama' => $poli,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
