<?php

namespace App\Http\Controllers;

use App\Helpers\EncryptHelper;
use App\Models\Patiens;
use App\Models\Poli;
use App\Models\Queues;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatiensController extends Controller
{
    public function generateNoMR()
    {
        $lastPatient = Patiens::orderBy('created_at', 'desc')->first();
        if ($lastPatient) {
            $lastNoMR = $lastPatient->mr_number;
            $newNoMR = str_pad((int) substr($lastNoMR, -6) + 1, 6, '0', STR_PAD_LEFT);
            return 'MR-' . date('Y') . '-' . $newNoMR;
        }
        return 'MR-' . date('Y') . '-000001';
    }

    public function generateQueueNumber()
    {
        $lastQueue = Queues::orderBy('created_at', 'desc')->first();

        if ($lastQueue) {
            [$prefix, $lastNumber] = explode('-', $lastQueue->nomor_antrian);
            $newNumber = str_pad(((int) $lastNumber) + 1, 3, '0', STR_PAD_LEFT);
            return $prefix . '-' . $newNumber;
        }

        return 'A-001';
    }


    public function index(Request $request)
    {
        $search  = $request->query('search');
        $gender  = $request->query('gender');
        $perPage = $request->query('per_page', 10);

        // 1. Siapkan query dasar (kolom sesuai yang ada di DB)
        $query = Patiens::select('id', 'nama', 'nik', 'gender', 'tanggal_lahir', 'alamat', 'no_hp', 'mr_number', 'created_at')
            ->orderBy('created_at', 'desc');

        // 2. Filter berdasarkan kata kunci di nama / MR / no HP
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('mr_number', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        // 3. Filter berdasarkan jenis kelamin
        if ($gender) {
            $query->where('gender', $gender);
        }

        $patiensPaginate = $query->paginate($perPage)->withQueryString();

        $queuesNumber = $this->generateQueueNumber();
        $noMRbaru     = $this->generateNoMR();

        $poli = Poli::all();
        $ruangan = Ruangan::all();
        // 6. Kirim ke view
        return view('pendaftaran-pasien.index', [
            'patiens'       => $patiensPaginate,
            'queues_number' => $queuesNumber,
            'no_mr'         => $noMRbaru,
            'poli' => $poli,
            'ruangan' =>  $ruangan

        ]);
    }

    public function show($encryptId)
    {
        $id = EncryptHelper::decryptId($encryptId);
        $data = Patiens::find($id);
        return view('pendaftaran-pasien.show', compact('data'));
    }
    public function create()
    {
        $no_mr = $this->generateNoMR();
        $ruangan = Ruangan::all();
        $poli = Poli::all();
        return view('pendaftaran-pasien.create', compact(['no_mr', 'ruangan', 'poli']));
    }
    public function store(Request $request)
    {
        if (session('user_role') == 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validated = $request->validate([
            'mr_number'                 => 'nullable|string|max:255|unique:patiens,mr_number',
            'nama'                      => 'required|string|max:255',
            'nik'                       => 'nullable|string|max:255|unique:patiens,nik',
            'gender'                    => 'required|in:L,P',
            'tempat_lahir'              => 'required|string|max:255',
            'tanggal_lahir'             => 'required|date',
            'no_hp'                     => 'required|string|max:15',
            'email'                     => 'required|email|max:255',
            'alamat'                    => 'required|string|max:500',
            'kota'                      => 'required|string|max:100',
            'provinsi'                  => 'required|string|max:100',
            'negara'                    => 'nullable|string|max:100',
            'kode_pos'                  => 'required|string|max:20',
            'type_darah'                => 'nullable|in:A,B,AB,O',
            'pekerjaan'                 => 'required|string|max:255',
            'agama'                     => 'required|string|max:100',
            'penyedia_asuransi'         => 'nullable|string|max:255',
            'nomor_asuransi'            => 'nullable|string|max:255',
            'photo'                     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'notes'                     => 'nullable|string',
            'nama_kontak_darurat'       => 'nullable|string|max:255',
            'telepon_kontak_darurat'    => 'nullable|string|max:15',
            'hubungan_kontak_darurat'   => 'nullable|string|max:100',

            'gejala_awal' => 'required|string|max:100',
            'ruangan_id' => 'required|integer|exists:ruangans,id',
            'poli_id' => 'required|integer|exists:polis,id',
        ]);

        if ($validated['mr_number'] == '') {
            $validated['mr_number'] = $this->generateNoMR();
        }
        if (Patiens::where('mr_number', $validated['mr_number'])->exists()) {
            return response()->json(['message' => 'MR Number already exists'], 400);
        }

        if (!$validated['mr_number'] == $this->generateNoMR()) {
            return response()->json(['message' => 'Invalid MR Number'], 400);
        }
        $validated['created_by'] = session('user_id');
        $validated['updated_by'] = session('user_id');
        $validated['is_active'] = true;

        $patient = Patiens::create($validated);



        // Cari ID poli IGD (berdasarkan nama “IGD”)
        $igdId = Poli::where('nama', 'Instalasi Gawat Darurat')->value('id');

        // Jika pilih IGD, langsung return tanpa membuat antrean
        if ($request->poli_id == $igdId) {
            return redirect()
                ->route('patiens.index')
                ->with('info', 'Pasien di IGD tidak perlu masuk antrean.');
        }




       Queues::create([
        'nomor_antrian' => $this->generateQueueNumber(),
        'patient_id'    => $patient->id,
        'poli_id'       => $request->poli_id,
        'ruangan_id'    => $request->ruangan_id,
        'status'        => 'menunggu',
        'called_at'     => null,
        'completed_at'  => null,
    ]);

        // return response()->json([
        //     'message' => 'Patient created successfully',
        //     'patient' => $patient,
        //     'queue' => $queue,
        // ], 201);
        return redirect()->route('patiens.index')->with('Pendaftaran Pasien Berhasil');
    }



    public function edit($encryptId)
    {
        $id = EncryptHelper::decryptId($encryptId);
        $data = Patiens::find($id);
        return view('pendaftaran-pasien.edit', compact('data'));
    }
    public function update(Request $request, $encryptId)
    {
        // 1. Decrypt ID dan cari data
        $id = EncryptHelper::decryptId($encryptId);
        $patient = Patiens::findOrFail($id);

        // 2. Validasi input. mr_number tidak diubah (tidak dimasukkan di rules).
        $validated = $request->validate([
            'nama'                    => 'required|string|max:255',
            'nik'                     => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('patiens', 'nik')->ignore($patient->id),
            ],
            'gender'                  => ['required', Rule::in(['L', 'P'])],
            'tempat_lahir'            => 'required|string|max:255',
            'tanggal_lahir'           => 'required|date',
            'no_hp'                   => 'required|string|max:15',
            'email'                   => [
                'required',
                'email',
                'max:255',
                Rule::unique('patiens', 'email')->ignore($patient->id),
            ],
            'alamat'                  => 'required|string|max:500',
            'kota'                    => 'required|string|max:100',
            'provinsi'                => 'required|string|max:100',
            'negara'                  => 'nullable|string|max:100',
            'kode_pos'                => 'required|string|max:20',
            'type_darah'              => ['nullable', Rule::in(['A', 'B', 'AB', 'O'])],
            'pekerjaan'               => 'required|string|max:255',
            'agama'                   => 'required|string|max:100',
            'penyedia_asuransi'       => 'nullable|string|max:255',
            'nomor_asuransi'          => 'nullable|string|max:255',
            'photo'                   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'notes'                   => 'nullable|string',
            'nama_kontak_darurat'     => 'nullable|string|max:255',
            'telepon_kontak_darurat'  => 'nullable|string|max:15',
            'hubungan_kontak_darurat' => 'nullable|string|max:100',
        ]);

        // 3. Assign field (kecuali mr_number)
        $patient->nama                    = $validated['nama'];
        $patient->nik                     = $validated['nik'];
        $patient->gender                  = $validated['gender'];
        $patient->tempat_lahir            = $validated['tempat_lahir'];
        $patient->tanggal_lahir           = $validated['tanggal_lahir'];
        $patient->no_hp                   = $validated['no_hp'];
        $patient->email                   = $validated['email'];
        $patient->alamat                  = $validated['alamat'];
        $patient->kota                    = $validated['kota'];
        $patient->provinsi                = $validated['provinsi'];
        $patient->negara                  = $validated['negara'] ?? $patient->negara;
        $patient->kode_pos                = $validated['kode_pos'];
        $patient->type_darah              = $validated['type_darah'];
        $patient->pekerjaan               = $validated['pekerjaan'];
        $patient->agama                   = $validated['agama'];
        $patient->penyedia_asuransi       = $validated['penyedia_asuransi'];
        $patient->nomor_asuransi          = $validated['nomor_asuransi'];
        // Jika ada upload photo, tangani penyimpanan file (opsional):
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $patient->photo = $path;
        }
        $patient->notes                   = $validated['notes'] ?? '';
        $patient->nama_kontak_darurat     = $validated['nama_kontak_darurat'];
        $patient->telepon_kontak_darurat  = $validated['telepon_kontak_darurat'];
        $patient->hubungan_kontak_darurat = $validated['hubungan_kontak_darurat'];

        // 4. Simpan perubahan
        $patient->updated_by = session('user_id');
        $patient->save();

        // 5. Redirect ke index dengan flash message
        return redirect()
            ->route('patiens.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy($encryptId)
    {
        $id = EncryptHelper::decryptId($encryptId);
        $patient = Patiens::findOrFail($id);

        $patient->delete();

        return redirect()
            ->route('patiens.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }

    public function addQueue(Request $request, $encryptId)
    {
        // 1) Validasi input
        $request->validate([
            'poli_id'    => 'required|exists:polis,id',
            'ruangan_id' => 'required|exists:ruangans,id',
        ]);

        // 2) Decrypt ID pasien
        $id = EncryptHelper::decryptId($encryptId);

        // 3) Ambil ID poli IGD (misal berdasarkan nama "IGD")
        $igdId = Poli::where('nama', 'Instalasi Gawat Darurat')->value('id');

        // 4) Tentukan status default:
        //    - jika poli_id == IGD, langsung 'selesai'
        //    - selain itu, 'menunggu'
        $status = ($request->poli_id == $igdId)
            ? 'selesai'
            : 'menunggu';
        // 3) Simpan antrian baru (gunakan field yang sesuai)
        $queue = Queues::create([
            'nomor_antrian' => $this->generateQueueNumber(),
            'patient_id'    => $id,
            'poli_id'       => $request->poli_id,
            'ruangan_id'    => $request->ruangan_id,
            'status'        => $status,
            'called_at'     => null,
            'completed_at'  => null,
        ]);

        return redirect()->route('patiens.index')
            ->with('success', 'Pasien telah ditambahkan ke antrian.');
    }
}
