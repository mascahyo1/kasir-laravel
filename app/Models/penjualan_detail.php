<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualan_detail extends Model
{
    use HasFactory;
    protected $table = 'penjualan_detail';
    protected $fillable = ['penjualan_id', 'barang_id', 'jumlah', 'harga'];
    public function penjualan() {
        return $this->belongsTo(penjualan::class);
    }
    public function barang() {
        return $this->belongsTo(barang::class);
    }
}
