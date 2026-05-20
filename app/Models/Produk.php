<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_kategori', 'nama_produk', 'harga', 'stok'
    ];

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'id_kategori', 'id_kategori');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_produk', 'id_produk');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'id_produk', 'id_produk');
    }
}
