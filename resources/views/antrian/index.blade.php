{{-- resources/views/antrian/index.blade.php --}}
@extends('template.index')

@section('title', 'Antrian')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="heading-antrian">Antrian Pasien</h1>

                <div class="box-antrian">
                    {{-- === HEADER: Tambah, Filter, Export === --}}
                    <div class="box-antrian-header">
                        <div class="box-antrian-header-left">
                            {{-- Tombol “+ Tambah Pasien” (sesuaikan route create pasien Anda)
                            <a href="{{ route('patiens.create') }}" class="btn-tambah-pasien"
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
                                + Tambah Pasien
                            </a> --}}

                            {{-- Form Pencarian Sederhana: Nama / Nomor Antrian / Status --}}
                            <form action="{{ route('antrian.index') }}" method="GET" class="form-pencarian mt-3">
                                <input type="text" name="search_name" placeholder="Cari nama"
                                    class="input-pencarian nama" value="{{ request('search_name') }}" />
                                <input type="text" name="search_queue" placeholder="Cari nomor antrian"
                                    class="input-pencarian nomor-antrian" value="{{ request('search_queue') }}" />
                                <select name="status" class="input-pencarian status">
                                    <option value="">Status</option>
                                    <option value="dipanggil" {{ request('status') == 'dipanggil' ? 'selected' : '' }}>
                                        Calling
                                    </option>
                                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                                        Waiting
                                    </option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                        Complete
                                    </option>
                                </select>
                                <button type="submit" class="btn-cari">Cari</button>
                            </form>
                        </div>

                        {{-- Tombol Export Excel (jika sudah ada route/function‐nya) --}}
                        <div class="box-antrian-header-right">
                            <a href="{{ route('queues.export', request()->all()) }}" class="btn-export-excel"
                                style="
                                    display: inline-flex;
                                    align-items: center;
                                    justify-content: center;
                                    width: 160px;
                                    height: 50px;
                                    background-color: #418FC0;
                                    color: white;
                                    font-size: 16px;
                                    font-weight: 500;
                                    border-radius: 6px;
                                    text-decoration: none;
                                    cursor: pointer;
                                    transition: background-color 0.3s, transform 0.3s;
                                ">
                                Export Excel
                            </a>
                        </div>
                        <div class="box-antrian-header-right">
                            <a target="_blank" href="{{ route('antrian.showMonitor', request()->all()) }}"
                                class="btn btn-success"
                                style="
                                    display: inline-flex;
                                    align-items: center;
                                    justify-content: center;
                                    width: 80px;
                                    height: 50px;
                                    background-color: #418FC0;
                                    color: white;
                                    font-size: 12px;
                                    font-weight: 500;
                                    border-radius: 6px;
                                    text-decoration: none;
                                    cursor: pointer;
                                    transition: background-color 0.3s, transform 0.3s;
                                ">
                                <i class="fa-solid fa-computer"></i>
                            </a>
                        </div>
                    </div>

                    {{-- === TABEL ANTRIAN PASIEN === --}}
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Nomor Antrian</th>
                                <th>Status</th>
                                <th>Waktu Panggilan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($queues as $index => $queue)
                                <tr>
                                    {{-- Kolom No (urut berdasarkan halaman) --}}
                                    <td>{{ $queues->firstItem() + $index }}</td>

                                    {{-- Nama Pasien via relasi patient --}}
                                    <td>
                                        @if ($queue->patient)
                                            {{ $queue->patient->nama }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- Nomor Antrian (kolom di table) --}}
                                    <td>{{ $queue->nomor_antrian }}</td>

                                    {{-- Status: beri badge dengan warna sesuai --}}
                                    <td>
                                        @php
                                            $stat = strtolower($queue->status);
                                            $badgeClass = '';
                                            if ($stat === 'dipanggil') {
                                                $badgeClass = 'status-calling';
                                            } elseif ($stat === 'menunggu') {
                                                $badgeClass = 'status-waiting';
                                            } elseif ($stat === 'selesai') {
                                                $badgeClass = 'status-complete';
                                            } else {
                                                $badgeClass = 'status-default';
                                            }
                                        @endphp
                                        <span class="status-badge {{ $badgeClass }}">
                                            {{ ucfirst($stat) }}
                                        </span>
                                    </td>

                                    {{-- Waktu Panggilan: cetak tanggal jika ada, else “-” --}}
                                    <td>
                                        @if ($queue->called_at)
                                            {{ $queue->called_at }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- Action: View / Edit / Delete --}}
                                    <td>
                                        <div class="action-buttons d-none d-md-flex">
                                            @if ($queue->patient)
                                                @if ($stat == 'menunggu')
                                                    <form action="{{ route('antrian.panggil', $queue->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn-view text-white d-inline-flex align-items-center justify-content-center p-2 rounded"
                                                            title="Panggil">
                                                            <i class="fa-solid fa-phone"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button type="button"
                                                        class="btn-view text-white d-inline-flex align-items-center justify-content-center p-2 rounded opacity-50"
                                                        title="Sudah dipanggil" disabled>
                                                        <i class="fa-solid fa-phone"></i>
                                                    </button>
                                                @endif
                                            @endif

                                        </div>

                                        {{-- Mobile View: Dropdown --}}
                                        <div class="dropdown d-md-none">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-bars"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    @if ($queue->patient)
                                                        @if ($stat == 'menunggu')
                                                            <form action="{{ route('antrian.panggil', $queue->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="dropdown-item"
                                                                    title="Panggil">
                                                                    <i class="fa-solid fa-phone"></i>
                                                                    Panggil
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button type="button"
                                                                class="dropdown-item opacity-50"
                                                                title="Sudah dipanggil" disabled>
                                                                <i class="fa-solid fa-phone"></i>
                                                                panggil
                                                            </button>
                                                        @endif
                                                    @endif
                                                </li>



                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data antrian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- === PAGINATION LINKS === --}}
                    <div class="d-flex justify-content-center mt-3">
                        {{ $queues->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Warna badge khusus (Anda sudah punya di CSS) --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".status-badge").forEach(function(el) {
                const status = el.textContent.trim().toLowerCase();
                if (status === "dipanggil") {
                    el.style.backgroundColor = "#418FC0"; // calling
                } else if (status === "menunggu") {
                    el.style.backgroundColor = "#A1A8AA"; // waiting
                } else if (status === "selesai") {
                    el.style.backgroundColor = "#28a745"; // complete
                } else {
                    el.style.backgroundColor = "#888"; // default
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session()->has('announce_queue'))
                const pasien_nama = "{{ session('name_queue') }}"
                const queueNum = "{{ session('announce_queue') }}";
                const poli_queue = "{{ session('poli_queue') }}"
                const ruangan_queue = "{{ session('ruangan_queue') }}"
                const message = "Antrian nomor. " + queueNum + "."+poli_queue+"."+ "Dengan nama."+ pasien_nama +". Silahkan menuju, ke ruangan"+ ruangan_queue+".";

                if ('speechSynthesis' in window) {
                    const utter = new SpeechSynthesisUtterance(message);
                    utter.lang = 'id-ID';
                    utter.rate = 0.9;
                    utter.pitch = 1; // Nada suara

                    function pilihVoiceGoogle() {
                        const voices = window.speechSynthesis.getVoices();
                        // Cari voice Google Bahasa Indonesia (biasanya namanya persis "Google Bahasa Indonesia")
                        let selected = voices.find(v =>
                            v.name.toLowerCase().includes('google bahasa indonesia')
                        );
                        // Jika tidak ketemu persis, fallback ke voice id-ID apa pun
                        if (!selected) {
                            selected = voices.find(v => v.lang === 'id-ID');
                        }
                        if (selected) {
                            utter.voice = selected;
                        }
                        window.speechSynthesis.speak(utter);
                    }

                    // Tunggu sampai daftar voice ter‐load
                    window.speechSynthesis.onvoiceschanged = pilihVoiceGoogle;
                    // Jika voice sudah tersedia, panggil langsung
                    const immediateVoices = window.speechSynthesis.getVoices();
                    if (immediateVoices.length) {
                        pilihVoiceGoogle();
                    }
                } else {
                    // Fallback
                    alert(message);
                }
            @endif
        });
    </script>

@endsection
