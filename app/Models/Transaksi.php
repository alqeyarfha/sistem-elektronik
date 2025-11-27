<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = ['kode', 'id_supplier', 'id_komponen', 'jumlah', 'total_harga'];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    // Relasi many-to-many ke produk lewat tabel pivot "detail_transaksi"
    public function komponens()
    {
        return $this->belongsToMany(Komponen::class, 'detail_transaksi', 'id_transaksi', 'id_komponen')
                    ->withPivot('jumlah', 'sub_total')
                    ->withTimestamps();
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_transaksi');
    }

}
