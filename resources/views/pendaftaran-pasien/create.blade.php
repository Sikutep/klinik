{{-- resources/views/pendaftaran-pasien/create.blade.php --}}
@extends('template.index')

@section('title', 'Daftar Pasien')

@section('content')
    <div class="container-fluid py-4">
        <h2 class="mb-4">Daftar Pasien</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <form action="{{ route('patiens.store') }}" method="POST">
            @csrf

            {{-- ====== Bagian Data Pasien ====== --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Data Pasien</h5>

                    {{-- No. Rekam Medis (Read‐Only) --}}
                    <div class="mb-3">
                        <label for="mr_number" class="form-label">No. Rekam Medis</label>
                        <input type="text" id="mr_number" name="mr_number" class="form-control bg-light"
                            value="{{ old('mr_number', $no_mr ?? '') }}" readonly>
                    </div>

                    <div class="row gx-3 gy-3">
                        {{-- Kolom 1 --}}
                        <div class="col-md-6">
                            {{-- Nama Lengkap --}}
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                    placeholder="Masukkan nama lengkap" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select id="gender" name="gender"
                                    class="form-select @error('gender') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih Jenis
                                        Kelamin</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki‐Laki</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tempat Lahir --}}
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" id="tempat_lahir" name="tempat_lahir"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    value="{{ old('tempat_lahir') }}" placeholder="Masukkan tempat lahir">
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Agama --}}
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select id="agama" name="agama"
                                    class="form-select @error('agama') is-invalid @enderror">
                                    <option value="" disabled {{ old('agama') ? '' : 'selected' }}>Pilih Agama
                                    </option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen
                                    </option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik
                                    </option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Lainnya" {{ old('agama') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pekerjaan --}}
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <input type="text" id="pekerjaan" name="pekerjaan"
                                    class="form-control @error('pekerjaan') is-invalid @enderror"
                                    value="{{ old('pekerjaan') }}" placeholder="Masukkan pekerjaan">
                                @error('pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    placeholder="Masukkan email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nomor Asuransi --}}
                            <div class="mb-3">
                                <label for="nomor_asuransi" class="form-label">Nomor Asuransi</label>
                                <input type="text" id="nomor_asuransi" name="nomor_asuransi"
                                    class="form-control @error('nomor_asuransi') is-invalid @enderror"
                                    value="{{ old('nomor_asuransi') }}" placeholder="Masukkan nomor asuransi">
                                @error('nomor_asuransi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Kolom 2 --}}
                        <div class="col-md-6">
                            {{-- NIK --}}
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" id="nik" name="nik"
                                    class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}"
                                    placeholder="Masukkan NIK">
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Golongan Darah --}}
                            <div class="mb-3">
                                <label for="type_darah" class="form-label">Gol. Darah</label>
                                <select id="type_darah" name="type_darah"
                                    class="form-select @error('type_darah') is-invalid @enderror">
                                    <option value="" disabled {{ old('type_darah') ? '' : 'selected' }}>Pilih Gol.
                                        Darah</option>
                                    <option value="A" {{ old('type_darah') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('type_darah') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('type_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('type_darah') == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                                @error('type_darah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir') }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- No. BPJS --}}
                            <div class="mb-3">
                                <label for="no_bpjs" class="form-label">No. BPJS</label>
                                <input type="text" id="no_bpjs" name="no_bpjs"
                                    class="form-control @error('no_bpjs') is-invalid @enderror"
                                    value="{{ old('no_bpjs') }}" placeholder="Masukkan nomor BPJS">
                                @error('no_bpjs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nomor Telepon --}}
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor Telepon</label>
                                <input type="text" id="no_hp" name="no_hp"
                                    class="form-control @error('no_hp') is-invalid @enderror"
                                    value="{{ old('no_hp') }}" placeholder="Masukkan nomor telepon">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" id="alamat" name="alamat"
                                    class="form-control @error('alamat') is-invalid @enderror"
                                    value="{{ old('alamat') }}" placeholder="Masukkan alamat">
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row gx-3">
                                {{-- Kota --}}
                                <div class="col-md-6 mb-3">
                                    <label for="kota" class="form-label">Kota</label>
                                    <input type="text" id="kota" name="kota"
                                        class="form-control @error('kota') is-invalid @enderror"
                                        value="{{ old('kota') }}" placeholder="Masukkan kota">
                                    @error('kota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Provinsi --}}
                                <div class="col-md-6 mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <input type="text" id="provinsi" name="provinsi"
                                        class="form-control @error('provinsi') is-invalid @enderror"
                                        value="{{ old('provinsi') }}" placeholder="Masukkan provinsi">
                                    @error('provinsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row gx-3">
                                {{-- Kode Pos --}}
                                <div class="col-md-6 mb-3">
                                    <label for="kode_pos" class="form-label">Kode Pos</label>
                                    <input type="text" id="kode_pos" name="kode_pos"
                                        class="form-control @error('kode_pos') is-invalid @enderror"
                                        value="{{ old('kode_pos') }}" placeholder="Masukkan kode pos">
                                    @error('kode_pos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Negara --}}
                                <div class="col-md-6 mb-3">
                                    <label for="negara" class="form-label">Negara</label>
                                    <input type="text" id="negara" name="negara"
                                        class="form-control @error('negara') is-invalid @enderror"
                                        value="{{ old('negara', 'Indonesia') }}" placeholder="Masukkan negara">
                                    @error('negara')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div> {{-- /.row --}}
                </div> {{-- /.card-body --}}
            </div> {{-- /.card --}}


            {{-- ========================================== --}}
            {{-- Diagnosa Awal (Satu kolom gejala_awal saja) --}}
            {{-- ========================================== --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    {{-- Judul Card --}}
                    <h5 class="mb-3">Diagnosa Awal & Pilih Ruangan</h5>

                    <div class="gx-3 gy-3">
                        {{-- Kolom Gejala --}}
                        <div class="col-md-4">
                            <label for="gejala_awal" class="form-label">Gejala</label>
                            <input type="text" id="gejala_awal" name="gejala_awal"
                                class="form-control @error('gejala_awal') is-invalid @enderror"
                                value="{{ old('gejala_awal') }}" placeholder="Contoh: Demam, Batuk, Sakit Kepala"
                                required>
                            @error('gejala_awal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row gx-3 gy-3">
                            {{-- Kolom Ruangan --}}
                        <div class="col-md-4 mt-3">
                            <label for="ruangan_id" class="form-label">Ruangan</label>
                            <select id="ruangan_id" name="ruangan_id"
                                class="form-select @error('ruangan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach ($ruangan as $r)
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
                        {{-- Kolom Ruangan --}}
                        <div class="col-md-4 mt-3">
                            <label for="poli_id" class="form-label">Ruangan</label>
                            <select id="poli_id" name="poli_id"
                                class="form-select @error('poli_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach ($poli as $r)
                                    <option value="{{ $r->id }}"
                                        {{ old('poli_id') == $r->id ? 'selected' : '' }}>
                                        {{ $r->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ruangan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                    </div>
                </div>
            </div>



            {{-- ====== Bagian Kontak Darurat ====== --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Kontak Darurat</h5>

                    <div class="row gx-3 gy-3">
                        {{-- Nama Lengkap Kontak --}}
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="nama_kontak_darurat" class="form-label">Nama Lengkap</label>
                                <input type="text" id="nama_kontak_darurat" name="nama_kontak_darurat"
                                    class="form-control @error('nama_kontak_darurat') is-invalid @enderror"
                                    value="{{ old('nama_kontak_darurat') }}" placeholder="Masukkan nama kontak">
                                @error('nama_kontak_darurat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Nomor Telepon Kontak --}}
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="telepon_kontak_darurat" class="form-label">Nomor Telepon</label>
                                <input type="text" id="telepon_kontak_darurat" name="telepon_kontak_darurat"
                                    class="form-control @error('telepon_kontak_darurat') is-invalid @enderror"
                                    value="{{ old('telepon_kontak_darurat') }}" placeholder="Masukkan nomor telepon">
                                @error('telepon_kontak_darurat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Hubungan --}}
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="hubungan_kontak_darurat" class="form-label">Hubungan</label>
                                <input type="text" id="hubungan_kontak_darurat" name="hubungan_kontak_darurat"
                                    class="form-control @error('hubungan_kontak_darurat') is-invalid @enderror"
                                    value="{{ old('hubungan_kontak_darurat') }}"
                                    placeholder="Contoh: Ibu / Ayah / Saudara">
                                @error('hubungan_kontak_darurat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div> {{-- /.row --}}
                </div> {{-- /.card-body --}}
            </div> {{-- /.card --}}

            {{-- ====== Tombol Simpan / Tambah Antrian ====== --}}
            <div class="d-flex justify-content-end mb-5">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-plus me-2"></i> Tambah Antrian
                </button>
            </div>
        </form>
    </div>
@endsection
