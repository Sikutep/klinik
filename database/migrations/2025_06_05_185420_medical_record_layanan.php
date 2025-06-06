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
        Schema::create('medical_record_layanan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('medical_record_id');
            $table->foreign('medical_record_id')
                  ->references('id')
                  ->on('medical_records')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('layanan_id');
            $table->foreign('layanan_id')
                  ->references('id')
                  ->on('layanans')
                  ->onDelete('cascade');

            // Jika perlu catat harga per layanan, kuantitas, dsb.
            $table->integer('kuantitas')->default(1);
            $table->decimal('harga_satuan', 12, 2)->nullable();
            $table->decimal('total_harga', 14, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_record_layanan');
    }
};
