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
        Schema::create('medical_record_tindakan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('medical_record_id');
            $table->foreign('medical_record_id')
                  ->references('id')
                  ->on('medical_records')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('tindakan_id');
            $table->foreign('tindakan_id')
                  ->references('id')
                  ->on('tindakans')
                  ->onDelete('cascade');

            // Jika perlu catat biaya, dokter yang melakukan, dsb.
            $table->decimal('biaya_tindakan', 12, 2)->nullable();
            $table->unsignedBigInteger('dokter_pelaksana')->nullable();
            $table->foreign('dokter_pelaksana')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_record_tindakan');
    }
};
