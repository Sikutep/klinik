<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\Queues;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class QueuesController extends Controller
{
    public function index(Request $request)
    {

        $queues = Queues::with('patient')
            ->orderBy('nomor_antrian', 'asc')
            ->paginate($request->query('per_page', 10));
        $poli = Poli::all();
        $ruangan = Ruangan::all();


        return view('antrian.index', compact('queues', 'poli', 'ruangan'));
    }

    public function showMonitor()
    {

        $queueDipanggil = Queues::with('patient')
            ->where('status', 'dipanggil')
            ->orderBy('created_at', 'asc')
            ->first();

        if ($queueDipanggil) {
            $queue = $queueDipanggil;
        } else {

            $queue = Queues::with('patient')
                ->orderBy('created_at', 'asc')
                ->first();
        }

        // Jikalau memang tabel antrian kosong, $queue bisa null—tangani nanti di view.
        return view('antrian.monitor', compact('queue'));
    }


    public function show($id)
    {

        $queue = Queues::with('patient')->findOrFail($id);
        return response()->json($queue);
    }


    public function store(Request $request)
    {
        // Logic to create a new queue entry
        $validate = $request->validate([
            'patient_id' => 'required|exists:patiens,id',
            'nomor_antrian' => 'required|string|max:255',
        ]);

        $queue = Queues::create([
            'patiens_id' => $validate['patient_id'],
            'nomor_antrian' => $validate['nomor_antrian'],
            'status' => 'menunggu',
            'called_at' => null,
            'completed_at' => null,

        ]);

        return response()->json($queue, 201);
    }

    public function calledQueue(Request $request, $id)
    {
        // 1) Tandai antrian yang sedang “dipanggil” (jika ada) menjadi “selesai”
        // Cari semua record yang status = 'dipanggil'
        $previous = Queues::where('status', 'dipanggil')->get();
        foreach ($previous as $old) {
            $old->status       = 'selesai';
            $old->completed_at = now();
            $old->save();
        }

        // 2) Tandai antrian yang baru di‐klik menjadi “dipanggil”
        $queue = Queues::with('patient', 'ruangan', 'poli')->findOrFail($id);
        $queue->status    = 'dipanggil';
        $queue->called_at = now();
        $queue->save();

        // Flash nomor antrian yang baru dipanggil agar JS TTS bisa bekerja
        session()->flash('announce_queue', $queue->nomor_antrian);
        session()->flash('name_queue', $queue->patient->nama);

        session() ->flash('poli_queue', $queue->poli->nama);
        session() ->flash('ruangan_queue', $queue->ruangan->nama);

        return redirect()->route('antrian.index');
    }

    /**
     * Jika Anda punya method untuk menyelesaikan antrian secara manual,
     * bisa tetap dipertahankan. Tapi logika otomatis now ada di atas.
     */
    public function completeQueue(Request $request, $id)
    {
        $queue = Queues::findOrFail($id);
        $queue->status       = 'selesai';
        $queue->completed_at = now();
        $queue->save();

        return redirect()->route('antrian.index');
    }
}
