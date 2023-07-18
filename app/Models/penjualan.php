<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $fillable = [
        'tanggal',
        'total',
        'ppn',
        'grand_total',
        'bayar',
        'kembalian',
    ];
    public function penjualan_detail() {
        return $this->hasMany(penjualan_detail::class);
    }
}
