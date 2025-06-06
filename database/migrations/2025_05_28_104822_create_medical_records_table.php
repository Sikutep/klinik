<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();

            // === Relasi ke Pasien & Dokter ===
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patiens')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // Tanggal pemeriksaan
            $table->date('recorded_at')->nullable();

            // === SUBJECTIVE (S) ===
            $table->string('keluhan_utama');
            $table->text('anamnesa');
            $table->text('riwayat_penyakit')->nullable();
            $table->string('riwayat_alergi')->nullable();
            $table->text('riwayat_pengobatan')->nullable();

            // === OBJECTIVE (O) ===
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->string('tekanan_darah', 20)->nullable();
            $table->decimal('suhu_tubuh', 4, 1)->nullable();
            $table->integer('nadi')->nullable();
            $table->integer('pernapasan')->nullable();
            $table->integer('saturasi')->nullable();
            $table->text('hasil_pemeriksaan_fisik')->nullable();
            $table->text('hasil_pemeriksaan_penunjang')->nullable();

            // === ASSESSMENT (A) ===
            $table->text('diagnosis');
            $table->text('diagnosis_banding')->nullable();
            $table->string('kode_icd10', 10)->nullable();

            // === PLAN (P) ===
            $table->text('resep_obat')->nullable();
            $table->text('rencana_tindakan')->nullable();
            $table->text('edukasi_pasien')->nullable();
            $table->date('rencana_kontrol')->nullable();
            $table->text('rujukan')->nullable();

            // === METADATA ===
            $table->enum('status', ['draft', 'final', 'revisi'])->default('draft');
            $table->text('lampiran')->nullable(); // Akan disimpan dalam format JSON array

             $table->unsignedBigInteger('poli_id')->nullable();
            $table->foreign('poli_id')
                  ->references('id')
                  ->on('polis')
                  ->onDelete('set null');

            // Jika ingin tahu ruangan (mis: ruang pemeriksaan/ruang tindakan):
            $table->unsignedBigInteger('ruangan_id')->nullable();
            $table->foreign('ruangan_id')
                  ->references('id')
                  ->on('ruangans')
                  ->onDelete('set null');


            // === Audit Trail ===
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            // Jika sempat menambahkan layanan_id, uncomment baris di bawah
            // $table->dropForeign(['layanan_id']);
            // $table->dropColumn('layanan_id');

            $table->dropForeign(['ruangan_id']);
            $table->dropColumn('ruangan_id');

            $table->dropForeign(['poli_id']);
            $table->dropColumn('poli_id');
        });
    }
};
