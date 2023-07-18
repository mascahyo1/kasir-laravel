<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = ['nama', 'harga_jual', 'stok', 'supplier_id'];
    public function supplier() {
        return $this->belongsTo(supplier::class);
    }
    public function stok() {
        return $this->hasOne(stok::class);
    }

}
