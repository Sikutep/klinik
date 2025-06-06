<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Queues extends Model
{
    protected $table = 'queues';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [

        'nomor_antrian',
        'patient_id',

        'status',
        'ruangan_id',
        'poli_id',
        'called_at',
        'completed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'called_at'    => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the patient that owns this queue entry.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patiens::class, 'patient_id');
    }

    /**
     * Scope a query to only include waiting queues.
     */
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    /**
     * Scope a query to only include called queues.
     */
    public function scopeDipanggil($query)
    {
        return $query->where('status', 'dipanggil');
    }

    /**
     * Scope a query to only include completed queues.
     */
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }


    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }
}
