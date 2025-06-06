<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
     protected $table = 'layanans'; // nama tabel plural

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga_satuan',
    ];

    /**
     * Relasi many-to-many ke MedicalRecord
     */
    public function medicalRecords()
    {
        return $this->belongsToMany(
            MedicalRecord::class,
            'medical_record_layanan',
            'layanan_id',
            'medical_record_id'
        )->withPivot(['kuantitas', 'harga_satuan', 'total_harga'])
         ->withTimestamps();
    }

     public function getHargaSatuanFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_satuan, 0, ',', '.');
    }
}
