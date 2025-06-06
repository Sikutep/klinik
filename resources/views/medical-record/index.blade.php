{{-- resources/views/medical-record/index.blade.php --}}
@extends('template.index')

@section('title', 'Rekam Medis')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="heading-antrian">Rekam Medis</h1>

                <div class="box-antrian">
                    {{-- === HEADER: Tambah, Filter, Export === --}}
                    <div class="box-antrian-header">
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <a href="{{ route('medicalrecord.create') }}" class="btn-tambah-pasien">
                                + Tambah
                            </a>

                            <form action="{{ route('medicalrecord.index') }}" method="GET"
                                class="form-pencarian d-flex gap-2">
                                {{-- Cari Dokter --}}
                                <input type="text" name="doctor_name" placeholder="Cari Dokter Pemeriksa"
                                    class="input-pencarian nama" value="{{ request('doctor_name') }}" />

                                {{-- Cari Nama Pasien --}}
                                <input type="text" name="patient_name" placeholder="Cari Nama Pasien"
                                    class="input-pencarian nomor-antrian" value="{{ request('patient_name') }}" />

                                {{-- Cari Nomor Rekam Medis --}}
                                <input type="text" name="mr_number" placeholder="Cari Nomor Rekam Medis"
                                    class="input-pencarian nomor-rekam-medis" value="{{ request('mr_number') }}" />

                                <button type="submit" class="btn-cari">Cari</button>
                            </form>
                        </div>

                        <div>
                            <a href="{{ route('queues.export', request()->all()) }}" class="btn btn-primary text-white">
                                Export Excel
                            </a>
                        </div>
                    </div>

                    {{-- === TABEL REKAM MEDIS === --}}
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Dokter Pemeriksa</th>
                                <th>Nama Pasien</th>
                                <th>Nomor Rekam Medis</th>
                                <th>Tindakan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($records as $index => $record)
                                <tr>
                                    {{-- Kolom No (urut berdasar pagination) --}}
                                    <td>{{ $records->firstItem() + $index }}</td>

                                    {{-- Nama Dokter --}}
                                    <td>
                                        @if ($record->doctor)
                                            {{ $record->doctor->nama }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- Nama Pasien --}}
                                    <td>
                                        @if ($record->patient)
                                            {{ $record->patient->nama }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- Nomor Rekam Medis (ambil dari pasien) --}}
                                    <td>
                                        @if ($record->patient && $record->patient->mr_number)
                                            {{ $record->patient->mr_number }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- Tindakan (tampilkan treatment_plan atau dash) --}}
                                    <td>
                                        @if ($record->tindakans->isNotEmpty())
                                            {{ $record->tindakans->pluck('nama')->implode(', ') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @switch($record->status)
                                            @case('draft')
                                                <span class="badge bg-secondary">Draft</span>
                                            @break

                                            @case('final')
                                                <span class="badge bg-success">Final</span>
                                            @break

                                            @case('revisi')
                                                <span class="badge bg-warning text-dark">Revisi</span>
                                            @break

                                            @default
                                                <span class="badge bg-light text-dark">{{ ucfirst($mr->status) }}</span>
                                        @endswitch
                                    </td>

                                    {{-- Action: View / Edit / Delete --}}
                                    <td>
                                        <div class="action-buttons d-none d-md-flex">
                                            {{-- View --}}
                                            <a href="{{ route('medicalrecord.show', $record->id) }}"
                                                class="btn-view text-white d-inline-flex align-items-center justify-content-center p-2 rounded mx-1"
                                                title="View">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('medicalrecord.edit', $record->id) }}"
                                                class="btn-edit text-white d-inline-flex align-items-center justify-content-center p-2 rounded mx-1"
                                                title="Edit">
                                                <i class="fa-solid fa-pencil-alt"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('medicalrecord.destroy', $record->id) }}" method="POST"
                                                class="d-inline mx-1"
                                                onsubmit="return confirm('Yakin ingin menghapus rekam medis ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn-delete text-white d-inline-flex align-items-center justify-content-center p-2 rounded"
                                                    title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                        {{-- Mobile View: Hamburger Dropdown --}}
                                        <div class="dropdown d-md-none">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-bars"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('medicalrecord.show', $record->id) }}">
                                                        <i class="fa-solid fa-eye me-2"></i>View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('medicalrecord.edit', $record->id) }}">
                                                        <i class="fa-solid fa-pencil-alt me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('medicalrecord.destroy', $record->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus rekam medis ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">
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
                                        <td colspan="6" class="text-center">Belum ada data rekam medis.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- === PAGINATION LINKS === --}}
                        <div class="d-flex justify-content-center mt-3">
                            {{ $records->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
