<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pembayaran',
        'transaksi_id',
        'tanggal_bayar',
        'jumlah_bayar',
        'metode_pembayaran',
    ];

    // Relasi ke model Transaksi
    public function transaksi()
    {
        // Memastikan nama foreign key 'transaksi_id' benar
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}
