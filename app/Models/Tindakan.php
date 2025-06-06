<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi'
    ];

    public function medicalRecords()
    {
        return $this->belongsToMany(
            MedicalRecord::class,
            'medical_record_tindakan',
            'tindakan_id',
            'medical_record_id'
        )->withPivot(['biaya_tindakan', 'dokter_pelaksana'])
            ->withTimestamps();
    }
}
