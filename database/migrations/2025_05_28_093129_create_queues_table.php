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
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patiens')->onDelete('cascade');
            $table->string('nomor_antrian');
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai'])->default('menunggu');

            $table->unsignedBigInteger('ruangan_id');
            $table->foreign('ruangan_id')->references('id')->on('ruangans');

            $table->unsignedBigInteger('poli_id')->nullable()->comment('FK ke tabel polis (master)');
            $table->foreign('poli_id')
                  ->references('id')
                  ->on('polis')
                  ->onDelete('set null');

            $table->timestamp('called_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->softDeletes(); // For soft delete functionality
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('queues', function (Blueprint $table) {
            $table->dropForeign(['poli_id']);
            $table->dropColumn('poli_id');
        });

    }
};
