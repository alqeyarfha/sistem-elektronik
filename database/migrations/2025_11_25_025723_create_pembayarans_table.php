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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembayaran')->unique(); // Contoh: PB-001
            $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade'); // Relasi ke tabel transaksis
            $table->date('tanggal_bayar');
            $table->decimal('jumlah_bayar', 15, 2); // Jumlah uang yang dibayarkan
            $table->string('metode_pembayaran')->nullable(); // Contoh: Cash, Transfer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
