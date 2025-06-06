{{-- resources/views/medical-record/create.blade.php --}}
@extends('template.index')

@section('title', 'Tambah Rekam Medis')

@section('content')
    <div class="container py-4" style="background-color: #e8f1ff;">
        <h3 class="mb-4">Tambah Rekam Medis (Format SOAP)</h3>

        <div class="card mb-4 shadow-sm rounded-3">
            <div class="card-body">
                <form id="formMedicalRecord" action="{{ route('medicalrecord.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Tampilkan pesan validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row gy-3">
                        {{-- === Wajib: Pilih Pasien & Dokter === --}}
                        <div class="col-md-6">
                            <label for="patient_name_input" class="form-label">Nama Pasien</label>
                            <input type="text" id="patient_name_input" name="patient_name_input" class="form-control"
                                placeholder="Ketik nama pasien..." list="patients_list"
                                value="{{ old('patient_name_input') }}" autocomplete="off" required>
                            <input type="hidden" id="patient_id" name="patient_id" value="{{ old('patient_id') }}">
                            <datalist id="patients_list">
                                @foreach ($patients as $patient)
                                    <option data-id="{{ $patient->patient->id }}"
                                        value="{{ $patient->patient->nama }} ({{ $patient->patient->mr_number }})"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label for="doctor_name_input" class="form-label">Dokter Pemeriksa</label>
                            <input type="text" id="doctor_name_input" name="doctor_name_input" class="form-control"
                                placeholder="Ketik nama dokter..." list="doctors_list"
                                value="{{ old('doctor_name_input') }}" autocomplete="off" required>
                            <input type="hidden" id="doctor_id" name="doctor_id" value="{{ old('doctor_id') }}">
                            <datalist id="doctors_list">
                                @foreach ($doctors as $doctor)
                                    <option data-id="{{ $doctor->id }}"
                                        value="{{ $doctor->nama }} ({{ $doctor->role?->nama }})"></option>
                                @endforeach
                            </datalist>
                        </div>

                        {{-- === Recorded At (Tanggal Pemeriksaan) === --}}
                        <div class="col-md-4">
                            <label for="recorded_at" class="form-label">Tanggal Pemeriksaan</label>
                            <input type="date" id="recorded_at" name="recorded_at" class="form-control"
                                value="{{ old('recorded_at', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                        </div>

                        {{-- ===================== --}}
                        {{-- Hidden input untuk status --}}
                        <input type="hidden" name="status" id="status-field" value="draft">
                        {{-- ===================== --}}

                        {{-- ========================================= --}}
                        {{--       BAGIAN S: SUBJECTIVE (Show/Hide)   --}}
                        {{-- ========================================= --}}
                        <div class="col-12 mt-4">
                            {{-- Button header yang akan men-toggle collapse --}}
                            <button class="btn btn-outline-primary w-100 text-start" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseSubjective" aria-expanded="true"
                                aria-controls="collapseSubjective">
                                <strong>Subjective (S)</strong>
                            </button>
                        </div>
                        <div id="collapseSubjective" class="collapse show col-12">
                            <div class="card card-body border-secondary">
                                <div class="row gy-3">
                                    <div class="col-md-12">
                                        <label for="keluhan_utama" class="form-label">Keluhan Utama</label>
                                        <input type="text" id="keluhan_utama" name="keluhan_utama" class="form-control"
                                            placeholder="Contoh: Batuk kering sejak 4 hari..."
                                            value="{{ old('keluhan_utama') }}" required>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="anamnesa" class="form-label">Anamnesa (Riwayat Penyakit
                                            Sekarang)</label>
                                        <textarea id="anamnesa" name="anamnesa" class="form-control" rows="3" placeholder="Detail anamnesa pasien..."
                                            required>{{ old('anamnesa') }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit Dahulu</label>
                                        <textarea id="riwayat_penyakit" name="riwayat_penyakit" class="form-control" rows="2"
                                            placeholder="Misal: Hipertensi, DM, dll...">{{ old('riwayat_penyakit') }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="riwayat_alergi" class="form-label">Riwayat Alergi</label>
                                        <input type="text" id="riwayat_alergi" name="riwayat_alergi"
                                            class="form-control" placeholder="Misal: Alergi obat sulfa, debu, dll"
                                            value="{{ old('riwayat_alergi') }}">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="riwayat_pengobatan" class="form-label">Riwayat Pengobatan Saat
                                            Ini</label>
                                        <textarea id="riwayat_pengobatan" name="riwayat_pengobatan" class="form-control" rows="2"
                                            placeholder="Obat-obatan yang sedang dikonsumsi...">{{ old('riwayat_pengobatan') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- ========================================= --}}
                        {{--       BAGIAN O: OBJECTIVE (Show/Hide)    --}}
                        {{-- ========================================= --}}
                        <div class="col-12 mt-4">
                            <button class="btn btn-outline-primary w-100 text-start" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseObjective" aria-expanded="false"
                                aria-controls="collapseObjective">
                                <strong>Objective (O)</strong>
                            </button>
                        </div>
                        <div id="collapseObjective" class="collapse col-12">
                            <div class="card card-body border-secondary">
                                <div class="row gy-3">
                                    <div class="col-md-3">
                                        <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                        <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan"
                                            value="{{ old('tinggi_badan') }}" placeholder="145">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                        <input type="number" class="form-control" id="berat_badan" name="berat_badan"
                                            value="{{ old('berat_badan') }}" placeholder="50">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tekanan_darah" class="form-label">Tekanan Darah (mmHg)</label>
                                        <input type="text" class="form-control" id="tekanan_darah"
                                            name="tekanan_darah" value="{{ old('tekanan_darah') }}"
                                            placeholder="120/80">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="suhu_tubuh" class="form-label">Suhu Tubuh (°C)</label>
                                        <input type="number" step="0.1" class="form-control" id="suhu_tubuh"
                                            name="suhu_tubuh" value="{{ old('suhu_tubuh') }}" placeholder="36.7">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="nadi" class="form-label">Nadi (x/menit)</label>
                                        <input type="number" class="form-control" id="nadi" name="nadi"
                                            value="{{ old('nadi') }}" placeholder="80">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="pernapasan" class="form-label">Pernapasan (x/menit)</label>
                                        <input type="number" class="form-control" id="pernapasan" name="pernapasan"
                                            value="{{ old('pernapasan') }}" placeholder="18">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="saturasi" class="form-label">Saturasi Oksigen (%)</label>
                                        <input type="number" step="1" class="form-control" id="saturasi"
                                            name="saturasi" value="{{ old('saturasi') }}" placeholder="98">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="hasil_pemeriksaan_fisik" class="form-label">Hasil Pemeriksaan
                                            Fisik</label>
                                        <textarea id="hasil_pemeriksaan_fisik" name="hasil_pemeriksaan_fisik" class="form-control" rows="3"
                                            placeholder="Misal: Faring hiperemis, tidak ada pembesaran kelenjar...">{{ old('hasil_pemeriksaan_fisik') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="hasil_pemeriksaan_penunjang" class="form-label">Hasil Pemeriksaan
                                            Penunjang (Lab/Radiologi)</label>
                                        <textarea id="hasil_pemeriksaan_penunjang" name="hasil_pemeriksaan_penunjang" class="form-control" rows="3"
                                            placeholder="Ringkasan hasil lab, X-ray, EKG, dll...">{{ old('hasil_pemeriksaan_penunjang') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- ========================================= --}}
                        {{--       BAGIAN A: ASSESSMENT (Show/Hide)   --}}
                        {{-- ========================================= --}}
                        <div class="col-12 mt-4">
                            <button class="btn btn-outline-primary w-100 text-start" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseAssessment" aria-expanded="false"
                                aria-controls="collapseAssessment">
                                <strong>Assessment (A)</strong>
                            </button>
                        </div>
                        <div id="collapseAssessment" class="collapse col-12">
                            <div class="card card-body border-secondary">
                                <div class="row gy-3">
                                    <div class="col-md-6">
                                        <label for="diagnosis" class="form-label">Diagnosis Utama</label>
                                        <textarea id="diagnosis" name="diagnosis" class="form-control" rows="2"
                                            placeholder="Contoh: Faringitis akut nonspesifik" required>{{ old('diagnosis') }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="diagnosis_banding" class="form-label">Diagnosis Banding
                                            (opsional)</label>
                                        <textarea id="diagnosis_banding" name="diagnosis_banding" class="form-control" rows="2"
                                            placeholder="Jika ada diagnosis banding...">{{ old('diagnosis_banding') }}</textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="kode_icd10" class="form-label">Kode ICD-10 (opsional)</label>
                                        <input type="text" id="kode_icd10" name="kode_icd10" class="form-control"
                                            value="{{ old('kode_icd10') }}" placeholder="J02.9">
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- ========================================= --}}
                        {{--         BAGIAN P: PLAN (Show/Hide)       --}}
                        {{-- ========================================= --}}
                        <div class="col-12 mt-4">
                            <button class="btn btn-outline-primary w-100 text-start" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapsePlan" aria-expanded="false"
                                aria-controls="collapsePlan">
                                <strong>Plan (P)</strong>
                            </button>
                        </div>
                        <div id="collapsePlan" class="collapse col-12">
                            <div class="card card-body border-secondary">
                                <div class="row gy-3">

                                    {{-- Rese<span style="color:red">*</span>p Obat / Terapi --}}
                                    <div class="col-md-12">
                                        <label class="form-label">Resep Obat / Terapi</label>
                                        <table class="table table-bordered" id="table-resep">
                                            <thead>
                                                <tr>
                                                    <th>Obat</th>
                                                    <th>Dosis</th>
                                                    <th>Kuantitas</th>
                                                    <th>Keterangan</th>
                                                    <th style="width: 50px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div style="position: relative;">
                                                            <!-- Ini kotak teks untuk mengetik nama obat -->
                                                            <input type="text" name="resep_obat[0][obat_nama]"
                                                                class="form-control obat-input"
                                                                placeholder="Ketik nama obat..." autocomplete="off">
                                                            <!-- Hidden input untuk menyimpan ID obat -->
                                                            <input type="hidden" name="resep_obat[0][obat_id]"
                                                                class="obat-id-input" value="">
                                                            <!-- Inilah container dropdown suggestion -->
                                                            <div class="suggestions-list"
                                                                style="position: absolute;
                                                                top: 100%;
                                                                left: 0;
                                                                right: 0;
                                                                z-index: 1000;
                                                                background: white;
                                                                border: 1px solid #ddd;
                                                                display: none;
                                                                max-height: 200px;
                                                                overflow-y: auto;">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="resep_obat[0][dosis]"
                                                            class="form-control" placeholder="Misal: 2x sehari 500mg">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="resep_obat[0][kuantitas]"
                                                            class="form-control" placeholder="Qty" min="1">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="resep_obat[0][keterangan]"
                                                            class="form-control" placeholder="Keterangan (opsional)">
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger btn-remove-resep"
                                                            title="Hapus baris">&times;
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" id="btn-add-resep" class="btn btn-sm btn-secondary">
                                            + Tambah Baris Resep
                                        </button>


                                    </div>

                                    {{-- Multi‐select Layanan --}}
                                    <div class="col-md-6">
                                        <label for="layanan-input" class="form-label">Layanan / Jasa Medis</label>
                                        <div style="position: relative;">
                                            <input type="text" id="layanan-input" class="form-control"
                                                placeholder="Ketik nama layanan..." autocomplete="off">
                                            <div class="suggestions-layanan"
                                                style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000;
                                                background: white; border: 1px solid #ddd; display: none; max-height: 200px; overflow-y: auto;">
                                            </div>
                                        </div>
                                        <!-- Container untuk tag terpilih -->
                                        <div id="layanan-tags" class="mt-1"></div>
                                        <!-- Container hidden input untuk id layanan -->
                                        <div id="layanan-hidden-inputs"></div>
                                        <small class="text-muted">Klik satu per satu untuk menambah layanan</small>
                                    </div>

                                    {{-- Multi‐select Tindakan --}}
                                    <div class="col-md-6">
                                        <label for="tindakan-input" class="form-label">Tindakan / Prosedur</label>
                                        <div style="position: relative;">
                                            <input type="text" id="tindakan-input" class="form-control"
                                                placeholder="Ketik nama tindakan..." autocomplete="off">
                                            <div class="suggestions-tindakan"
                                                style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000;
                                                background: white; border: 1px solid #ddd; display: none; max-height: 200px; overflow-y: auto;">
                                            </div>
                                        </div>
                                        <!-- Container untuk tag terpilih -->
                                        <div id="tindakan-tags" class="mt-1"></div>
                                        <!-- Container hidden input untuk id tindakan -->
                                        <div id="tindakan-hidden-inputs"></div>
                                        <small class="text-muted">Klik satu per satu untuk menambah tindakan</small>
                                    </div>



                                    {{-- 5) Edukasi Pasien --}}
                                    <div class="col-md-6">
                                        <label for="edukasi_pasien" class="form-label">Edukasi Pasien</label>
                                        <textarea name="edukasi_pasien" id="edukasi_pasien"
                                            class="form-control @error('edukasi_pasien') is-invalid @enderror" rows="3"
                                            placeholder="Tuliskan materi edukasi untuk pasien…">{{ old('edukasi_pasien') }}</textarea>
                                        @error('edukasi_pasien')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- 4) Rencana Tindakan --}}
                                    <div class="col-md-6">
                                        <label for="rencana_tindakan" class="form-label">Deskripsi Tindakan</label>
                                        <textarea name="rencana_tindakan" id="rencana_tindakan"
                                            class="form-control @error('rencana_tindakan') is-invalid @enderror" rows="3"
                                            placeholder="Tuliskan rencana tindakan…">{{ old('rencana_tindakan') }}</textarea>
                                        @error('rencana_tindakan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- 6) Rencana Kontrol --}}
                                    <div class="col-md-6">
                                        <label for="rencana_kontrol" class="form-label">Rencana Kontrol</label>
                                        <input type="date" name="rencana_kontrol" id="rencana_kontrol"
                                            class="form-control @error('rencana_kontrol') is-invalid @enderror"
                                            value="{{ old('rencana_kontrol') }}">
                                        @error('rencana_kontrol')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Metadata (opsional) --}}
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status Pemeriksaan</label>
                                        <select id="status" name="status" class="form-control" disabled>
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft
                                            </option>
                                            <option value="final" {{ old('status') == 'final' ? 'selected' : '' }}>Final
                                            </option>
                                            <option value="revisi" {{ old('status') == 'revisi' ? 'selected' : '' }}>
                                                Revisi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lampiran" class="form-label">Lampiran (Lab/Rontgen)</label>
                                        <input type="file" id="lampiran" name="lampiran[]" class="form-control"
                                            multiple>
                                        <small class="text-muted">Boleh upload banyak file (.jpg, .png, .pdf)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" id="btnSubmitMedicalRecord"
                                class="btn btn-success px-4">Simpan</button>
                        </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1) Persiapkan data master dari Laravel → JS
            let obatData = @json($obats->map(fn($o) => ['id' => $o->id, 'nama' => $o->nama])->toArray());
            let layananData = @json($layanans->map(fn($l) => ['id' => $l->id, 'nama' => $l->nama])->toArray());
            let tindakanData = @json($tindakans->map(fn($t) => ['id' => $t->id, 'nama' => $t->nama])->toArray());

            console.log(obatData.length, layananData.length, tindakanData.length);
            // 2) Helper: filter dan slice max 10
            function filterAndSlice(arr, keyword) {
                const q = keyword.trim().toLowerCase();
                if (!q) return [];
                return arr
                    .filter(item => item.nama.toLowerCase().includes(q))
                    .slice(0, 10);
            }

            // =========================================================================
            // >>>> AUTOCOMPLETE OBAT per baris [hanya satu kali definisi obatData]
            // =========================================================================
            const tableResep = document.querySelector('#table-resep tbody');
            tableResep.addEventListener('input', function(e) {
                if (e.target && e.target.classList.contains('obat-input')) {
                    const inputEl = e.target;
                    const keyword = inputEl.value;
                    const suggestionBox = inputEl.parentElement.querySelector('.suggestions-list');
                    suggestionBox.innerHTML = '';

                    if (!keyword.trim()) {
                        suggestionBox.style.display = 'none';
                        return;
                    }

                    const matches = filterAndSlice(obatData, keyword);
                    if (matches.length === 0) {
                        suggestionBox.style.display = 'none';
                        return;
                    }

                    matches.forEach(item => {
                        const div = document.createElement('div');
                        div.classList.add('suggestion-item');
                        div.style.padding = '6px 8px';
                        div.style.cursor = 'pointer';
                        div.textContent = item.nama;
                        div.dataset.obatId = item.id;
                        div.dataset.obatNama = item.nama;
                        div.addEventListener('click', function() {
                            // Ketika user klik salah satu nama obat:
                            inputEl.value = this.dataset.obatNama;
                            const hiddenIdInput = inputEl.parentElement.querySelector(
                                '.obat-id-input');
                            hiddenIdInput.value = this.dataset.obatId;
                            suggestionBox.style.display = 'none';
                        });
                        suggestionBox.appendChild(div);
                    });

                    suggestionBox.style.display = 'block';
                }
            });

            // Hide suggestion jika klik di luar
            document.addEventListener('click', function(e) {
                document.querySelectorAll('.suggestions-list').forEach(box => {
                    if (
                        !box.contains(e.target) &&
                        !(box.previousElementSibling && box.previousElementSibling.contains(e
                            .target))
                    ) {
                        box.style.display = 'none';
                    }
                });
            });

            // =========================================================================
            // >>>> TAMBAH / HAPUS BARIS RESEP
            // =========================================================================
            let rowIndex = 1; // baris pertama dianggap index 0
            const btnAddResep = document.getElementById('btn-add-resep');
            btnAddResep.addEventListener('click', function() {
                const firstRow = tableResep.querySelector('tr');
                const newRow = firstRow.cloneNode(true);

                // Ganti nama "resep_obat[0][…]" → "resep_obat[rowIndex][…]"
                newRow.querySelectorAll('input').forEach(elem => {
                    const oldName = elem.getAttribute('name');
                    if (!oldName) return;
                    const newName = oldName.replace(/\[0\]/g, `[${rowIndex}]`);
                    elem.setAttribute('name', newName);
                    elem.value = ''; // kosongkan value agar user input baru
                });

                // Reset suggestion-list di baris baru:
                const sugBox = newRow.querySelector('.suggestions-list');
                if (sugBox) {
                    sugBox.innerHTML = '';
                    sugBox.style.display = 'none';
                }

                tableResep.appendChild(newRow);
                rowIndex++;
            });

            // Event delegation untuk tombol hapus baris resep
            tableResep.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('btn-remove-resep')) {
                    const row = e.target.closest('tr');
                    const totalRows = tableResep.querySelectorAll('tr').length;
                    if (totalRows > 1) {
                        row.remove();
                    } else {
                        // Kalau hanya tersisa 1 baris, cukup reset isinya
                        row.querySelectorAll('input').forEach(el => el.value = '');
                        const box = row.querySelector('.suggestions-list');
                        if (box) {
                            box.innerHTML = '';
                            box.style.display = 'none';
                        }
                    }
                }
            });


            // =========================================================================
            // >>>> AUTOCOMPLETE & MULTI‐SELECT LAYANAN
            // =========================================================================
            let layananSelected = [];
            const layananInput = document.getElementById('layanan-input');
            const layananSuggestionBox = document.querySelector('.suggestions-layanan');
            const layananTagsContainer = document.getElementById('layanan-tags');
            const layananHiddenInputs = document.getElementById('layanan-hidden-inputs');

            layananInput.addEventListener('input', function() {
                layananSuggestionBox.innerHTML = '';
                const keyword = this.value.trim().toLowerCase();
                if (!keyword) {
                    layananSuggestionBox.style.display = 'none';
                    return;
                }
                const matches = layananData
                    .filter(item => item.nama.toLowerCase().includes(keyword))
                    .filter(item => !layananSelected.some(sel => sel.id == item.id))
                    .slice(0, 10);

                if (matches.length === 0) {
                    layananSuggestionBox.style.display = 'none';
                    return;
                }

                matches.forEach(item => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.style.padding = '6px 8px';
                    div.style.cursor = 'pointer';
                    div.textContent = item.nama;
                    div.dataset.layananId = item.id;
                    div.dataset.layananNama = item.nama;
                    div.addEventListener('click', function() {
                        addLayananTag({
                            id: this.dataset.layananId,
                            nama: this.dataset.layananNama
                        });
                        layananInput.value = '';
                        layananSuggestionBox.style.display = 'none';
                    });
                    layananSuggestionBox.appendChild(div);
                });

                layananSuggestionBox.style.display = 'block';
            });

            document.addEventListener('click', function(e) {
                if (
                    !layananInput.contains(e.target) &&
                    !layananSuggestionBox.contains(e.target)
                ) {
                    layananSuggestionBox.style.display = 'none';
                }
            });

            function addLayananTag(item) {
                layananSelected.push(item);
                const tag = document.createElement('span');
                tag.classList.add('badge', 'bg-secondary', 'me-1', 'mb-1');
                tag.style.cursor = 'default';
                tag.textContent = item.nama + ' ';
                const xBtn = document.createElement('span');
                xBtn.textContent = '×';
                xBtn.style.marginLeft = '6px';
                xBtn.style.cursor = 'pointer';
                xBtn.addEventListener('click', function() {
                    removeLayananTag(item.id);
                });
                tag.appendChild(xBtn);
                layananTagsContainer.appendChild(tag);

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'layanans[]';
                hidden.value = item.id;
                hidden.id = 'layanan-hidden-' + item.id;
                layananHiddenInputs.appendChild(hidden);
            }

            function removeLayananTag(id) {
                layananSelected = layananSelected.filter(item => item.id != id);
                layananTagsContainer.querySelectorAll('span').forEach(ch => {
                    if (ch.textContent.trim().startsWith(getLayananNamaById(id))) {
                        ch.remove();
                    }
                });
                const hidden = document.getElementById('layanan-hidden-' + id);
                if (hidden) hidden.remove();
            }

            function getLayananNamaById(id) {
                const found = layananData.find(item => item.id == id);
                return found ? found.nama : '';
            }


            // =========================================================================
            // >>>> AUTOCOMPLETE & MULTI‐SELECT TINDAKAN
            // =========================================================================
            let tindakanSelected = [];
            const tindakanInput = document.getElementById('tindakan-input');
            const tindakanSuggestionBox = document.querySelector('.suggestions-tindakan');
            const tindakanTagsContainer = document.getElementById('tindakan-tags');
            const tindakanHiddenInputs = document.getElementById('tindakan-hidden-inputs');

            tindakanInput.addEventListener('input', function() {
                tindakanSuggestionBox.innerHTML = '';
                const keyword = this.value.trim().toLowerCase();
                if (!keyword) {
                    tindakanSuggestionBox.style.display = 'none';
                    return;
                }
                const matches = tindakanData
                    .filter(item => item.nama.toLowerCase().includes(keyword))
                    .filter(item => !tindakanSelected.some(sel => sel.id == item.id))
                    .slice(0, 10);

                if (matches.length === 0) {
                    tindakanSuggestionBox.style.display = 'none';
                    return;
                }

                matches.forEach(item => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.style.padding = '6px 8px';
                    div.style.cursor = 'pointer';
                    div.textContent = item.nama;
                    div.dataset.tindakanId = item.id;
                    div.dataset.tindakanNama = item.nama;
                    div.addEventListener('click', function() {
                        addTindakanTag({
                            id: this.dataset.tindakanId,
                            nama: this.dataset.tindakanNama
                        });
                        tindakanInput.value = '';
                        tindakanSuggestionBox.style.display = 'none';
                    });
                    tindakanSuggestionBox.appendChild(div);
                });

                tindakanSuggestionBox.style.display = 'block';
            });

            document.addEventListener('click', function(e) {
                if (
                    !tindakanInput.contains(e.target) &&
                    !tindakanSuggestionBox.contains(e.target)
                ) {
                    tindakanSuggestionBox.style.display = 'none';
                }
            });

            function addTindakanTag(item) {
                tindakanSelected.push(item);
                const tag = document.createElement('span');
                tag.classList.add('badge', 'bg-secondary', 'me-1', 'mb-1');
                tag.style.cursor = 'default';
                tag.textContent = item.nama + ' ';
                const xBtn = document.createElement('span');
                xBtn.textContent = '×';
                xBtn.style.marginLeft = '6px';
                xBtn.style.cursor = 'pointer';
                xBtn.addEventListener('click', function() {
                    removeTindakanTag(item.id);
                });
                tag.appendChild(xBtn);
                tindakanTagsContainer.appendChild(tag);

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'tindakans[]';
                hidden.value = item.id;
                hidden.id = 'tindakan-hidden-' + item.id;
                tindakanHiddenInputs.appendChild(hidden);
            }

            function removeTindakanTag(id) {
                tindakanSelected = tindakanSelected.filter(item => item.id != id);
                tindakanTagsContainer.querySelectorAll('span').forEach(ch => {
                    if (ch.textContent.trim().startsWith(getTindakanNamaById(id))) {
                        ch.remove();
                    }
                });
                const hidden = document.getElementById('tindakan-hidden-' + id);
                if (hidden) hidden.remove();
            }

            function getTindakanNamaById(id) {
                const found = tindakanData.find(item => item.id == id);
                return found ? found.nama : '';
            }

            // =========================================================================
            // >>>> Pasien & Dokter (tetap sama)
            // =========================================================================
            const patientInput = document.getElementById('patient_name_input');
            const patientHidden = document.getElementById('patient_id');
            const patientDataList = document.getElementById('patients_list');
            patientInput.addEventListener('input', function() {
                const val = this.value;
                const opt = Array.from(patientDataList.options).find(o => o.value === val);
                patientHidden.value = opt ? opt.getAttribute('data-id') : '';
            });

            const doctorInput = document.getElementById('doctor_name_input');
            const doctorHidden = document.getElementById('doctor_id');
            const doctorDataList = document.getElementById('doctors_list');
            doctorInput.addEventListener('input', function() {
                const val = this.value;
                const opt = Array.from(doctorDataList.options).find(o => o.value === val);
                doctorHidden.value = opt ? opt.getAttribute('data-id') : '';
            });

        });
    </script>

    {{-- Pastikan SweetAlert2 sudah dimuat (misal via CDN di layout) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formMedicalRecord');
            const btnSubmit = document.getElementById('btnSubmitMedicalRecord');
            const statusField = document.getElementById('status-field');

            btnSubmit.addEventListener('click', function(e) {
                e.preventDefault(); // cegah submit langsung

                // Tampilkan SweetAlert2 dengan dua pilihan
                Swal.fire({
                    title: 'Simpan Rekam Medis sebagai:',
                    text: "Pilih salah satu di bawah.",
                    icon: 'question',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Simpan Final',
                    denyButtonText: 'Simpan ke Draft',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User memilih “Simpan Final”
                        statusField.value = 'final';
                        form.submit();
                    } else if (result.isDenied) {
                        // User memilih “Simpan ke Draft”
                        statusField.value = 'draft';
                        form.submit();
                    } else {
                        // User memilih “Batal” (atau klik di luar)
                        // Jangan submit; cukup tutup SweetAlert
                        return;
                    }
                });
            });
        });
    </script>


@endsection

{{-- ------------------------------------------------------------
    Bagian bawah: masukkan skrip manual untuk autocomplete
------------------------------------------------------------ --}}
