<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    public $fillable = ['nama_supplier', 'alamat', 'no_hp'];
    public $visible = ['id', 'nama_supplier', 'alamat', 'no_hp'];
}
