{{-- resources/views/antrian/monitor_patient.blade.php --}}
@php
    use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monitor Antrian (Patient View)</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .card-patient {
            width: 360px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 24px;
            text-align: center;
        }
        .card-patient .field-label {
            font-size: 12px;
            color: #888888;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .card-patient .field-value {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #333333;
        }
        .card-patient .status-label {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
            transition: background-color 0.2s;
            margin-top: 12px;
        }
        .status-dipanggil {
            background-color: #418FC0;
        }
        .status-lainnya {
            background-color: #6c757d;
        }
        .status-dipanggil:hover {
            background-color: #3273a8;
        }
        .empty-message {
            font-size: 20px;
            color: #555555;
        }
    </style>
    <script>
        // Jika ingin auto‐refresh setiap beberapa detik (misalnya 30 detik),
        // bisa tambahkan:
        setTimeout(function() {
            location.reload();
        }, 10000);
    </script>
</head>
<body>
    @if($queue)
        <div class="card-patient">
            {{-- Nomor Antrian --}}
            <div class="field-label">Nomor Antrian</div>
            <div class="field-value">{{ $queue->nomor_antrian }}</div>

            {{-- Nama Pasien --}}
            <div class="field-label">Nama</div>
            <div class="field-value">{{ $queue->patient->nama ?? '-' }}</div>

            {{-- MR Number --}}
            <div class="field-label">MR Number</div>
            <div class="field-value">{{ $queue->patient->mr_number ?? '-' }}</div>

            {{-- Status --}}
            <div class="field-label">Status</div>
            @if(Str::lower($queue->status) === 'dipanggil')
                <div class="status-label status-dipanggil">
                    {{ ucfirst($queue->status) }}
                </div>
            @else
                <div class="status-label status-lainnya">
                    {{ ucfirst($queue->status) }}
                </div>
            @endif
        </div>
    @else
        <div class="empty-message">
            Belum ada antrian.
        </div>
    @endif

        {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const status = "{{ Str::lower($queue->status ?? '') }}";
            const queueNum = "{{ $queue->nomor_antrian ?? '' }}";

            if (status === 'dipanggil') {
                // Buat teks untuk dibacakan
                const message = "Antrian nomor " + queueNum + " dipanggil.";

                if ('speechSynthesis' in window) {
                    const utter = new SpeechSynthesisUtterance(message);
                    utter.lang = 'id-ID';
                    utter.rate = 1;
                    utter.pitch = 1;
                    window.speechSynthesis.speak(utter);
                } else {
                    console.warn("Browser tidak mendukung SpeechSynthesis.");
                }
            }
        });
    </script> --}}
</body>
</html>
