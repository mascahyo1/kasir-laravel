<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_opname extends Model
{
    use HasFactory;
    protected $table = 'barang_opname';
    protected $fillable = [
        'barang_id',
        'jumlah',
        'tanggal',
        'deskripsi'
    ];
    public function barang()
    {
        return $this->belongsTo('App\Models\barang', 'barang_id');
    }
}
