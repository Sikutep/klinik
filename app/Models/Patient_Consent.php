<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient_Consent extends Model
{
    protected $fillable = [
        'patient_id',
        'consent_type',
        'consent_date',
        'consent_details',
        'is_active',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the patient associated with the consent.
     */
    public function patient()
    {
        return $this->belongsTo(Patiens::class, 'patient_id');
    }
}
