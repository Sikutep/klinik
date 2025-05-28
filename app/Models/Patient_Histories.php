<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient_Histories extends Model
{
    protected $fillable = [
        'patient_id',
        'visit_date',
        'visit_reason',
        'diagnosis',
        'treatment_plan',
        'notes',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the patient associated with the history.
     */
    public function patient()
    {
        return $this->belongsTo(Patiens::class, 'patient_id');
    }
}
