{{-- resources/views/medical-record/edit.blade.php --}}
@extends('template.index')

@section('title', 'Edit Rekam Medis')

@section('content')
    <div class="container py-4" style="background-color: #e8f1ff;">
        <h3 class="mb-4">Edit Rekam Medis (Format SOAP)</h3>

        <div class="card mb-4 shadow-sm rounded-3">
            <div class="card-body">
                <form action="{{ route('medicalrecord.update', $record->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                                value="{{ old('patient_name_input', $record->patient->nama . ' (' . $record->patient->mr_number . ')') }}"
                                autocomplete="off" required>
                            <input type="hidden" id="patient_id" name="patient_id"
                                value="{{ old('patient_id', $record->patient_id) }}">
                            <datalist id="patients_list">
                                @foreach ($patients as $patient)
                                    <option data-id="{{ $patient->id }}"
                                        value="{{ $patient->nama }} ({{ $patient->mr_number }})"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label for="doctor_name_input" class="form-label">Dokter Pemeriksa</label>
                            <input type="text" id="doctor_name_input" name="doctor_name_input" class="form-control"
                                placeholder="Ketik nama dokter..." list="doctors_list"
                                value="{{ old('doctor_name_input', $record->doctor->nama . ' (' . $record->doctor->role?->nama . ')') }}"
                                autocomplete="off" required>
                            <input type="hidden" id="doctor_id" name="doctor_id"
                                value="{{ old('doctor_id', $record->doctor_id) }}">
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
                                value="{{ old('recorded_at', $record->recorded_at->format('Y-m-d')) }}" required>
                        </div>


                        {{-- ========================================= --}}
                        {{--       BAGIAN S: SUBJECTIVE (Show/Hide)   --}}
                        {{-- ========================================= --}}
                        <div class="col-12 mt-4">
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
                                            value="{{ old('keluhan_utama', $record->keluhan_utama) }}" required>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="anamnesa" class="form-label">Anamnesa (Riwayat Penyakit
                                            Sekarang)</label>
                                        <textarea id="anamnesa" name="anamnesa" class="form-control" rows="3" placeholder="Detail anamnesa pasien..."
                                            required>{{ old('anamnesa', $record->anamnesa) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit Dahulu</label>
                                        <textarea id="riwayat_penyakit" name="riwayat_penyakit" class="form-control" rows="2"
                                            placeholder="Misal: Hipertensi, DM, dll...">{{ old('riwayat_penyakit', $record->riwayat_penyakit) }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="riwayat_alergi" class="form-label">Riwayat Alergi</label>
                                        <input type="text" id="riwayat_alergi" name="riwayat_alergi" class="form-control"
                                            placeholder="Misal: Alergi obat sulfa, debu, dll"
                                            value="{{ old('riwayat_alergi', $record->riwayat_alergi) }}">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="riwayat_pengobatan" class="form-label">Riwayat Pengobatan Saat
                                            Ini</label>
                                        <textarea id="riwayat_pengobatan" name="riwayat_pengobatan" class="form-control" rows="2"
                                            placeholder="Obat-obatan yang sedang dikonsumsi...">{{ old('riwayat_pengobatan', $record->riwayat_pengobatan) }}</textarea>
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
                                            value="{{ old('tinggi_badan', $record->tinggi_badan) }}" placeholder="145">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                        <input type="number" class="form-control" id="berat_badan" name="berat_badan"
                                            value="{{ old('berat_badan', $record->berat_badan) }}" placeholder="50">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tekanan_darah" class="form-label">Tekanan Darah (mmHg)</label>
                                        <input type="text" class="form-control" id="tekanan_darah"
                                            name="tekanan_darah"
                                            value="{{ old('tekanan_darah', $record->tekanan_darah) }}"
                                            placeholder="120/80">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="suhu_tubuh" class="form-label">Suhu Tubuh (°C)</label>
                                        <input type="number" step="0.1" class="form-control" id="suhu_tubuh"
                                            name="suhu_tubuh" value="{{ old('suhu_tubuh', $record->suhu_tubuh) }}"
                                            placeholder="36.7">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="nadi" class="form-label">Nadi (x/menit)</label>
                                        <input type="number" class="form-control" id="nadi" name="nadi"
                                            value="{{ old('nadi', $record->nadi) }}" placeholder="80">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="pernapasan" class="form-label">Pernapasan (x/menit)</label>
                                        <input type="number" class="form-control" id="pernapasan" name="pernapasan"
                                            value="{{ old('pernapasan', $record->pernapasan) }}" placeholder="18">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="saturasi" class="form-label">Saturasi Oksigen (%)</label>
                                        <input type="number" step="1" class="form-control" id="saturasi"
                                            name="saturasi" value="{{ old('saturasi', $record->saturasi) }}"
                                            placeholder="98">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="hasil_pemeriksaan_fisik" class="form-label">Hasil Pemeriksaan
                                            Fisik</label>
                                        <textarea id="hasil_pemeriksaan_fisik" name="hasil_pemeriksaan_fisik" class="form-control" rows="3"
                                            placeholder="Misal: Faring hiperemis, tidak ada pembesaran kelenjar...">{{ old('hasil_pemeriksaan_fisik', $record->hasil_pemeriksaan_fisik) }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="hasil_pemeriksaan_penunjang" class="form-label">Hasil Pemeriksaan
                                            Penunjang (Lab/Radiologi)</label>
                                        <textarea id="hasil_pemeriksaan_penunjang" name="hasil_pemeriksaan_penunjang" class="form-control" rows="3"
                                            placeholder="Ringkasan hasil lab, X-ray, EKG, dll...">{{ old('hasil_pemeriksaan_penunjang', $record->hasil_pemeriksaan_penunjang) }}</textarea>
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
                                            placeholder="Contoh: Faringitis akut nonspesifik" required>{{ old('diagnosis', $record->diagnosis) }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="diagnosis_banding" class="form-label">Diagnosis Banding
                                            (opsional)</label>
                                        <textarea id="diagnosis_banding" name="diagnosis_banding" class="form-control" rows="2"
                                            placeholder="Jika ada diagnosis banding...">{{ old('diagnosis_banding', $record->diagnosis_banding) }}</textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="kode_icd10" class="form-label">Kode ICD-10 (opsional)</label>
                                        <input type="text" id="kode_icd10" name="kode_icd10" class="form-control"
                                            value="{{ old('kode_icd10', $record->kode_icd10) }}" placeholder="J02.9">
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
                                                {{-- Jika ada old input (gagal validasi), pakai old(), else pakai data lama --}}
                                                @if (old('resep_obat'))
                                                    @php $oldResep = old('resep_obat'); @endphp
                                                    @foreach ($oldResep as $i => $ro)
                                                        <tr>
                                                            <td>
                                                                <div style="position: relative;">
                                                                    <input type="text"
                                                                        name="resep_obat[{{ $i }}][obat_nama]"
                                                                        class="form-control obat-input"
                                                                        placeholder="Ketik nama obat..."
                                                                        autocomplete="off"
                                                                        value="{{ $ro['obat_nama'] ?? '' }}">
                                                                    <input type="hidden"
                                                                        name="resep_obat[{{ $i }}][obat_id]"
                                                                        class="obat-id-input"
                                                                        value="{{ $ro['obat_id'] ?? '' }}">
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
                                                                <input type="text"
                                                                    name="resep_obat[{{ $i }}][dosis]"
                                                                    class="form-control"
                                                                    placeholder="Misal: 2x sehari 500mg"
                                                                    value="{{ $ro['dosis'] ?? '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    name="resep_obat[{{ $i }}][kuantitas]"
                                                                    class="form-control" placeholder="Qty" min="1"
                                                                    value="{{ $ro['kuantitas'] ?? '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="resep_obat[{{ $i }}][keterangan]"
                                                                    class="form-control"
                                                                    placeholder="Keterangan (opsional)"
                                                                    value="{{ $ro['keterangan'] ?? '' }}">
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger btn-remove-resep"
                                                                    title="Hapus baris">&times;
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @elseif($record->resepObats->count() > 0)
                                                    @foreach ($record->resepObats as $i => $ro)
                                                        <tr>
                                                            <td>
                                                                <div style="position: relative;">
                                                                    <input type="text"
                                                                        name="resep_obat[{{ $i }}][obat_nama]"
                                                                        class="form-control obat-input"
                                                                        placeholder="Ketik nama obat..."
                                                                        autocomplete="off" value="{{ $ro->obat->nama }}">
                                                                    <input type="hidden"
                                                                        name="resep_obat[{{ $i }}][obat_id]"
                                                                        class="obat-id-input"
                                                                        value="{{ $ro->obat_id }}">
                                                                    <div class="suggestions-list"
                                                                        style="position: absolute;
                                                                    top: 100%;
                                                                    left: 0;
                                                                    right: 0;
                                                                    z-index: 1000;
                                                                    background: white;
                                                                    border: 1px solid #ddd;
                                                                    display: false;
                                                                    max-height: 200px;
                                                                    overflow-y: auto;">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="resep_obat[{{ $i }}][dosis]"
                                                                    class="form-control"
                                                                    placeholder="Misal: 2x sehari 500mg"
                                                                    value="{{ $ro->dosis }}">
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    name="resep_obat[{{ $i }}][kuantitas]"
                                                                    class="form-control" placeholder="Qty" min="1"
                                                                    value="{{ $ro->kuantitas }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="resep_obat[{{ $i }}][keterangan]"
                                                                    class="form-control"
                                                                    placeholder="Keterangan (opsional)"
                                                                    value="{{ $ro->keterangan }}">
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger btn-remove-resep"
                                                                    title="Hapus baris">&times;
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td>
                                                            <div style="position: relative;">
                                                                <input type="text" name="resep_obat[0][obat_nama]"
                                                                    class="form-control obat-input"
                                                                    placeholder="Ketik nama obat..." autocomplete="off">
                                                                <input type="hidden" name="resep_obat[0][obat_id]"
                                                                    class="obat-id-input" value="">
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
                                                @endif
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
                                        <div id="layanan-tags" class="mt-1">
                                            @php
                                                $selectedLayanan = old(
                                                    'layanans',
                                                    $record->layanans->pluck('id')->toArray(),
                                                );
                                            @endphp
                                            @foreach ($layanans as $l)
                                                @if (in_array($l->id, $selectedLayanan))
                                                    <span class="badge bg-secondary me-1 mb-1">
                                                        {{ $l->nama }} <span class="remove-layanan"
                                                            style="cursor:pointer;">×</span>
                                                        <input type="hidden" name="layanans[]"
                                                            value="{{ $l->id }}"
                                                            id="layanan-hidden-{{ $l->id }}">
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
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
                                        <div id="tindakan-tags" class="mt-1">
                                            @php
                                                $selectedTindakan = old(
                                                    'tindakans',
                                                    $record->tindakans->pluck('id')->toArray(),
                                                );
                                            @endphp
                                            @foreach ($tindakans as $t)
                                                @if (in_array($t->id, $selectedTindakan))
                                                    <span class="badge bg-secondary me-1 mb-1">
                                                        {{ $t->nama }} <span class="remove-tindakan"
                                                            style="cursor:pointer;">×</span>
                                                        <input type="hidden" name="tindakans[]"
                                                            value="{{ $t->id }}"
                                                            id="tindakan-hidden-{{ $t->id }}">
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                        <!-- Container hidden input untuk id tindakan -->
                                        <div id="tindakan-hidden-inputs"></div>
                                        <small class="text-muted">Klik satu per satu untuk menambah tindakan</small>
                                    </div>

                                    {{-- Metadata (opsional) --}}
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status Pemeriksaan</label>
                                        <select id="status" name="status" class="form-control">
                                            <option value="draft"
                                                {{ old('status', $record->status) == 'draft' ? 'selected' : '' }}>Draft
                                            </option>
                                            <option value="final"
                                                {{ old('status', $record->status) == 'final' ? 'selected' : '' }}>Final
                                            </option>
                                            <option value="revisi"
                                                {{ old('status', $record->status) == 'revisi' ? 'selected' : '' }}>Revisi
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lampiran" class="form-label">Lampiran (Lab/Rontgen)</label>
                                        <input type="file" id="lampiran" name="lampiran[]" class="form-control"
                                            multiple>
                                        <small class="text-muted">Boleh upload banyak file (.jpg, .png, .pdf)</small>
                                        @if ($record->lampiran)
                                            <div class="mt-2">
                                                <strong>File Lampiran Lama:</strong>
                                                <ul>
                                                    @foreach ($record->lampiran as $filePath)
                                                        <li>
                                                            <a href="{{ Storage::url($filePath) }}" target="_blank">
                                                                {{ basename($filePath) }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-success px-4">Update</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===================================================================
            // 1) Data awal dari controller
            // ===================================================================
            let obatData = @json($obats->map(fn($o) => ['id' => $o->id, 'nama' => $o->nama])->toArray());
            let layananData = @json($layanans->map(fn($l) => ['id' => $l->id, 'nama' => $l->nama])->toArray());
            let tindakanData = @json($tindakans->map(fn($t) => ['id' => $t->id, 'nama' => $t->nama])->toArray());

            // ===================================================================
            // 2) Inisialisasi layananSelected & tindakanSelected dengan data lama
            // ===================================================================
            let layananSelected = @json($record->layanans->map(fn($l) => ['id' => $l->id, 'nama' => $l->nama])->toArray());
            let tindakanSelected = @json($record->tindakans->map(fn($t) => ['id' => $t->id, 'nama' => $t->nama])->toArray());

            // ===================================================================
            // 3) Fungsi helper untuk filter & cari nama by id
            // ===================================================================
            function filterAndSlice(arr, keyword) {
                const q = keyword.trim().toLowerCase();
                if (!q) return [];
                return arr.filter(item => item.nama.toLowerCase().includes(q)).slice(0, 10);
            }

            function getLayananNamaById(id) {
                const found = layananData.find(item => item.id == id);
                return found ? found.nama : '';
            }

            function getTindakanNamaById(id) {
                const found = tindakanData.find(item => item.id == id);
                return found ? found.nama : '';
            }

            // ===================================================================
            // 4) Pasang listener pada badge lama “×” untuk layanan
            // ===================================================================
            document.querySelectorAll('.remove-layanan').forEach(span => {
                span.addEventListener('click', function() {
                    const badge = this.closest('span.badge');
                    const hiddenInput = badge.querySelector(
                        'input[type="hidden"][name="layanans[]"]');
                    if (hiddenInput) {
                        const id = parseInt(hiddenInput.value);
                        layananSelected = layananSelected.filter(item => item.id !== id);
                        badge.remove();
                    }
                });
            });

            // ===================================================================
            // 5) Pasang listener pada badge lama “×” untuk tindakan
            // ===================================================================
            document.querySelectorAll('.remove-tindakan').forEach(span => {
                span.addEventListener('click', function() {
                    const badge = this.closest('span.badge');
                    const hiddenInput = badge.querySelector(
                        'input[type="hidden"][name="tindakans[]"]');
                    if (hiddenInput) {
                        const id = parseInt(hiddenInput.value);
                        tindakanSelected = tindakanSelected.filter(item => item.id !== id);
                        badge.remove();
                    }
                });
            });

            // ===================================================================
            // 6) Autocomplete OBAT pada tiap baris resep
            // ===================================================================
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
            document.addEventListener('click', function(e) {
                document.querySelectorAll('.suggestions-list').forEach(box => {
                    if (!box.contains(e.target) && !(box.previousElementSibling && box
                            .previousElementSibling.contains(e.target))) {
                        box.style.display = 'none';
                    }
                });
            });

            // ===================================================================
            // 7) Indexing & Clone Baris Resep (bahwa baris lama sudah = count)
            // ===================================================================
            let rowIndex = {{ $record->resepObats->count() }};
            // misal ada 2 baris lama → rowIndex = 2 → baris baru pakai [2]
            const btnAddResep = document.getElementById('btn-add-resep');
            btnAddResep.addEventListener('click', function() {
                const firstRow = tableResep.querySelector('tr');
                const newRow = firstRow.cloneNode(true);
                newRow.querySelectorAll('input').forEach(elem => {
                    const oldName = elem.getAttribute('name');
                    if (!oldName) return;
                    const newName = oldName.replace(/\[\d+\]/g, `[${rowIndex}]`);
                    elem.setAttribute('name', newName);
                    elem.value = '';
                });
                const sugBox = newRow.querySelector('.suggestions-list');
                if (sugBox) {
                    sugBox.innerHTML = '';
                    sugBox.style.display = 'none';
                }
                tableResep.appendChild(newRow);
                rowIndex++;
            });
            tableResep.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('btn-remove-resep')) {
                    const row = e.target.closest('tr');
                    const totalRows = tableResep.querySelectorAll('tr').length;
                    if (totalRows > 1) {
                        row.remove();
                    } else {
                        row.querySelectorAll('input').forEach(el => el.value = '');
                        const box = row.querySelector('.suggestions-list');
                        if (box) {
                            box.innerHTML = '';
                            box.style.display = 'none';
                        }
                    }
                }
            });

            // ===================================================================
            // 8) Autocomplete & Multi-select LAYANAN
            // ===================================================================
            const layananInput2 = document.getElementById('layanan-input');
            const layananSuggestionBox = document.querySelector('.suggestions-layanan');
            const layananTagsContainer = document.getElementById('layanan-tags');
            const layananHiddenInputs = document.getElementById('layanan-hidden-inputs');

            layananInput2.addEventListener('input', function() {
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
                        layananInput2.value = '';
                        layananSuggestionBox.style.display = 'none';
                    });
                    layananSuggestionBox.appendChild(div);
                });
                layananSuggestionBox.style.display = 'block';
            });
            document.addEventListener('click', function(e) {
                if (!layananInput2.contains(e.target) && !layananSuggestionBox.contains(e.target)) {
                    layananSuggestionBox.style.display = 'none';
                }
            });

            function addLayananTag(item) {
                layananSelected.push(item);
                const tag = document.createElement('span');
                tag.classList.add('badge', 'bg-secondary', 'me-1', 'mb-1');
                tag.style.cursor = 'default';
                tag.innerHTML = item.nama +
                    ' <span class="remove-layanan" style="cursor:pointer; margin-left:4px;">×</span>';
                // tambahkan hidden input di dalam badge agar listener lama (step 4) dapat menemukannya
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'layanans[]';
                hidden.value = item.id;
                hidden.id = 'layanan-hidden-' + item.id;
                tag.appendChild(hidden);
                layananTagsContainer.appendChild(tag);

                // pasang listener pada tombol “×” di tag baru:
                tag.querySelector('.remove-layanan').addEventListener('click', function() {
                    layananSelected = layananSelected.filter(it => it.id != item.id);
                    tag.remove();
                });
            }

            // ===================================================================
            // 9) Autocomplete & Multi-select TINDAKAN
            // ===================================================================
            const tindakanInput2 = document.getElementById('tindakan-input');
            const tindakanSuggestionBox = document.querySelector('.suggestions-tindakan');
            const tindakanTagsContainer = document.getElementById('tindakan-tags');
            const tindakanHiddenInputs = document.getElementById('tindakan-hidden-inputs');

            tindakanInput2.addEventListener('input', function() {
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
                        tindakanInput2.value = '';
                        tindakanSuggestionBox.style.display = 'none';
                    });
                    tindakanSuggestionBox.appendChild(div);
                });
                tindakanSuggestionBox.style.display = 'block';
            });
            document.addEventListener('click', function(e) {
                if (!tindakanInput2.contains(e.target) && !tindakanSuggestionBox.contains(e.target)) {
                    tindakanSuggestionBox.style.display = 'none';
                }
            });

            function addTindakanTag(item) {
                tindakanSelected.push(item);
                const tag = document.createElement('span');
                tag.classList.add('badge', 'bg-secondary', 'me-1', 'mb-1');
                tag.style.cursor = 'default';
                tag.innerHTML = item.nama +
                    ' <span class="remove-tindakan" style="cursor:pointer; margin-left:4px;">×</span>';
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'tindakans[]';
                hidden.value = item.id;
                hidden.id = 'tindakan-hidden-' + item.id;
                tag.appendChild(hidden);
                tindakanTagsContainer.appendChild(tag);

                // pasang listener pada tombol “×” di tag baru:
                tag.querySelector('.remove-tindakan').addEventListener('click', function() {
                    tindakanSelected = tindakanSelected.filter(it => it.id != item.id);
                    tag.remove();
                });
            }

            // ===================================================================
            // 10) Pasien & Dokter (sama seperti create)
            // ===================================================================
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


@endsection
