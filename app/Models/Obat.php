<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga_satuan',
    ];


    public function resepObats()
    {
        return $this->hasMany(ResepObat::class);
    }

     public function getHargaSatuanFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_satuan, 0, ',', '.');
    }
}
