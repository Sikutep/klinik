<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
     protected $fillable = [
        'medical_record_id',
        'poli_id',
        'patiens_id',
        'observed_at',
        'suhu',
        'tekanan_darah',
        'nadi',
        'pernapasan',
        'saturasi',
        'respiratory_support_type',
        'oxygen_flow_rate',
        'pain_scale',
        'pain_location',
        'pain_character',
        'gcs_eye',
        'gcs_verbal',
        'gcs_motor',
        'total_gcs',
        'glukosa_sewaktu',
        'fluid_intake_cc',
        'fluid_output_cc',
        'balance_fluid_cc',
        'intervention_given',
        'next_observed_at',
        'current_allergy_reaction',
        'mobility_status',
        'mental_status_notes',
        'attachment_photo',
        'catatan',
        'ruangan_id',

        'observer_id',
        'created_by',
        'updated_by'
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

     public function queue()
    {
        return $this->belongsTo(Queues::class, 'queue_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function observer()
    {
        return $this->belongsTo(Users::class, 'observer_id');
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }

    // Optional: relasi created_by dan updated_by jika dibutuhkan
    public function creator()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(Users::class, 'updated_by');
    }
}
