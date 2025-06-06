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
        Schema::create('patiens', function (Blueprint $table) {
            $table->id();
            $table->string('mr_number')->unique();
            $table->string('nama');
            $table->string('nik')->unique()->nullable();
            $table->enum('gender', ['L', 'P']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('negara')->default('Indonesia');
            $table->string('kode_pos')->nullable();
            $table->enum('type_darah', ['A', 'B', 'AB', 'O'])->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('agama')->nullable();
            $table->string('penyedia_asuransi')->nullable();
            $table->string('nomor_asuransi')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamp('kunjungan_terakhir')->nullable();
            $table->text('notes')->nullable();
            $table->string('nama_kontak_darurat')->nullable();
            $table->string('telepon_kontak_darurat')->nullable();
            $table->string('hubungan_kontak_darurat')->nullable();
            $table->string('gejala_awal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patiens');
    }
};
