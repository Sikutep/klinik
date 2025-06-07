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
        Schema::create('observations', function (Blueprint $table) {
            $table->id();

            // Foreign key ke medical_records
            $table->unsignedBigInteger('medical_record_id')->nullable();
            $table->foreign('medical_record_id')
                  ->references('id')
                  ->on('medical_records')
                  ->onDelete('cascade');

            // Jika observasi diambil di klinik tertentu (misal UGD, Poli Anak, dll.)
            $table->unsignedBigInteger('poli_id')->nullable()->comment('ID unit/klinik');
            $table->foreign('poli_id')
                  ->references('id')
                  ->on('polis')
                  ->onDelete('set null');

            $table->unsignedBigInteger('patiens_id')->nullable();
            $table->foreign('patiens_id')
                ->references('id')
                ->on('patiens')
                ->onDelete('set null');

            // Waktu pencatatan observasi
            $table->timestamp('observed_at')->comment('Waktu observasi');

            // Nilai-nilai vital
            $table->decimal('suhu', 4, 1)
                  ->nullable()
                  ->comment('Suhu tubuh dalam °C');
            $table->string('tekanan_darah', 20)
                  ->nullable()
                  ->comment('Contoh: 120/80 mmHg');
            $table->integer('nadi')
                  ->nullable()
                  ->comment('Nadi (x/menit)');
            $table->integer('pernapasan')
                  ->nullable()
                  ->comment('Pernapasan (x/menit)');
            $table->integer('saturasi')
                  ->nullable()
                  ->comment('Saturasi oksigen (%)');

            // Additional parameters
            $table->string('respiratory_support_type')
                  ->nullable()
                  ->comment('Jenis dukungan pernapasan: none/nasal_cannula/masker_sederhana/high_flow/ventilator');
            $table->integer('oxygen_flow_rate')
                  ->nullable()
                  ->comment('Debit oksigen (L/menit) saat dukungan pernapasan');

            // Pain assessment
            $table->tinyInteger('pain_scale')
                  ->nullable()
                  ->comment('Skor nyeri (0-10)');
            $table->string('pain_location')
                  ->nullable()
                  ->comment('Lokasi nyeri');
            $table->string('pain_character')
                  ->nullable()
                  ->comment('Karakter nyeri');

            // GCS (Glasgow Coma Scale)
            $table->tinyInteger('gcs_eye')->nullable()->comment('GCS Eye (1-4)');
            $table->tinyInteger('gcs_verbal')->nullable()->comment('GCS Verbal (1-5)');
            $table->tinyInteger('gcs_motor')->nullable()->comment('GCS Motor (1-6)');
            $table->tinyInteger('total_gcs')->nullable()->comment('Total GCS (3-15)');

            // Point-of-care labs
            $table->decimal('glukosa_sewaktu', 5, 2)
                  ->nullable()
                  ->comment('Gula darah sewaktu (mmol/L)');

            // Fluid balance
            $table->integer('fluid_intake_cc')
                  ->nullable()
                  ->comment('Jumlah cairan masuk (cc)');
            $table->integer('fluid_output_cc')
                  ->nullable()
                  ->comment('Jumlah cairan keluar (cc)');
            $table->integer('balance_fluid_cc')
                  ->nullable()
                  ->comment('Selisih input-output cairan');

            // Intervention
            $table->text('intervention_given')
                  ->nullable()
                  ->comment('Intervensi yang diberikan selama observasi');

            // Next observation schedule
            $table->timestamp('next_observed_at')
                  ->nullable()
                  ->comment('Jadwal observasi berikutnya');

            // Allergy reaction
            $table->text('current_allergy_reaction')
                  ->nullable()
                  ->comment('Reaksi alergi pasien saat observasi');

            // Mobility status
            $table->string('mobility_status')
                  ->nullable()
                  ->comment('Status mobilitas: independent/assist/bedridden');

            // Mental status notes
            $table->text('mental_status_notes')
                  ->nullable()
                  ->comment('Catatan status mental/psikologis');

            // Attachment photo (misal foto luka)
            $table->string('attachment_photo')
                  ->nullable()
                  ->comment('Path foto kondisi pasien atau luka');

            // Catatan tambahan (misal reaksi pasien, keluhan baru)
            $table->text('catatan')
                  ->nullable()
                  ->comment('Catatan tambahan observasi');

            // Kaitan ke ruangan
            $table->unsignedBigInteger('ruangan_id')->nullable();
            $table->foreign('ruangan_id')
                  ->references('id')
                  ->on('ruangans')
                  ->onDelete('set null');



            // ID user/perawat/dokter yang mencatat
            $table->unsignedBigInteger('observer_id')->nullable();
            $table->foreign('observer_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            // Audit Trail
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('observations', function (Blueprint $table) {
            $table->dropForeign(['queue_id']);
            $table->dropColumn('queue_id');

            $table->dropForeign(['ruangan_id']);
            $table->dropColumn('ruangan_id');
        });
    }
};
