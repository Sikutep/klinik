{{-- resources/views/medical-record/show.blade.php --}}
@extends('template.index')

@section('content')
<div class="container py-4">
    {{-- Judul dan Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Rekam Medis</h1>
        <a href="{{ route('medicalrecord.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

     <div class="tab-content mt-3">
        {{-- Informasi Umum --}}
        <div class="tab-pane fade mt-3 show active" id="section-umum" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-card-list"></i> Informasi Umum
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Pasien</h6>
                            <p class="mb-0">{{ $record->patient->nama }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Dokter</h6>
                            <p class="mb-0">{{ $record->doctor->nama }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Tanggal Ter-record</h6>
                            <p class="mb-0">{{ $record->recorded_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Status</h6>
                            <span class="badge
                                @if($record->status === 'selesai') bg-success
                                @elseif($record->status === 'proses') bg-warning text-dark
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($record->status) }}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Dibuat oleh</h6>
                            <p class="mb-0">{{ optional($record->creator)->nama ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Diubah oleh</h6>
                            <p class="mb-0">{{ optional($record->updater)->nama ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- Tab Navigasi Section --}}
    <ul class="nav nav-tabs mt-5" id="medicalRecordTab" role="tablist">

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-s" data-bs-toggle="tab" data-bs-target="#section-s" type="button" role="tab">S (Subjective)</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-o" data-bs-toggle="tab" data-bs-target="#section-o" type="button" role="tab">O (Objective)</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-a" data-bs-toggle="tab" data-bs-target="#section-a" type="button" role="tab">A (Assessment)</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-p" data-bs-toggle="tab" data-bs-target="#section-p" type="button" role="tab">P (Plan)</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-lampiran" data-bs-toggle="tab" data-bs-target="#section-lampiran" type="button" role="tab">Lampiran</button>
        </li>
    </ul>



        {{-- Subjective (S) --}}
        <div class="tab-pane fade mt-3" id="section-s" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-clipboard-data"></i> Subjective (S)
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-semibold mb-1">Keluhan Utama</h6>
                        <p class="mb-0">{{ $record->keluhan_utama }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="fw-semibold mb-1">Anamnesa</h6>
                        <p class="mb-0">{{ $record->anamnesa }}</p>
                    </div>
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <h6 class="fw-semibold mb-1">Riwayat Penyakit</h6>
                            <p class="mb-0">{{ $record->riwayat_penyakit ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-semibold mb-1">Riwayat Alergi</h6>
                            <p class="mb-0">{{ $record->riwayat_alergi ?? '-' }}</p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="fw-semibold mb-1">Riwayat Pengobatan</h6>
                            <p class="mb-0">{{ $record->riwayat_pengobatan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Objective (O) --}}
        <div class="tab-pane fade mt-3" id="section-o" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-eye"></i> Objective (O)
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Tinggi Badan</h6>
                            <p class="mb-0">{{ $record->tinggi_badan ? $record->tinggi_badan . ' cm' : '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Berat Badan</h6>
                            <p class="mb-0">{{ $record->berat_badan ? $record->berat_badan . ' kg' : '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Tekanan Darah</h6>
                            <p class="mb-0">{{ $record->tekanan_darah ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Suhu Tubuh</h6>
                            <p class="mb-0">{{ $record->suhu_tubuh ? $record->suhu_tubuh . ' °C' : '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Nadi</h6>
                            <p class="mb-0">{{ $record->nadi ? $record->nadi . ' x/menit' : '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Pernapasan</h6>
                            <p class="mb-0">{{ $record->pernapasan ? $record->pernapasan . ' x/menit' : '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-1">Saturasi</h6>
                            <p class="mb-0">{{ $record->saturasi ? $record->saturasi . ' %' : '-' }}</p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="fw-semibold mb-1">Hasil Pemeriksaan Fisik</h6>
                            <p class="mb-0">{{ $record->hasil_pemeriksaan_fisik ?? '-' }}</p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="fw-semibold mb-1">Hasil Pemeriksaan Penunjang</h6>
                            <p class="mb-0">{{ $record->hasil_pemeriksaan_penunjang ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Assessment (A) --}}
        <div class="tab-pane fade mt-3" id="section-a" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-journal-medical"></i> Assessment (A)
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-semibold mb-1">Diagnosis</h6>
                        <p class="mb-0">{{ $record->diagnosis }}</p>
                    </div>
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <h6 class="fw-semibold mb-1">Diagnosis Banding</h6>
                            <p class="mb-0">{{ $record->diagnosis_banding ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-semibold mb-1">Kode ICD-10</h6>
                            <p class="mb-0">{{ $record->kode_icd10 ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Plan (P) --}}
        <div class="tab-pane fade mt-3" id="section-p" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <i class="bi bi-clipboard-check"></i> Plan (P)
                </div>
                <div class="card-body">
                    {{-- Resep Obat --}}
                    <h5 class="mb-3"><i class="bi bi-capsule"></i> Resep Obat / Terapi</h5>
                    @if ($record->resepObats->isEmpty())
                        <p class="text-muted">Tidak ada resep obat.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Obat</th>
                                        <th>Dosis</th>
                                        <th>Kuantitas</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($record->resepObats as $ro)
                                        <tr>
                                            <td>{{ optional($ro->obat)->nama ?? '—' }}</td>
                                            <td>{{ $ro->dosis }}</td>
                                            <td>{{ $ro->kuantitas }}</td>
                                            <td>{{ $ro->keterangan ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    {{-- Layanan --}}
                    <hr>
                    <h5 class="mb-3"><i class="bi bi-gear-wide-connected"></i> Layanan / Jasa Medis</h5>
                    @if ($record->layanans->isEmpty())
                        <p class="text-muted">Tidak ada layanan.</p>
                    @else
                        <div class="d-flex flex-wrap">
                            @foreach ($record->layanans as $l)
                                <span class="badge bg-secondary me-2 mb-2">{{ $l->nama }}</span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Tindakan --}}
                    <hr>
                    <h5 class="mb-3"><i class="bi bi-tools"></i> Tindakan / Prosedur</h5>
                    @if ($record->tindakans->isEmpty())
                        <p class="text-muted">Tidak ada tindakan.</p>
                    @else
                        <div class="d-flex flex-wrap">
                            @foreach ($record->tindakans as $t)
                                <span class="badge bg-secondary me-2 mb-2">{{ $t->nama }}</span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Rencana Tindakan --}}
                    <hr>
                    <div class="mb-3">
                        <h5 class="fw-semibold mb-1"><i class="bi bi-pencil-square"></i> Rencana Tindakan</h5>
                        <p class="mb-0">{{ $record->rencana_tindakan ?? '-' }}</p>
                    </div>

                    {{-- Edukasi Pasien --}}
                    <div class="mb-3">
                        <h5 class="fw-semibold mb-1"><i class="bi bi-book-half"></i> Edukasi Pasien</h5>
                        <p class="mb-0">{{ $record->edukasi_pasien ?? '-' }}</p>
                    </div>

                    {{-- Rencana Kontrol --}}
                    <div class="mb-3">
                        <h5 class="fw-semibold mb-1"><i class="bi bi-calendar-check"></i> Rencana Kontrol</h5>
                        <p class="mb-0">{{ $record->rencana_kontrol ? $record->rencana_kontrol->format('d M Y') : '-' }}</p>
                    </div>

                    {{-- Rujukan --}}
                    <div class="mb-0">
                        <h5 class="fw-semibold mb-1"><i class="bi bi-share"></i> Rujukan</h5>
                        <p class="mb-0">{{ $record->rujukan ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lampiran --}}
        <div class="tab-pane fade mt-3" id="section-lampiran" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <i class="bi bi-paperclip"></i> Lampiran (Lab / Rontgen)
                </div>
                <div class="card-body">
                    @if (empty($record->lampiran_urls) || count($record->lampiran_urls) === 0)
                        <p class="text-muted">Tidak ada lampiran.</p>
                    @else
                        <div class="accordion" id="accordionLampiran">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingLampiran">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLampiran" aria-expanded="false">
                                        Lihat Lampiran ({{ count($record->lampiran_urls) }})
                                    </button>
                                </h2>
                                <div id="collapseLampiran" class="accordion-collapse collapse" data-bs-parent="#accordionLampiran">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($record->lampiran_urls as $url)
                                                <li class="list-group-item">
                                                    <a href="{{ $url }}" target="_blank" class="text-decoration-none">
                                                        <i class="bi bi-file-earmark-text me-1"></i> {{ basename($url) }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
