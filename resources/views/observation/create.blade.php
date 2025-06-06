{{-- resources/views/observation/create.blade.php --}}
@extends('template.index')

@section('title', 'Tambah Observasi')

@section('content')
<div class="container-fluid py-4">
    <h3 class="mb-4">Tambah Observasi Baru</h3>

    <div class="card shadow-sm rounded-3 mb-4">
        <div class="card-body">
            <form action="{{ route('observation.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Validasi Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- ======================== --}}
                {{--   Bagian Relasi Utama   --}}
                {{-- ======================== --}}
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label for="medical_record_id" class="form-label">Rekam Medis (Opsional)</label>
                        <select name="medical_record_id"
                                id="medical_record_id"
                                class="form-select @error('medical_record_id') is-invalid @enderror">
                            <option value="">-- Tidak dipakai --</option>
                            @foreach($medicalRecords as $mr)
                                <option value="{{ $mr->id }}"
                                    {{ old('medical_record_id') == $mr->id ? 'selected' : '' }}>
                                    {{ $mr->patient->nama }} ({{ $mr->patient->mr_number }}) –
                                    {{ $mr->recorded_at->format('d M Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('medical_record_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="queue_id" class="form-label">Antrian Pasien</label>
                        <select name="queue_id"
                                id="queue_id"
                                class="form-select @error('queue_id') is-invalid @enderror"
                                >
                            <option value="">-- Pilih Antrian --</option>
                            @foreach($queues as $queue)
                                <option value="{{ $queue->id }}"
                                    {{ old('queue_id') == $queue->id ? 'selected' : '' }}>
                                    {{ $queue->nomor_antrian }} – {{ $queue->patient->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('queue_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="ruangan_id" class="form-label">Ruangan</label>
                        <select name="ruangan_id"
                                id="ruangan_id"
                                class="form-select @error('ruangan_id') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($ruangans as $r)
                                <option value="{{ $r->id }}"
                                    {{ old('ruangan_id') == $r->id ? 'selected' : '' }}>
                                    {{ $r->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('ruangan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="poli_id" class="form-label">Poli (Opsional)</label>
                        <select name="poli_id"
                                id="poli_id"
                                class="form-select @error('poli_id') is-invalid @enderror">
                            <option value="">-- Tidak dipakai --</option>
                            @foreach($polis as $p)
                                <option value="{{ $p->id }}"
                                    {{ old('poli_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('poli_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="observed_at" class="form-label">Tanggal &amp; Waktu Observasi</label>
                        <input type="datetime-local"
                               id="observed_at"
                               name="observed_at"
                               class="form-control @error('observed_at') is-invalid @enderror"
                               value="{{ old('observed_at', now()->format('Y-m-d\TH:i')) }}">
                        @error('observed_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                {{-- ======================== --}}
                {{--        Vital Signs      --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Vital Signs</strong>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-3">
                                <label for="suhu" class="form-label">Suhu (°C)</label>
                                <input type="number"
                                       step="0.1"
                                       id="suhu"
                                       name="suhu"
                                       class="form-control @error('suhu') is-invalid @enderror"
                                       placeholder="36.7"
                                       value="{{ old('suhu') }}">
                                @error('suhu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="tekanan_darah" class="form-label">Tekanan Darah (mmHg)</label>
                                <input type="text"
                                       id="tekanan_darah"
                                       name="tekanan_darah"
                                       class="form-control @error('tekanan_darah') is-invalid @enderror"
                                       placeholder="120/80"
                                       value="{{ old('tekanan_darah') }}">
                                @error('tekanan_darah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="nadi" class="form-label">Nadi (x/menit)</label>
                                <input type="number"
                                       id="nadi"
                                       name="nadi"
                                       class="form-control @error('nadi') is-invalid @enderror"
                                       placeholder="80"
                                       value="{{ old('nadi') }}">
                                @error('nadi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="pernapasan" class="form-label">Pernapasan (x/menit)</label>
                                <input type="number"
                                       id="pernapasan"
                                       name="pernapasan"
                                       class="form-control @error('pernapasan') is-invalid @enderror"
                                       placeholder="18"
                                       value="{{ old('pernapasan') }}">
                                @error('pernapasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="saturasi" class="form-label">Saturasi (%)</label>
                                <input type="number"
                                       id="saturasi"
                                       name="saturasi"
                                       class="form-control @error('saturasi') is-invalid @enderror"
                                       placeholder="98"
                                       min="0" max="100"
                                       value="{{ old('saturasi') }}">
                                @error('saturasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                {{-- ======================== --}}
                {{--   Respiratory Support   --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Respiratory Support</strong>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-4">
                                <label for="respiratory_support_type" class="form-label">Jenis Dukungan</label>
                                <select name="respiratory_support_type"
                                        id="respiratory_support_type"
                                        class="form-select @error('respiratory_support_type') is-invalid @enderror">
                                    <option value="">– Pilih –</option>
                                    <option value="none" {{ old('respiratory_support_type')=='none'? 'selected':'' }}>None</option>
                                    <option value="nasal_cannula" {{ old('respiratory_support_type')=='nasal_cannula'? 'selected':'' }}>Nasal Cannula</option>
                                    <option value="masker_sederhana" {{ old('respiratory_support_type')=='masker_sederhana'? 'selected':'' }}>Masker Sederhana</option>
                                    <option value="high_flow" {{ old('respiratory_support_type')=='high_flow'? 'selected':'' }}>High Flow</option>
                                    <option value="ventilator" {{ old('respiratory_support_type')=='ventilator'? 'selected':'' }}>Ventilator</option>
                                </select>
                                @error('respiratory_support_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="oxygen_flow_rate" class="form-label">Debit O₂ (L/menit)</label>
                                <input type="number"
                                       id="oxygen_flow_rate"
                                       name="oxygen_flow_rate"
                                       class="form-control @error('oxygen_flow_rate') is-invalid @enderror"
                                       placeholder="2"
                                       value="{{ old('oxygen_flow_rate') }}">
                                @error('oxygen_flow_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                {{-- ======================== --}}
                {{--    Pain Assessment      --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Pain Assessment</strong>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-2">
                                <label for="pain_scale" class="form-label">Skor Nyeri (0–10)</label>
                                <input type="number"
                                       id="pain_scale"
                                       name="pain_scale"
                                       class="form-control @error('pain_scale') is-invalid @enderror"
                                       min="0" max="10"
                                       value="{{ old('pain_scale') }}">
                                @error('pain_scale')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="pain_location" class="form-label">Lokasi Nyeri</label>
                                <input type="text"
                                       id="pain_location"
                                       name="pain_location"
                                       class="form-control @error('pain_location') is-invalid @enderror"
                                       placeholder="Perut kanan atas"
                                       value="{{ old('pain_location') }}">
                                @error('pain_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="pain_character" class="form-label">Karakter Nyeri</label>
                                <input type="text"
                                       id="pain_character"
                                       name="pain_character"
                                       class="form-control @error('pain_character') is-invalid @enderror"
                                       placeholder="Tajam"
                                       value="{{ old('pain_character') }}">
                                @error('pain_character')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                {{-- ======================== --}}
                {{--         GCS             --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Glasgow Coma Scale (GCS)</strong>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-2">
                                <label for="gcs_eye" class="form-label">Eye (1–4)</label>
                                <select id="gcs_eye" name="gcs_eye"
                                        class="form-select @error('gcs_eye') is-invalid @enderror">
                                    <option value="">–</option>
                                    @for($i=1; $i<=4; $i++)
                                        <option value="{{ $i }}" {{ old('gcs_eye') == $i ? 'selected':'' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('gcs_eye')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="gcs_verbal" class="form-label">Verbal (1–5)</label>
                                <select id="gcs_verbal" name="gcs_verbal"
                                        class="form-select @error('gcs_verbal') is-invalid @enderror">
                                    <option value="">–</option>
                                    @for($i=1; $i<=5; $i++)
                                        <option value="{{ $i }}" {{ old('gcs_verbal') == $i ? 'selected':'' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('gcs_verbal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="gcs_motor" class="form-label">Motor (1–6)</label>
                                <select id="gcs_motor" name="gcs_motor"
                                        class="form-select @error('gcs_motor') is-invalid @enderror">
                                    <option value="">–</option>
                                    @for($i=1; $i<=6; $i++)
                                        <option value="{{ $i }}" {{ old('gcs_motor') == $i ? 'selected':'' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('gcs_motor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="total_gcs" class="form-label">Total GCS</label>
                                <input type="number"
                                       id="total_gcs"
                                       name="total_gcs"
                                       class="form-control"
                                       readonly
                                       value="{{ old('total_gcs', '') }}">
                                {{-- readonly agar dihitung otomatis --}}
                            </div>
                        </div>
                        <small class="text-muted">Total GCS dihitung otomatis ketika Anda memilih Eye/Verbal/Motor.</small>
                    </div>
                </div>


                {{-- ======================== --}}
                {{--  Point‐of‐Care Labs      --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Point-of-Care Labs</strong>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-4">
                                <label for="glukosa_sewaktu" class="form-label">Glukosa Sewaktu (mmol/L)</label>
                                <input type="number"
                                       step="0.01"
                                       id="glukosa_sewaktu"
                                       name="glukosa_sewaktu"
                                       class="form-control @error('glukosa_sewaktu') is-invalid @enderror"
                                       placeholder="5.65"
                                       value="{{ old('glukosa_sewaktu') }}">
                                @error('glukosa_sewaktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                {{-- ======================== --}}
                {{--      Fluid Balance      --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Fluid Balance</strong>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-3">
                                <label for="fluid_intake_cc" class="form-label">Cairan Masuk (cc)</label>
                                <input type="number"
                                       id="fluid_intake_cc"
                                       name="fluid_intake_cc"
                                       class="form-control @error('fluid_intake_cc') is-invalid @enderror"
                                       value="{{ old('fluid_intake_cc') }}">
                                @error('fluid_intake_cc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="fluid_output_cc" class="form-label">Cairan Keluar (cc)</label>
                                <input type="number"
                                       id="fluid_output_cc"
                                       name="fluid_output_cc"
                                       class="form-control @error('fluid_output_cc') is-invalid @enderror"
                                       value="{{ old('fluid_output_cc') }}">
                                @error('fluid_output_cc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="balance_fluid_cc" class="form-label">Balance (cc)</label>
                                <input type="number"
                                       id="balance_fluid_cc"
                                       name="balance_fluid_cc"
                                       class="form-control @error('balance_fluid_cc') is-invalid @enderror"
                                       value="{{ old('balance_fluid_cc') }}">
                                @error('balance_fluid_cc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                {{-- ======================== --}}
                {{--    Intervention Given    --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Intervensi yang Diberikan</strong>
                    </div>
                    <div class="card-body">
                        <textarea id="intervention_given"
                                  name="intervention_given"
                                  class="form-control @error('intervention_given') is-invalid @enderror"
                                  rows="2"
                                  placeholder="Contoh: Pemberian O₂ via nasal cannula...">{{ old('intervention_given') }}</textarea>
                        @error('intervention_given')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                {{-- ======================== --}}
                {{--     Next Observation     --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Jadwal Observasi Berikutnya</strong>
                    </div>
                    <div class="card-body">
                        <input type="datetime-local"
                               id="next_observed_at"
                               name="next_observed_at"
                               class="form-control @error('next_observed_at') is-invalid @enderror"
                               value="{{ old('next_observed_at') }}">
                        @error('next_observed_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                {{-- ======================== --}}
                {{--  Allergy Reaction Now    --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Reaksi Alergi Saat Ini</strong>
                    </div>
                    <div class="card-body">
                        <textarea id="current_allergy_reaction"
                                  name="current_allergy_reaction"
                                  class="form-control @error('current_allergy_reaction') is-invalid @enderror"
                                  rows="2"
                                  placeholder="Misal: Ruam kulit setelah injeksi...">{{ old('current_allergy_reaction') }}</textarea>
                        @error('current_allergy_reaction')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                {{-- ======================== --}}
                {{--     Mobility Status       --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Status Mobilitas</strong>
                    </div>
                    <div class="card-body">
                        <select name="mobility_status"
                                id="mobility_status"
                                class="form-select @error('mobility_status') is-invalid @enderror">
                            <option value="">– Pilih –</option>
                            <option value="independent" {{ old('mobility_status')=='independent'? 'selected':'' }}>Independent</option>
                            <option value="assist" {{ old('mobility_status')=='assist'? 'selected':'' }}>Assist</option>
                            <option value="bedridden" {{ old('mobility_status')=='bedridden'? 'selected':'' }}>Bedridden</option>
                        </select>
                        @error('mobility_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                {{-- ======================== --}}
                {{--    Mental Status Notes    --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Catatan Status Mental / Psikologis</strong>
                    </div>
                    <div class="card-body">
                        <textarea id="mental_status_notes"
                                  name="mental_status_notes"
                                  class="form-control @error('mental_status_notes') is-invalid @enderror"
                                  rows="2"
                                  placeholder="Misal: Pasien tampak gelisah...">{{ old('mental_status_notes') }}</textarea>
                        @error('mental_status_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                {{-- ======================== --}}
                {{--    Lampiran Foto Luka      --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Upload Foto Lampiran (Opsional)</strong>
                    </div>
                    <div class="card-body">
                        <input type="file"
                               id="attachment_photo"
                               name="attachment_photo"
                               class="form-control @error('attachment_photo') is-invalid @enderror"
                               accept="image/*">
                        @error('attachment_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Preview kecil --}}
                        <div class="mt-2">
                            <img id="preview-photo" src="#" alt="Preview Gambar" class="img-fluid" style="max-height: 200px; display: none;">
                        </div>
                    </div>
                </div>


                {{-- ======================== --}}
                {{--    Catatan Tambahan       --}}
                {{-- ======================== --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <strong>Catatan Tambahan</strong>
                    </div>
                    <div class="card-body">
                        <textarea id="catatan"
                                  name="catatan"
                                  class="form-control @error('catatan') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Misal: Pasien mengeluh mual setelah obat...">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                {{-- ======================== --}}
                {{--     Tombol Aksi Utama     --}}
                {{-- ======================== --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('observation.index') }}" class="btn btn-secondary me-2">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        Simpan Observasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ======================== --}}
{{--    JavaScript Section    --}}
{{-- ======================== --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1) Preview gambar ketika dipilih
        const photoInput = document.getElementById('attachment_photo');
        const previewImg = document.getElementById('preview-photo');

        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) {
                previewImg.style.display = 'none';
                previewImg.src = '#';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(ev) {
                previewImg.src = ev.target.result;
                previewImg.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });

        // 2) Hitung otomatis Total GCS
        const eyeSelect    = document.getElementById('gcs_eye');
        const verbalSelect = document.getElementById('gcs_verbal');
        const motorSelect  = document.getElementById('gcs_motor');
        const totalInput   = document.getElementById('total_gcs');

        function calculateGCS() {
            const e = parseInt(eyeSelect.value)    || 0;
            const v = parseInt(verbalSelect.value) || 0;
            const m = parseInt(motorSelect.value)  || 0;
            const total = (e + v + m) || '';
            totalInput.value = total;
        }

        [eyeSelect, verbalSelect, motorSelect].forEach(el => {
            el.addEventListener('change', calculateGCS);
        });

        // Kalau ada nilai lama (old) untuk GCS, panggil sekali
        calculateGCS();
    });
</script>


@endsection
