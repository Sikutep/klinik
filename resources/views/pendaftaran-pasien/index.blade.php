{{-- resources/views/patiens/index.blade.php --}}
@extends('template.index')

@section('title', 'Pendaftaran Pasien')

@section('content')
@php use App\Helpers\EncryptHelper; @endphp

<div class="container-fluid">
    {{-- Notifikasi Sukses / Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="row mt-3">
        <div class="col-md-12">
            <h1 class="heading-antrian mb-4">Data Pasien</h1>

            <div class="box-antrian">
                {{-- === HEADER: Tambah Pasien, Pencarian, Export === --}}
                <div class="box-antrian-header d-flex justify-content-between align-items-center mb-3">
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        {{-- Tombol “+ Tambah Pasien” --}}
                        <a href="{{ route('patiens.create') }}"
                           onmouseover="this.style.backgroundColor='#003454'; this.style.transform='translateY(-2px)';"
                           onmouseout="this.style.backgroundColor='#00426B'; this.style.transform='none';"
                           style="
                               display: inline-flex;
                               align-items: center;
                               justify-content: center;
                               width: 160px;
                               height: 50px;
                               background-color: #00426B;
                               color: white;
                               font-size: 16px;
                               font-weight: 500;
                               border-radius: 6px;
                               text-decoration: none;
                               cursor: pointer;
                               transition: background-color 0.3s, transform 0.3s;
                           ">
                           <i class="fa-solid fa-plus me-1"></i> Tambah Pasien
                        </a>

                        {{-- Form Pencarian --}}
                        <div class="form-pencarian">
                            <form action="{{ route('patiens.index') }}" method="GET" class="d-flex gap-2">
                                <input type="text"
                                       name="search"
                                       placeholder="Cari nama"
                                       class="form-control form-control-sm nama"
                                       value="{{ request('search') }}" />

                                <input type="text"
                                       name="mr_search"
                                       placeholder="Cari Nomor Rekam Medis"
                                       class="form-control form-control-sm nomor-antrian"
                                       value="{{ request('mr_search') }}" />

                                <select class="form-select form-select-sm select-pencarian" name="gender">
                                    <option value="">Jenis Kelamin</option>
                                    <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>
                                        Laki-Laki
                                    </option>
                                    <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>

                                <button type="submit" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Tombol Export Excel (bila ada fungsionalitasnya) --}}
                    <div>
                        <a href="{{ route('patiens.export', request()->all()) }}" class="btn btn-outline-success btn-sm">
                            <i class="fa-solid fa-file-excel me-1"></i> Export Excel
                        </a>
                    </div>
                </div>

                {{-- === TABEL DATA PASIEN === --}}
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nomor Rekam Medis</th>
                                <th>Nama Pasien</th>
                                <th>Jenis Kelamin</th>
                                <th>Nomor Telepon</th>
                                <th>Antrian</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patiens as $index => $pasien)
                                <tr>
                                    <td>{{ $patiens->firstItem() + $index }}</td>
                                    <td>{{ $pasien->mr_number }}</td>
                                    <td>{{ $pasien->nama }}</td>
                                    <td>{{ $pasien->gender }}</td>
                                    <td>{{ $pasien->no_hp }}</td>

                                    {{-- Kolom “Tambah ke Antrian”: tombol pemicu modal --}}
                                    <td>
                                        <button type="button"
                                                class="btn btn-sm btn-primary btn-add-queue"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalTambahAntrianPasien"
                                                data-patient-id="{{ EncryptHelper::encryptId($pasien->id) }}"
                                                data-patient-name="{{ $pasien->nama }}"
                                                title="Tambah ke Antrian">
                                            <i class="fa-solid fa-list me-1"></i> +
                                        </button>
                                    </td>

                                    {{-- Kolom Action (View / Edit / Delete) --}}
                                    <td>
                                        <div class="action-buttons d-none d-md-flex gap-1">
                                            <a href="{{ route('patiens.show', EncryptHelper::encryptId($pasien->id)) }}"
                                               class="btn btn-sm btn-info" title="View">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('patiens.edit', EncryptHelper::encryptId($pasien->id)) }}"
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fa-solid fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('patiens.destroy', EncryptHelper::encryptId($pasien->id)) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin mau menghapus pasien ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                        {{-- Mobile view: dropdown --}}
                                        <div class="dropdown d-md-none">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle"
                                                    type="button"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                       href="{{ route('patiens.show', EncryptHelper::encryptId($pasien->id)) }}">
                                                        <i class="fa-solid fa-eye me-2"></i>View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                       href="{{ route('patiens.edit', EncryptHelper::encryptId($pasien->id)) }}">
                                                        <i class="fa-solid fa-pencil-alt me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('patiens.destroy', EncryptHelper::encryptId($pasien->id)) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Yakin mau menghapus?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item">
                                                            <i class="fa-solid fa-trash me-2"></i>Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data pasien.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $patiens->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal: Tambah Antrian dari Daftar Pasien --}}
<div class="modal fade" id="modalTambahAntrianPasien" tabindex="-1" aria-labelledby="modalTambahAntrianPasienLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {{-- Form action akan di‐set dinamis oleh JavaScript --}}
            <form id="formTambahAntrianPasien" method="POST" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAntrianPasienLabel">Tambah Antrian Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Pasien: <strong><span id="modal-pasien-name"></span></strong></p>

                    {{-- Dropdown Poli --}}
                    <div class="mb-3">
                        <label for="modal_poli_id" class="form-label">Pilih Poli</label>
                        <select name="poli_id"
                                id="modal_poli_id"
                                class="form-select @error('poli_id') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Poli --</option>
                            @foreach($poli as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                        @error('poli_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Dropdown Ruangan --}}
                    <div class="mb-3">
                        <label for="modal_ruangan_id" class="form-label">Pilih Ruangan</label>
                        <select name="ruangan_id"
                                id="modal_ruangan_id"
                                class="form-select @error('ruangan_id') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($ruangan as $r)
                                <option value="{{ $r->id }}">{{ $r->nama }}</option>
                            @endforeach
                        </select>
                        @error('ruangan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit"
                            class="btn btn-primary">
                        <i class="fa-solid fa-list me-1"></i> Tambah ke Antrian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- ================================================ --}}

{{-- Skrip untuk mengisi modal dan meng‐set action form --}}
<script>
     document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalTambahAntrianPasien');
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Tombol yang meng‐trigger modal
            const encryptedPatientId = button.getAttribute('data-patient-id');
            const patientName = button.getAttribute('data-patient-name');

            // Tampilkan nama pasien di modal
            document.getElementById('modal-pasien-name').textContent = patientName;

            // Tentukan action form => /patiens/{encryptedId}/queues
            const form = document.getElementById('formTambahAntrianPasien');
            form.action = "{{ url('patiens') }}/" + encryptedPatientId + "/queues";
            // Contoh hasil: jika encryptedPatientId = "AbC123", maka => "/patiens/AbC123/queues"
        });
    });
</script>
@endsection
