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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')
                ->references('id')
                ->on('patiens')
                ->onDelete('cascade');
            $table->unsignedBigInteger('casier_id');
            $table->foreign('casier_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->decimal('jumlah', 10, 2);
            $table->string('jenis_transaksi');    // misalnya: 'pembayaran', 'pengembalian'
            $table->string('metode_pembayaran');  // misalnya: 'tunai', 'kartu_kredit', 'asuransi'


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
