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
        Schema::create('patient_consents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')
                ->references('id')
                ->on('patiens')
                ->onDelete('cascade');
            $table->string('jenis_persetujuan');
            $table->boolean('disetujui')->default(false);
            $table->timestamp('waktu_disetujui')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->foreign('dibuat_oleh')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->unsignedBigInteger('diperbarui_oleh')->nullable();
            $table->foreign('diperbarui_oleh')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient__consents');
    }
};
