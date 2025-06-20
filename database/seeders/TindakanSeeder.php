<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TindakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $procedures = [
            // 20 data awal dari gambar
            'Tensi Darah',
            'Suntik Vitamin',
            'Pemasangan Infus',
            'Penjahitan Luka',
            'Pencabutan Gigi',
            'Pemasangan Gips',
            'Bedah Minor',
            'Fisioterapi Wajah',
            'Fisioterapi Tubuh',
            'Terapi Oksigen',
            'Endoskopi',
            'Kolonoskopi',
            'Kuretase',
            'Elektroterapi',
            'Tes Spirometri',
            'USG Abdomen',
            'Rontgen Thorax',
            'EKG',
            'Insersi IUD',
            'Ante Natal Care Check',

            // Tambahan 100 tindakan medis realistis
            'Cek Gula Darah',
            'Tes Kolesterol',
            'Pemeriksaan Hemoglobin',
            'Tes Golongan Darah',
            'Pemeriksaan Urine',
            'Pemeriksaan THT',
            'Pemeriksaan Mata',
            'Pemeriksaan Kulit',
            'Pap Smear',
            'Pemeriksaan Kehamilan',
            'Vaksin Tetanus',
            'Vaksin Hepatitis B',
            'Vaksin DPT',
            'Vaksin HPV',
            'Vaksin COVID-19',
            'Vaksin Influenza',
            'Vaksin MMR',
            'Sirkumsisi',
            'Pemasangan Kateter',
            'Nebulizer',
            'Terapi Inhalasi',
            'Konsultasi Gizi',
            'Konsultasi Psikologi',
            'Konsultasi Gigi',
            'Scaling Gigi',
            'Tambal Gigi',
            'Pembersihan Karang Gigi',
            'Perawatan Saluran Akar',
            'Pemasangan Behel',
            'Pemeriksaan Gigi Anak',
            'Kuretase Kandungan',
            'Pemasangan Implan KB',
            'Pencabutan Kuku',
            'Lavage Telinga',
            'Pemeriksaan Fungsi Hati',
            'Pemeriksaan Fungsi Ginjal',
            'CT Scan',
            'MRI',
            'Ultrasonografi Transvaginal',
            'USG Payudara',
            'Rontgen Kepala',
            'Rontgen Gigi',
            'Pemeriksaan Retina',
            'Tes Pendengaran (Audiometri)',
            'Tes Keseimbangan (Timpanometri)',
            'Operasi Amandel',
            'Biopsi Kulit',
            'Biopsi Payudara',
            'Pemeriksaan PSA (Prostat)',
            'Tes HIV',
            'Tes Sifilis',
            'Tes Hepatitis C',
            'Tes TORCH',
            'Cek Tanda Vital',
            'Cek Refleks Neurologis',
            'Terapi Okupasi',
            'Terapi Bicara',
            'Konseling Kesehatan Mental',
            'Pemeriksaan Kardiologi',
            'Treadmill Test',
            'Holter Monitor',
            'Pemasangan Stent',
            'Operasi Katarak',
            'Pemeriksaan Glaukoma',
            'Laser Mata',
            'Tes Alergi Kulit',
            'Patch Test',
            'Skin Prick Test',
            'Injeksi Intra Artikulasi',
            'Aspirasi Sendi',
            'Terapi Nyeri',
            'Akupuntur Medis',
            'Cek Tumbuh Kembang Anak',
            'Imunisasi Bayi Lengkap',
            'Perawatan Luka Diabetes',
            'Debridement Luka',
            'Pemeriksaan Luka Dekubitus',
            'Konsultasi Bedah',
            'Konsultasi Saraf',
            'Konsultasi Anak',
            'Konsultasi Penyakit Dalam',
            'Konsultasi Paru',
            'Konsultasi Kandungan',
            'Konsultasi Urologi',
            'Konsultasi Ortopedi',
            'Konsultasi Psikiatri',
            'Pemeriksaan Spirometri',
            'Terapi Pernafasan',
            'Pemeriksaan Bronkoskopi',
            'Pemeriksaan EEG',
            'Pemeriksaan EMG',
            'Pemeriksaan Endokrin',
            'Pemantauan Janin (CTG)',
            'Senam Hamil',
            'Kelas Persiapan Persalinan',
            'Pijat Bayi',
            'Perawatan Neonatus',
            'Konsultasi Laktasi',
            'Perawatan Postpartum',
            'Konsultasi Keluarga Berencana',
            'Skrining Kanker Serviks',
            'Skrining Kanker Payudara',
            'Skrining Kanker Usus',
            'Cek Fungsi Tiroid',
            'USG Tiroid',
            'USG Testis',
            'Pemeriksaan Fertilitas',
            'Terapi Hormon',
        ];

        foreach ($procedures as $procedure) {
            DB::table('tindakans')->insert([
                'nama' => $procedure,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
