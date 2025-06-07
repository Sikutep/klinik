<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use App\Models\MedicalRecord;
use App\Models\Patiens;
use App\Models\Queues;
use App\Models\Ruangan;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
    /**
     * Tampilkan daftar observasi.
     * GET /observation
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $observations = Observation::with([
            'queue.patient',
            'ruangan',
            'poli',
            'observer',
        ])

            ->when($search, function ($q) use ($search) {
                $q->whereHas('queue.patient', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('observed_at', 'desc')
            ->paginate(15);

        // biar form tetap menampilkan kata kunci setelah submit
        $observations->appends(['search' => $search]);

        return view('observation.index', compact('observations', 'search'));
    }


    /**
     * Form untuk membuat observasi baru.
     * GET /observation/create
     */
    public function create()
    {
        $medicalRecords = MedicalRecord::orderBy('recorded_at', 'desc')->get();
        // Hanya antrian yang masih menunggu (status = "menunggu")

        $patients = Patiens::orderBy('nama')->get();
        $ruangans       = Ruangan::orderBy('nama')->get();
        $polis          = Poli::orderBy('nama')->get();

        return view('observation.create', compact(
            'medicalRecords',
            'ruangans',
            'polis',
            'patients'
        ));
    }

    /**
     * Simpan observasi baru ke database.
     * POST /observation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medical_record_id'         => ['nullable', 'exists:medical_records,id'],
            'patiens_id'                => ['nullable', 'exists:patiens,id'],

            'ruangan_id'                => ['required', 'exists:ruangans,id'],
            'poli_id'                   => ['nullable', 'exists:polis,id'],
            'observed_at'               => ['nullable', 'date'],

            // Vital signs
            'suhu'                      => ['nullable', 'numeric'],
            'tekanan_darah'             => ['nullable', 'string', 'max:20'],
            'nadi'                      => ['nullable', 'integer'],
            'pernapasan'                => ['nullable', 'integer'],
            'saturasi'                  => ['nullable', 'integer', 'min:0', 'max:100'],

            // Respiratory support
            'respiratory_support_type'  => ['nullable', 'string', 'max:50'],
            'oxygen_flow_rate'          => ['nullable', 'integer'],

            // Pain assessment
            'pain_scale'                => ['nullable', 'integer', 'min:0', 'max:10'],
            'pain_location'             => ['nullable', 'string', 'max:100'],
            'pain_character'            => ['nullable', 'string', 'max:100'],

            // GCS
            'gcs_eye'                   => ['nullable', 'integer', 'min:1', 'max:4'],
            'gcs_verbal'                => ['nullable', 'integer', 'min:1', 'max:5'],
            'gcs_motor'                 => ['nullable', 'integer', 'min:1', 'max:6'],
            'total_gcs'                 => ['nullable', 'integer', 'min:3', 'max:15'],

            // Point‐of‐care labs
            'glukosa_sewaktu'           => ['nullable', 'numeric'],

            // Fluid balance
            'fluid_intake_cc'           => ['nullable', 'integer'],
            'fluid_output_cc'           => ['nullable', 'integer'],
            'balance_fluid_cc'          => ['nullable', 'integer'],

            // Intervention
            'intervention_given'        => ['nullable', 'string'],

            // Next observation
            'next_observed_at'          => ['nullable', 'date'],

            // Allergy reaction
            'current_allergy_reaction'  => ['nullable', 'string'],

            // Mobility & mental status
            'mobility_status'           => ['nullable', 'string', 'max:50'],
            'mental_status_notes'       => ['nullable', 'string'],

            // Attachment photo
            'attachment_photo'          => ['nullable', 'string'],

            // Catatan tambahan
            'catatan'                   => ['nullable', 'string'],

            // Observer & audit
            // observer_id diisi otomatis
        ]);

        // Set default observed_at jika kosong
        if (empty($validated['observed_at'])) {
            $validated['observed_at'] = now();
        }

        // Observer (user yang login), created_by, updated_by
        $validated['observer_id'] = session('user_id');
        $validated['created_by']  = session('user_id');
        $validated['updated_by']  = session('user_id');

        Observation::create($validated);

        return redirect()
            ->route('observation.index')
            ->with('success', 'Observasi berhasil disimpan.');
    }

    /**
     * Show one observation detail.
     * GET /observation/{id}
     */
    public function show($id)
    {
        $observation = Observation::with([
            'medicalRecord.patient',
            'queue.patient',
            'ruangan',
            'poli',
            'observer',
            'creator',
            'updater',
        ])->findOrFail($id);

        return view('observation.show', compact('observation'));
    }

    /**
     * Form edit observation.
     * GET /observation/{id}/edit
     */
    public function edit($id)
    {
        $observation    = Observation::findOrFail($id);
        $medicalRecords = MedicalRecord::orderBy('recorded_at', 'desc')->get();
        $queues         = Queues::with('patient')->get();
        $ruangans       = Ruangan::orderBy('nama')->get();
        $polis          = Poli::orderBy('nama')->get();

        return view('observation.edit', compact(
            'observation',
            'medicalRecords',
            'queues',
            'ruangans',
            'polis'
        ));
    }

    /**
     * Proses update observation.
     * PUT /observation/{id}
     */
    public function update(Request $request, $id)
    {
        $observation = Observation::findOrFail($id);

        $validated = $request->validate([
            'medical_record_id'         => ['nullable', 'exists:medical_records,id'],
            'queue_id'                  => ['nullable', 'exists:queues,id'],
            'ruangan_id'                => ['required', 'exists:ruangans,id'],
            'poli_id'                   => ['nullable', 'exists:polis,id'],
            'observed_at'               => ['nullable', 'date'],

            // Vital signs
            'suhu'                      => ['nullable', 'numeric'],
            'tekanan_darah'             => ['nullable', 'string', 'max:20'],
            'nadi'                      => ['nullable', 'integer'],
            'pernapasan'                => ['nullable', 'integer'],
            'saturasi'                  => ['nullable', 'integer', 'min:0', 'max:100'],

            // Respiratory support
            'respiratory_support_type'  => ['nullable', 'string', 'max:50'],
            'oxygen_flow_rate'          => ['nullable', 'integer'],

            // Pain assessment
            'pain_scale'                => ['nullable', 'integer', 'min:0', 'max:10'],
            'pain_location'             => ['nullable', 'string', 'max:100'],
            'pain_character'            => ['nullable', 'string', 'max:100'],

            // GCS
            'gcs_eye'                   => ['nullable', 'integer', 'min:1', 'max:4'],
            'gcs_verbal'                => ['nullable', 'integer', 'min:1', 'max:5'],
            'gcs_motor'                 => ['nullable', 'integer', 'min:1', 'max:6'],
            'total_gcs'                 => ['nullable', 'integer', 'min:3', 'max:15'],

            // Point‐of‐care labs
            'glukosa_sewaktu'           => ['nullable', 'numeric'],

            // Fluid balance
            'fluid_intake_cc'           => ['nullable', 'integer'],
            'fluid_output_cc'           => ['nullable', 'integer'],
            'balance_fluid_cc'          => ['nullable', 'integer'],

            // Intervention
            'intervention_given'        => ['nullable', 'string'],

            // Next observation
            'next_observed_at'          => ['nullable', 'date'],

            // Allergy reaction
            'current_allergy_reaction'  => ['nullable', 'string'],

            // Mobility & mental status
            'mobility_status'           => ['nullable', 'string', 'max:50'],
            'mental_status_notes'       => ['nullable', 'string'],

            // Attachment photo
            'attachment_photo'          => ['nullable', 'string'],

            // Catatan tambahan
            'catatan'                   => ['nullable', 'string'],
        ]);

        if (empty($validated['observed_at'])) {
            $validated['observed_at'] = now();
        }

        $validated['updated_by'] = session('user_id');

        $observation->update($validated);

        return redirect()
            ->route('observation.show', $observation->id)
            ->with('success', 'Observasi berhasil diperbarui.');
    }

    /**
     * Hapus observasi.
     * DELETE /observation/{id}
     */
    public function destroy($id)
    {
        $observation = Observation::findOrFail($id);
        $observation->delete();

        return redirect()
            ->route('observation.index')
            ->with('success', 'Observasi berhasil dihapus.');
    }
}
