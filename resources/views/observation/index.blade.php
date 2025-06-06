{{-- resources/views/observation/index.blade.php --}}
@extends('template.index')

@section('title', 'Observasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="heading-antrian">Observasi</h1>

            <div class="box-antrian">
                {{-- === HEADER: Tambah, Filter, Export === --}}
                <div class="box-antrian-header d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        {{-- Tombol “+ Tambah Observasi” --}}
                        <a href="{{ route('observation.create') }}"
                           class="btn-tambah-pasien"
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
                            + Tambah
                        </a>

                        {{-- Form Pencarian Nama Pasien --}}
                        <form action="{{ route('observation.index') }}" method="GET" class="form-pencarian d-flex gap-2 mt-3 mt-md-0">
                            <input type="text"
                                   name="search"
                                   placeholder="Cari Nama Pasien"
                                   class="input-pencarian nama form-control form-control-sm"
                                   value="{{ request('search') }}" />

                            <button type="submit"
                                    class="btn-cari btn btn-secondary btn-sm">
                                Cari
                            </button>
                        </form>
                    </div>

                    {{-- Tombol Export Excel --}}
                    <div>
                        <a href="{{ route('observation.export', request()->all()) }}"
                           class="btn-export-excel btn btn-outline-success btn-sm">
                            <i class="fa-solid fa-file-excel me-1"></i> Export Excel
                        </a>
                    </div>
                </div>

                {{-- === TABEL OBSERVASI === --}}
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Observasi</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal Observasi</th>
                            <th>Status</th>
                            <th>Observer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($observations as $index => $obs)
                            <tr>
                                {{-- No (urut pagination) --}}
                                <td>{{ $observations->firstItem() + $index }}</td>

                                {{-- Nomor Observasi --}}
                                <td>{{ 'OB-' . \Carbon\Carbon::parse($obs->observed_at)->format('Ymd') . '-' . str_pad($obs->id, 3, '0', STR_PAD_LEFT) }}</td>

                                {{-- Nama Pasien --}}
                                <td>{{ $obs->patient_name }}</td>

                                {{-- Tanggal Observasi --}}
                                <td>{{ \Carbon\Carbon::parse($obs->observed_at)->format('Y-m-d H:i') }}</td>

                                {{-- Status (Placeholder karena belum ada field status) --}}
                                <td>
                                    <span class="status-badge">–</span>
                                </td>

                                {{-- Observer --}}
                                <td>{{ $obs->observer_name }}</td>

                                {{-- Action: View / Edit / Delete --}}
                                <td>
                                    <div class="action-buttons d-none d-md-flex gap-1">
                                        <a href="{{ route('observation.show', $obs->id) }}"
                                           class="btn-view btn btn-sm btn-info text-white d-inline-flex align-items-center justify-content-center p-2 rounded"
                                           title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('observation.edit', $obs->id) }}"
                                           class="btn-edit btn btn-sm btn-warning text-white d-inline-flex align-items-center justify-content-center p-2 rounded"
                                           title="Edit">
                                            <i class="fa-solid fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('observation.destroy', $obs->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus observasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn-delete btn btn-sm btn-danger text-white d-inline-flex align-items-center justify-content-center p-2 rounded"
                                                    title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Mobile View: Dropdown --}}
                                    <div class="dropdown d-md-none">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle"
                                                type="button"
                                                data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-bars"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item"
                                                   href="{{ route('observation.show', $obs->id) }}">
                                                    <i class="fa-solid fa-eye me-2"></i>View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                   href="{{ route('observation.edit', $obs->id) }}">
                                                    <i class="fa-solid fa-pencil-alt me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('observation.destroy', $obs->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Yakin ingin menghapus observasi ini?')">
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
                                <td colspan="7" class="text-center">Belum ada data observation.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- === PAGINATION LINKS === --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $observations->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Skrip untuk mewarnai status-badge --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".status-badge").forEach(function(el) {
            el.style.backgroundColor = "#888"; // placeholder warna abu‐abu
            el.style.color = "#fff";
            el.style.padding = "2px 6px";
            el.style.borderRadius = "4px";
            el.style.fontSize = "0.875rem";
        });
    });
</script>
@endsection
