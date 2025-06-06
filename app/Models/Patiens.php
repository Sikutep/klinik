<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patiens extends Model
{
    protected $fillable = [
        'nama',
        'nik',
        'gender',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'email',
        'alamat',
        'kota',
        'provinsi',
        'negara',
        'kode_pos',
        'type_darah',
        'pekerjaan',
        'agama',
        'penyedia_asuransi',
        'nomor_asuransi',
        'photo',
        'is_active',
        'created_by',
        'updated_by',
        'kunjungan_terakhir',
        'notes',
        'nama_kontak_darurat',
        'telepon_kontak_darurat',
        'hubungan_kontak_darurat',
        'gejala_awal',
        'mr_number',
    ];

    /**
     * Get the users associated with the patient.
     */
    public function users()
    {
        return $this->hasMany(Users::class);
    }


}
