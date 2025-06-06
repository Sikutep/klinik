<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patiens;
use App\Models\Users;
use App\Models\Observation;
use App\Models\Obat;
use App\Models\Layanan;
use App\Models\Queues;
use App\Models\Tindakan;
use App\Models\ResepObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        // Jika ingin mendukung filter, paging, atau searching, Anda dapat menambahkan query di sini.
        // Contoh: cari berdasarkan nama pasien atau dokter:
        $searchPatient = $request->query('patient_name');
        $searchDoctor  = $request->query('doctor_name');

        $query = MedicalRecord::with(['patient', 'doctor', 'tindakans']);

        if ($searchPatient) {
            $query->whereHas('patient', function ($q) use ($searchPatient) {
                $q->where('nama', 'like', "%{$searchPatient}%");
            });
        }

        if ($searchDoctor) {
            $query->whereHas('doctor', function ($q) use ($searchDoctor) {
                $q->where('nama', 'like', "%{$searchDoctor}%");
            });
        }

        // Urut berdasarkan tanggal tercatat (recorded_at) terbaru
        $records = $query->orderBy('recorded_at', 'desc')->paginate(10)->withQueryString();

        return view('medical-record.index', compact('records'));
    }

    /**
     * Show the form for creating a new medical record.
     */
    public function create()
    {
        $patients = Queues::select('queues.*')
        ->join('patiens', 'queues.patient_id', '=', 'patiens.id')
        ->whereIn('queues.status', ['dipanggil', 'selesai'])
        ->orderBy('patiens.nama')
        ->with('patient')
        ->get();

        $doctors   = Users::whereIn('role_id', [3, 4])->orderBy('nama')->get();
        $obats     = Obat::orderBy('nama')->get();
        $layanans  = Layanan::orderBy('nama')->get();
        $tindakans = Tindakan::orderBy('nama')->get();

        return view('medical-record.create', compact(
            'patients',
            'doctors',
            'obats',
            'layanans',
            'tindakans'
        ));
    }



    /**
     * Store a newly created medical record in storage.
     */
    public function store(Request $request)
    {

        // 1) Ambil semua isi request
        $all = $request->all();

        if (isset($all['resep_obat']) && is_array($all['resep_obat'])) {
            $filtered = [];
            foreach ($all['resep_obat'] as $idx => $row) {
                $obatId    = data_get($row, 'obat_id');
                $dosis     = data_get($row, 'dosis');
                $kuantitas = data_get($row, 'kuantitas');

                // Buang baris yang benar‐benar kosong total
                if (
                    (is_null($obatId)    || $obatId === '') &&
                    (is_null($dosis)     || trim($dosis) === '') &&
                    (is_null($kuantitas) || $kuantitas === '')
                ) {
                    continue;
                }

                // Jika hanya setengah terisi (satu atau dua kolom saja), juga buang (opsional)
                // Kalau Anda ingin memaksa user melengkapi, jangan blok ini; pakai required_with di validator.
                // Contoh jika ingin skip semua baris yang tidak lengkap:
                if (
                    (empty($obatId) || trim($dosis) === '' || empty($kuantitas))
                ) {
                    continue;
                }

                // Kalau ingin meloloskan baris "setengah terisi" agar validator men‐trigger pesan error,
                // buang blok kondisi di atas, dan cukup pakai "skip jika ketiga kosong" seperti ini.

                $filtered[$idx] = $row;
            }
            // Re‐index array agar jadi [0,1,2,…]
            $filtered = array_values($filtered);
            $request->merge(['resep_obat' => $filtered]);
        }




        $rules = [
            // === Relasi dasar ===
            'patient_id'             => ['required', 'exists:patiens,id'],
            'doctor_id'              => ['required', 'exists:users,id'],
            'recorded_at'            => ['nullable', 'date'],

            // === Subjective (S) ===
            'keluhan_utama'          => ['required', 'string', 'max:255'],
            'anamnesa'               => ['required', 'string'],
            'riwayat_penyakit'       => ['nullable', 'string'],
            'riwayat_alergi'         => ['nullable', 'string', 'max:255'],
            'riwayat_pengobatan'     => ['nullable', 'string'],

            // === Objective (O) ===
            'tinggi_badan'                   => ['nullable', 'integer'],
            'berat_badan'                    => ['nullable', 'integer'],
            'tekanan_darah'                  => ['nullable', 'string', 'max:20'],
            'suhu_tubuh'                     => ['nullable', 'numeric'],
            'nadi'                           => ['nullable', 'integer'],
            'pernapasan'                     => ['nullable', 'integer'],
            'saturasi'                       => ['nullable', 'integer', 'min:0', 'max:100'],
            'hasil_pemeriksaan_fisik'        => ['nullable', 'string'],
            'hasil_pemeriksaan_penunjang'    => ['nullable', 'string'],

            // === Assessment (A) ===
            'diagnosis'               => ['required', 'string'],
            'diagnosis_banding'       => ['nullable', 'string'],
            'kode_icd10'              => ['nullable', 'string', 'max:10'],

            // === Plan (P) ===
            // Kita akan validasi resep_obat sebagai array
            'resep_obat'                => ['nullable', 'array'],

            // Jika Anda ingin memaksa baris “setengah terisi” muncul error:
            'resep_obat.*.obat_id'      => [
                'nullable',
                'exists:obats,id',
                'required_with:resep_obat.*.dosis,resep_obat.*.kuantitas',
            ],
            'resep_obat.*.dosis'        => [
                'nullable',
                'string',
                'required_with:resep_obat.*.obat_id,resep_obat.*.kuantitas',
            ],
            'resep_obat.*.kuantitas'    => [
                'nullable',
                'integer',
                'min:1',
                'required_with:resep_obat.*.obat_id,resep_obat.*.dosis',
            ],
            'resep_obat.*.keterangan'   => ['nullable', 'string'],



            // Layanan & tindakan sebagai array of IDs
            'layanans'  => ['nullable', 'array'],
            'layanans.*' => ['exists:layanans,id'],
            'tindakans'  => ['nullable', 'array'],
            'tindakans.*' => ['exists:tindakans,id'],

            'rencana_tindakan'        => ['nullable', 'string'],
            'edukasi_pasien'          => ['nullable', 'string'],
            'rencana_kontrol'         => ['nullable', 'date'],
            'rujukan'                 => ['nullable', 'string'],

            // === Metadata (opsional) ===
            'status'                  => ['required', 'in:draft,final,revisi'],
            'lampiran.*'              => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->route('medicalrecord.create')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Jika tidak memasukkan recorded_at, gunakan timestamp sekarang
        if (empty($data['recorded_at'])) {
            $data['recorded_at'] = Carbon::now();
        }

        // Simpan file lampiran jika ada
        if ($request->hasFile('lampiran')) {
            $paths = [];
            foreach ($request->file('lampiran') as $file) {
                $paths[] = $file->store('medical_attachments', 'public');
            }
            // Simpan sebagai JSON array
            $data['lampiran'] = json_encode($paths);
        }

        // Isi kolom created_by dan updated_by dari session (asumsi sudah ada user_id)
        $data['created_by'] = session('user_id');
        $data['updated_by'] = session('user_id');

        // === 1) Simpan ke tabel medical_records dan tampung ke $mr ===
        $mr = MedicalRecord::create([
            'patient_id'                 => $data['patient_id'],
            'doctor_id'                  => $data['doctor_id'],
            'recorded_at'                => $data['recorded_at'],

            // Subjective (S)
            'keluhan_utama'              => $data['keluhan_utama'],
            'anamnesa'                   => $data['anamnesa'],
            'riwayat_penyakit'           => $data['riwayat_penyakit'] ?? null,
            'riwayat_alergi'             => $data['riwayat_alergi'] ?? null,
            'riwayat_pengobatan'         => $data['riwayat_pengobatan'] ?? null,

            // Objective (O)
            'tinggi_badan'               => $data['tinggi_badan'] ?? null,
            'berat_badan'                => $data['berat_badan'] ?? null,
            'tekanan_darah'              => $data['tekanan_darah'] ?? null,
            'suhu_tubuh'                 => $data['suhu_tubuh'] ?? null,
            'nadi'                       => $data['nadi'] ?? null,
            'pernapasan'                 => $data['pernapasan'] ?? null,
            'saturasi'                   => $data['saturasi'] ?? null,
            'hasil_pemeriksaan_fisik'    => $data['hasil_pemeriksaan_fisik'] ?? null,
            'hasil_pemeriksaan_penunjang' => $data['hasil_pemeriksaan_penunjang'] ?? null,

            // Assessment (A)
            'diagnosis'                  => $data['diagnosis'],
            'diagnosis_banding'          => $data['diagnosis_banding'] ?? null,
            'kode_icd10'                 => $data['kode_icd10'] ?? null,

            // Plan (P) yang masih berupa teks (jika ingin diubah jadi pivot, bisa dihapus)
            'rencana_tindakan'           => $data['rencana_tindakan'] ?? null,
            'edukasi_pasien'             => $data['edukasi_pasien'] ?? null,
            'rencana_kontrol'            => $data['rencana_kontrol'] ?? null,
            'rujukan'                    => $data['rujukan'] ?? null,

            // Metadata
            'status'                     => $data['status'],
            'lampiran'                   => $data['lampiran'] ?? null,

            // Audit Trail
            'created_by'                 => $data['created_by'],
            'updated_by'                 => $data['updated_by'],
        ]);

        // === 2) Simpan baris Observasi (snapshot Objective awal) ===
        Observation::create([
            'medical_record_id' => $mr->id,
            'observed_at'       => $mr->recorded_at,
            'suhu'              => $data['suhu_tubuh'] ?? null,
            'tekanan_darah'     => $data['tekanan_darah'] ?? null,
            'nadi'              => $data['nadi'] ?? null,
            'pernapasan'        => $data['pernapasan'] ?? null,
            'saturasi'          => $data['saturasi'] ?? null,
            'catatan'           => 'Observasi awal (snapshot Objective)',
            'observer_id'       => session('user_id'),
        ]);

        // === 3) Simpan Data Resep Obat ke tabel resep_obats ===
        if (!empty($data['resep_obat'])) {
            foreach ($data['resep_obat'] as $r) {
                // Pastikan minimal obat_id & dosis & kuantitas terisi
                ResepObat::create([
                    'medical_record_id' => $mr->id,
                    'obat_id'           => $r['obat_id'],
                    'dosis'             => $r['dosis'],
                    'kuantitas'         => $r['kuantitas'],
                    'keterangan'        => $r['keterangan'] ?? null,
                ]);
            }
        }

        // === 4) Attach Layanan ke pivot medical_record_layanan ===
        if (!empty($data['layanans'])) {
            // Karena kita hanya punya ID layanan saja, kita attach tanpa pivot tambahan.
            // Jika Anda butuh menyimpan kuantitas/harga, gunakan attach([... => ['kuantitas'=>...,'harga_satuan'=>...] ])
            $mr->layanans()->sync($data['layanans']);
        }

        // === 5) Attach Tindakan ke pivot medical_record_tindakan ===
        if (!empty($data['tindakans'])) {
            // Sama: kalau hanya ID tindakan, sync saja.
            $mr->tindakans()->sync($data['tindakans']);
        }

        return redirect()
            ->route('medicalrecord.index')
            ->with('success', 'Rekam medis dan data pivot berhasil dibuat.');
    }


    /**
     * Display the specified medical record.
     */
    public function show(MedicalRecord $medicalrecord)
    {
        // Dengan route resource, parameter $medicalrecord sudah otomatis di‐resolve dari ID.
        $record = $medicalrecord->load(['patient', 'doctor', 'creator', 'updater']);

        return view('medical-record.show', compact('record'));
    }

    /**
     * Show the form for editing the specified medical record.
     */
    public function edit(MedicalRecord $medicalrecord)
    {
        // Load relasi yang diperlukan
        $record    = $medicalrecord->load([
            'patient',
            'doctor',
            'resepObats',        // untuk menampilkan baris resep lama
            'layanans',          // pivot layanan
            'tindakans',         // pivot tindakan
        ]);

        // Master‐data untuk dropdown/autocomplete
        $patients  = Patiens::orderBy('nama')->get();
        $doctors   = Users::whereIn('role_id', [3, 4])->orderBy('nama')->get();
        $obats     = Obat::orderBy('nama')->get();
        $layanans  = Layanan::orderBy('nama')->get();
        $tindakans = Tindakan::orderBy('nama')->get();

        return view('medical-record.edit', compact(
            'record',
            'patients',
            'doctors',
            'obats',
            'layanans',
            'tindakans'
        ));
    }

    /**
     * Update the specified medical record in storage.
     */
     public function update(Request $request, MedicalRecord $medicalrecord)
    {
        // 1) Filter baris resep yang kosong atau setengah terisi
        $all = $request->all();
        if (isset($all['resep_obat']) && is_array($all['resep_obat'])) {
            $filtered = [];
            foreach ($all['resep_obat'] as $idx => $row) {
                $obatId    = data_get($row, 'obat_id');
                $dosis     = data_get($row, 'dosis');
                $kuantitas = data_get($row, 'kuantitas');

                // Buang baris yang benar‐benar kosong
                if (
                    (is_null($obatId)    || $obatId === '') &&
                    (is_null($dosis)     || trim($dosis) === '') &&
                    (is_null($kuantitas) || $kuantitas === '')
                ) {
                    continue;
                }

                // Jika hanya setengah terisi (boleh dibuang agar validator menghasilkan error),
                // maka skip agar validasi required_with ikut memeriksa.
                if (
                    empty($obatId) || trim($dosis) === '' || empty($kuantitas)
                ) {
                    continue;
                }

                $filtered[$idx] = $row;
            }
            // Re‐index array supaya urutan indeks menjadi 0,1,2…
            $filtered = array_values($filtered);
            $request->merge(['resep_obat' => $filtered]);
        }

        // 2) Aturan validasi (samakan dengan store)
        $rules = [
            // Relasi dasar
            'patient_id'             => ['required', 'exists:patiens,id'],
            'doctor_id'              => ['required', 'exists:users,id'],
            'recorded_at'            => ['nullable', 'date'],

            // Subjective (S)
            'keluhan_utama'          => ['required', 'string', 'max:255'],
            'anamnesa'               => ['required', 'string'],
            'riwayat_penyakit'       => ['nullable', 'string'],
            'riwayat_alergi'         => ['nullable', 'string', 'max:255'],
            'riwayat_pengobatan'     => ['nullable', 'string'],

            // Objective (O)
            'tinggi_badan'                   => ['nullable', 'integer'],
            'berat_badan'                    => ['nullable', 'integer'],
            'tekanan_darah'                  => ['nullable', 'string', 'max:20'],
            'suhu_tubuh'                     => ['nullable', 'numeric'],
            'nadi'                           => ['nullable', 'integer'],
            'pernapasan'                     => ['nullable', 'integer'],
            'saturasi'                       => ['nullable', 'integer', 'min:0', 'max:100'],
            'hasil_pemeriksaan_fisik'        => ['nullable', 'string'],
            'hasil_pemeriksaan_penunjang'    => ['nullable', 'string'],

            // Assessment (A)
            'diagnosis'               => ['required', 'string'],
            'diagnosis_banding'       => ['nullable', 'string'],
            'kode_icd10'              => ['nullable', 'string', 'max:10'],

            // Plan (P)
            'resep_obat'                => ['nullable', 'array'],
            'resep_obat.*.obat_id'      => [
                'nullable',
                'exists:obats,id',
                'required_with:resep_obat.*.dosis,resep_obat.*.kuantitas',
            ],
            'resep_obat.*.dosis'        => [
                'nullable',
                'string',
                'required_with:resep_obat.*.obat_id,resep_obat.*.kuantitas',
            ],
            'resep_obat.*.kuantitas'    => [
                'nullable',
                'integer',
                'min:1',
                'required_with:resep_obat.*.obat_id,resep_obat.*.dosis',
            ],
            'resep_obat.*.keterangan'   => ['nullable', 'string'],

            // Layanan & tindakan
            'layanans'   => ['nullable', 'array'],
            'layanans.*' => ['exists:layanans,id'],
            'tindakans'   => ['nullable', 'array'],
            'tindakans.*' => ['exists:tindakans,id'],

            'rencana_tindakan'        => ['nullable', 'string'],
            'edukasi_pasien'          => ['nullable', 'string'],
            'rencana_kontrol'         => ['nullable', 'date'],
            'rujukan'                 => ['nullable', 'string'],

            // Metadata
            'status'                  => ['required', 'in:draft,final,revisi'],
            'lampiran.*'              => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->route('medicalrecord.edit', $medicalrecord->id)
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Jika tidak memasukkan recorded_at, gunakan timestamp sekarang
        if (empty($data['recorded_at'])) {
            $data['recorded_at'] = Carbon::now();
        }

        // Simpan file lampiran jika ada
        if ($request->hasFile('lampiran')) {
            $paths = [];
            foreach ($request->file('lampiran') as $file) {
                $paths[] = $file->store('medical_attachments', 'public');
            }
            $data['lampiran'] = json_encode($paths);
        }

        // Set audit trail
        $data['updated_by'] = session('user_id');

        // 3) Update kolom utama di tabel medical_records
        $medicalrecord->update([
            'patient_id'                 => $data['patient_id'],
            'doctor_id'                  => $data['doctor_id'],
            'recorded_at'                => $data['recorded_at'],

            'keluhan_utama'              => $data['keluhan_utama'],
            'anamnesa'                   => $data['anamnesa'],
            'riwayat_penyakit'           => $data['riwayat_penyakit'] ?? null,
            'riwayat_alergi'             => $data['riwayat_alergi'] ?? null,
            'riwayat_pengobatan'         => $data['riwayat_pengobatan'] ?? null,

            'tinggi_badan'               => $data['tinggi_badan'] ?? null,
            'berat_badan'                => $data['berat_badan'] ?? null,
            'tekanan_darah'              => $data['tekanan_darah'] ?? null,
            'suhu_tubuh'                 => $data['suhu_tubuh'] ?? null,
            'nadi'                       => $data['nadi'] ?? null,
            'pernapasan'                 => $data['pernapasan'] ?? null,
            'saturasi'                   => $data['saturasi'] ?? null,
            'hasil_pemeriksaan_fisik'    => $data['hasil_pemeriksaan_fisik'] ?? null,
            'hasil_pemeriksaan_penunjang' => $data['hasil_pemeriksaan_penunjang'] ?? null,

            'diagnosis'                  => $data['diagnosis'],
            'diagnosis_banding'          => $data['diagnosis_banding'] ?? null,
            'kode_icd10'                 => $data['kode_icd10'] ?? null,

            'rencana_tindakan'           => $data['rencana_tindakan'] ?? null,
            'edukasi_pasien'             => $data['edukasi_pasien'] ?? null,
            'rencana_kontrol'            => $data['rencana_kontrol'] ?? null,
            'rujukan'                    => $data['rujukan'] ?? null,

            'status'                     => $data['status'],
            'lampiran'                   => $data['lampiran'] ?? null,

            'updated_by'                 => $data['updated_by'],
        ]);

        // 4) Simpan (snapshot) observasi terbaru jika diperlukan
        // (biasanya tidak perlu membuat baris observasi baru pada update—opsional)
        // Observation::create([...]);

        // 5) Simpan ulang resep obat:
        //    Hapus dulu resep_obats lama, lalu buat yang baru dari $data['resep_obat']
        ResepObat::where('medical_record_id', $medicalrecord->id)->delete();
        if (!empty($data['resep_obat'])) {
            foreach ($data['resep_obat'] as $r) {
                ResepObat::create([
                    'medical_record_id' => $medicalrecord->id,
                    'obat_id'           => $r['obat_id'],
                    'dosis'             => $r['dosis'],
                    'kuantitas'         => $r['kuantitas'],
                    'keterangan'        => $r['keterangan'] ?? null,
                ]);
            }
        }

        // 6) Sync layanan pivot (tanpa tambahan field lain),
        //    atau jika ada tambahan kuantitas/harga, bisa diganti attach
        if (!empty($data['layanans'])) {
            $medicalrecord->layanans()->sync($data['layanans']);
        } else {
            $medicalrecord->layanans()->detach();
        }

        // 7) Sync tindakan pivot
        if (!empty($data['tindakans'])) {
            $medicalrecord->tindakans()->sync($data['tindakans']);
        } else {
            $medicalrecord->tindakans()->detach();
        }

        return redirect()
            ->route('medicalrecord.index')
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    /**
     * Remove the specified medical record from storage.
     */
    public function destroy(MedicalRecord $medicalrecord)
    {
        $medicalrecord->delete();

        return redirect()
            ->route('medicalrecord.index')
            ->with('success', 'Rekam medis berhasil dihapus.');
    }
}
