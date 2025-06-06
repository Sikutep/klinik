<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\ResepObat;

class MedicalRecord extends Model
{
    protected $table = 'medical_records';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        // Relasi
        'patient_id',
        'doctor_id',
        'recorded_at',

        // Subjective (S)
        'keluhan_utama',
        'anamnesa',
        'riwayat_penyakit',
        'riwayat_alergi',
        'riwayat_pengobatan',

        // Objective (O)
        'tinggi_badan',
        'berat_badan',
        'tekanan_darah',
        'suhu_tubuh',
        'nadi',
        'pernapasan',
        'saturasi',
        'hasil_pemeriksaan_fisik',
        'hasil_pemeriksaan_penunjang',

        // Assessment (A)
        'diagnosis',
        'diagnosis_banding',
        'kode_icd10',

        // Plan (P)
        'resep_obat',
        'rencana_tindakan',
        'edukasi_pasien',
        'rencana_kontrol',
        'rujukan',

        // Metadata
        'status',
        'lampiran',

        // Audit Trail
        'created_by',
        'updated_by',
    ];

    /**
     * Cast lampiran JSON ke array secara otomatis.
     */
    protected $casts = [
        'lampiran'     => 'array',
        'recorded_at'  => 'datetime',
        'rencana_kontrol' => 'date',
    ];

    /**
     * Relationship: MedicalRecord belongs to a Patient (Patiens model).
     */
    public function patient()
    {
        return $this->belongsTo(Patiens::class, 'patient_id');
    }

    /**
     * Relationship: MedicalRecord belongs to a Doctor (Users model).
     */
    public function doctor()
    {
        return $this->belongsTo(Users::class, 'doctor_id');
    }

    /**
     * Relationship: The user who created this medical record.
     */
    public function creator()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    /**
     * Relationship: The user who last updated this medical record.
     */
    public function updater()
    {
        return $this->belongsTo(Users::class, 'updated_by');
    }

    public function observations()
    {
        return $this->hasMany(Observation::class);
    }

    // misalnya di Eloquent Model MedicalRecord:
    public function layanans()
    {
        return $this->belongsToMany(Layanan::class, 'medical_record_layanan')
            ->withPivot(['kuantitas', 'harga_satuan', 'total_harga'])
            ->withTimestamps();
    }

    public function tindakans()
    {
        return $this->belongsToMany(Tindakan::class, 'medical_record_tindakan')
            ->withPivot(['biaya_tindakan', 'dokter_pelaksana'])
            ->withTimestamps();
    }

    public function resepObats()
    {
        return $this->hasMany(ResepObat::class);
    }




    /**
     * Akses untuk mengunduh lampiran (jika ingin ditampilkan pada view).
     */
    public function getLampiranUrlsAttribute()
    {
        if (! $this->lampiran) {
            return [];
        }

        return collect($this->lampiran)
            ->map(fn($path) => Storage::url($path))
            ->toArray();
    }
}
