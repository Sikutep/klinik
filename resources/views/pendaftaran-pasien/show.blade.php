{{-- resources/views/pendaftaran-pasien/show.blade.php --}}
@extends('template.index')

@section('title', 'Detail Pasien')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4">Detail Pasien</h2>

    {{-- Bagian Data Pasien --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Data Pasien</h5>

            <div class="mb-3">
                <label class="form-label">No. Rekam Medis</label>
                <p class="form-control bg-light">{{ $data->mr_number }}</p>
            </div>

            <div class="row gx-3 gy-3">
                {{-- Kolom 1 --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <p class="form-control">{{ $data->nama }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <p class="form-control">{{ $data->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <p class="form-control">{{ $data->tempat_lahir }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Agama</label>
                        <p class="form-control">{{ $data->agama }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <p class="form-control">{{ $data->pekerjaan }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <p class="form-control">{{ $data->email }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Asuransi</label>
                        <p class="form-control">{{ $data->nomor_asuransi }}</p>
                    </div>
                </div>

                {{-- Kolom 2 --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <p class="form-control">{{ $data->nik }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gol. Darah</label>
                        <p class="form-control">{{ $data->type_darah }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <p class="form-control">{{ $data->tanggal_lahir }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. BPJS</label>
                        <p class="form-control">{{ $data->no_bpjs }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <p class="form-control">{{ $data->no_hp }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <p class="form-control">{{ $data->alamat }}</p>
                    </div>

                    <div class="row gx-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kota</label>
                            <p class="form-control">{{ $data->kota }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Provinsi</label>
                            <p class="form-control">{{ $data->provinsi }}</p>
                        </div>
                    </div>

                    <div class="row gx-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Pos</label>
                            <p class="form-control">{{ $data->kode_pos }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Negara</label>
                            <p class="form-control">{{ $data->negara }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Kontak Darurat --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Kontak Darurat</h5>

            <div class="row gx-3 gy-3">
                <div class="col-md-4">
                    <label class="form-label">Nama Lengkap</label>
                    <p class="form-control">{{ $data->nama_kontak_darurat }}</p>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Nomor Telepon</label>
                    <p class="form-control">{{ $data->telepon_kontak_darurat }}</p>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Hubungan</label>
                    <p class="form-control">{{ $data->hubungan_kontak_darurat }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Kembali --}}
    <div class="d-flex justify-content-end mb-5">
        <a href="{{ route('patiens.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
</div>
@endsection
