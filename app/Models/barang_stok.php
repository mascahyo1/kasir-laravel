<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_stok extends Model
{
    use HasFactory;
    protected $table = 'barang_stok';
    protected $fillable = [
        'barang_id',
        'jumlah',
    ];
    public function barang()
    {
        return $this->belongsTo('App\Models\barang', 'barang_id');
    }
}
