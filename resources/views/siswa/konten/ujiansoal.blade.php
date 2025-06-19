@extends('siswa.main.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Info Ujian dan Timer -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-xl font-bold">{{ $tugas->judul }}</h1>
                @if($tugas->durasi_menit)
                <div class="text-gray-600 mt-2">
                    <span id="timer" class="font-semibold text-red-600"></span>
                    <span class="text-sm text-gray-500 ml-2">(Durasi: {{ $tugas->durasi_menit }} menit)</span>
                </div>
                @endif
            </div>
            <div class="text-gray-600">
                Soal: <span class="font-semibold">{{ $nomor }}/{{ $totalSoal }}</span>
            </div>
        </div>

        <!-- Soal -->
        <div class="mb-8 p-4 border rounded-lg">
            <div class="prose max-w-none">
                {!! $soal->pertanyaan !!}
            </div>
        </div>

        <!-- Jawaban -->
        <form id="jawabanForm" class="space-y-4">
            @csrf
            <input type="hidden" name="soal_id" value="{{ $soal->id }}">

            @foreach(['a' => $soal->opsi_a, 'b' => $soal->opsi_b, 'c' => $soal->opsi_c, 'd' => $soal->opsi_d] as $key => $pilihan)
                @if(!empty($pilihan))
                <div class="flex items-center">
                    <input type="radio" id="pilihan{{ $key }}" name="jawaban" value="{{ $key }}" 
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        {{ $jawabanUser && $jawabanUser->jawaban == $key ? 'checked' : '' }}>
                    <label for="pilihan{{ $key }}" class="ml-3 block text-gray-700">
                        {{ $pilihan }}
                    </label>
                </div>
                @endif
            @endforeach
        </form>

        <!-- Navigasi -->
        <div class="flex justify-between mt-8">
            @if($nomor > 1)
                <a href="{{ route('siswa.tugas.ujian.soal', ['id' => $tugas->id, 'nomor' => $nomor - 1]) }}" 
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Sebelumnya
                </a>
            @else
                <div></div>
            @endif

            @if($nomor < $totalSoal)
                <a href="{{ route('siswa.tugas.ujian.soal', ['id' => $tugas->id, 'nomor' => $nomor + 1]) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Berikutnya
                </a>
            @else
                <a href="{{ route('siswa.tugas.ujian.selesai', $tugas->id) }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Selesai
                </a>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Timer berdasarkan durasi menit
    @if($tugas->durasi_menit)
    // Pastikan waktuMulai dalam format ISO
    const waktuMulai = new Date('{{ $waktuMulai }}').getTime();
    const durasiMenit = {{ $tugas->durasi_menit }};
    const durasiMs = durasiMenit * 60 * 1000; // 1 menit = 60.000 ms
    const waktuSelesai = waktuMulai + durasiMs;

    // Debugging - tampilkan waktu di console
    console.log('Waktu Mulai:', new Date(waktuMulai));
    console.log('Durasi (ms):', durasiMs);
    console.log('Waktu Selesai:', new Date(waktuSelesai));

    function updateTimer() {
        const sekarang = new Date().getTime();
        const sisaWaktu = waktuSelesai - sekarang;
        
        console.log('Sisa Waktu (ms):', sisaWaktu); // Debugging
        
        if (sisaWaktu <= 0) {
            document.getElementById('timer').textContent = 'Waktu habis!';
            window.location.href = '{{ route("siswa.tugas.ujian.selesai", $tugas->id) }}';
            return;
        }
        
        const menit = Math.floor(sisaWaktu / (1000 * 60)); // Perbaikan perhitungan
        const detik = Math.floor((sisaWaktu % (1000 * 60)) / 1000);
        
        document.getElementById('timer').textContent = 
            `${menit.toString().padStart(2, '0')}:${detik.toString().padStart(2, '0')}`;
        
        setTimeout(updateTimer, 1000);
    }

    updateTimer();
    @endif

    // Simpan jawaban
    const form = document.getElementById('jawabanForm');
    const radioButtons = document.querySelectorAll('input[type="radio"]');
    
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            const formData = new FormData(form);
            
            fetch('{{ route("siswa.tugas.ujian.jawab", $tugas->id) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (!response.ok) {
                    console.error('Gagal menyimpan jawaban');
                }
                return response.json();
            }).then(data => {
                console.log('Jawaban tersimpan', data);
            }).catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
@endsection