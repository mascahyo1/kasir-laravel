<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';
    protected $fillable = ['tanggal', 'total', 'ppn', 'grand_total'];
    public function pembelian_detail() {
        return $this->hasMany(pembelian_detail::class);
    }
}
