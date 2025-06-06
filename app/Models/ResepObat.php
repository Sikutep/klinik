<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepObat extends Model
{
     protected $table = 'resep_obats';

    /**
     * Kolom‐kolom yang boleh di‐mass‐assign
     */
    protected $fillable = [
        'medical_record_id',
        'obat_id',
        'dosis',
        'kuantitas',
        'keterangan',
    ];

    /**
     * Relasi: ResepObat milik satu MedicalRecord
     */
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    /**
     * Relasi: ResepObat milik satu Obat
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
