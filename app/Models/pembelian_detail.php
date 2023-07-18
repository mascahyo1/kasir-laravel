<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembelian_detail extends Model
{
    use HasFactory;
    protected $table = 'pembelian_detail';
    protected $fillable = ['pembelian_id', 'barang_id', 'jumlah', 'harga'];
    public function pembelian() {
        return $this->belongsTo(pembelian::class);
    }
    public function barang() {
        return $this->belongsTo(barang::class);
    }
}
