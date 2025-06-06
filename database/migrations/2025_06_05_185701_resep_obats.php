<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::create('resep_obats', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('medical_record_id');
            $table->foreign('medical_record_id')
                  ->references('id')
                  ->on('medical_records')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('obat_id');
            $table->foreign('obat_id')
                  ->references('id')
                  ->on('obats')
                  ->onDelete('cascade');

            $table->string('dosis')->nullable();       // misal “2x sehari 500mg”
            $table->integer('kuantitas')->nullable();  // jumlah unit (tablet, kapsul, ml, dst.)
            $table->text('keterangan')->nullable();    // misal “diambil saat makan”

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep_obats');
    }
};
