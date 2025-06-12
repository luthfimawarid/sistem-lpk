@extends('siswa.main.sidebar')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold">Detail Kuis</h1>
            <a href="{{ route('siswa.tugas') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
        </div>

        <p class="text-gray-600 mt-2">📝 Judul: <strong>{{ $tugas->judul }}</strong></p>
        <p class="text-gray-600 mt-2">📄 Deskripsi: <strong>{{ $tugas->deskripsi }}</strong></p>
        <p class="text-gray-600 mt-2">⏳ Deadline: 
            <strong class="{{ $tugas->status === 'belum_selesai' ? 'text-red-500' : 'text-green-500' }}">
                {{ $tugas->deadline ? \Carbon\Carbon::parse($tugas->deadline)->format('d M Y') : '-' }}
            </strong>
        </p>

        <!-- Form Jawaban -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold">📝 Soal Kuis</h2>
            @if ($isExpired)
                <p class="text-red-600 font-semibold mt-4">❌ Maaf, waktu kuis telah berakhir. Kamu tidak bisa lagi menjawab soal.</p>
            @elseif ($userStatus && $userStatus->status == 'selesai')
                <p class="text-green-600 font-semibold mt-4">✅ Kamu sudah menyelesaikan kuis ini.</p>
            @else
                <form id="kuisForm" action="{{ route('kuis.jawab', $tugas->id) }}" method="POST">
                    @csrf
                    @foreach ($tugas->soalKuis as $index => $soal)
                    <div class="mt-6">
                        <p class="font-medium">{{ $index + 1 }}. {{ $soal->pertanyaan }}</p>

                        @foreach (['a', 'b', 'c', 'd'] as $opt)
                        <label class="block mt-2">
                            <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $opt }}" class="mr-2" required>
                            {{ strtoupper($opt) }}. {{ $soal->{'opsi_'.$opt} }}
                        </label>
                        @endforeach
                    </div>
                    @endforeach

                    <button type="submit" class="mt-6 bg-[#0A58CA] text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Kirim Jawaban
                    </button>
                </form>
            @endif

            <!-- Modal nilai -->
            <div id="hasilModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h2 class="text-xl font-bold mb-4">🎉 Nilai Anda</h2>
                    <p id="nilaiText" class="text-3xl font-semibold text-blue-600"></p>
                    <button onclick="closeModal()" class="mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const form = document.getElementById('kuisForm');
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.nilai !== undefined) {
                document.getElementById('nilaiText').innerText = data.nilai;
                document.getElementById('hasilModal').classList.remove('hidden');
            } else {
                alert("Terjadi kesalahan dalam penilaian.");
            }
        })
        .catch(err => {
            alert("Gagal mengirim jawaban.");
            console.error(err);
        });
    });

    function closeModal() {
        document.getElementById('hasilModal').classList.add('hidden');
        window.location.href = "{{ route('siswa.tugas') }}"; // Redirect setelah modal ditutup
    }
</script>
@endsection

