@extends('siswa.main.sidebar')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold">Detail {{ ucfirst(str_replace('_', ' ', $tugas->tipe)) }}</h1>
            <a href="{{ route('siswa.tugas') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
        </div>

        <p class="text-gray-600 mt-2">📝 Judul: <strong>{{ $tugas->judul }}</strong></p>
        <p class="text-gray-600 mt-2">📄 Deskripsi: <strong>{{ $tugas->deskripsi }}</strong></p>
        <p class="text-gray-600 mt-2">⏳ Deadline: 
            <strong class="text-gray-800">
                {{ $tugas->deadline ? \Carbon\Carbon::parse($tugas->deadline)->format('d M Y') : '-' }}
            </strong>
        </p>
        @php
            $tugasUser = $tugas->tugasUser->first(); // diasumsikan sudah difilter berdasarkan user_id di controller
        @endphp
        <p class="text-gray-600 mt-2">📘 Status: 
            <strong class="text-sm {{ $userStatus && $userStatus->status == 'selesai' ? 'text-green-600' : 'text-red-600' }}">
                Status: {{ $userStatus && $userStatus->status == 'selesai' ? 'Selesai' : 'Belum Selesai' }}
            </strong>
        </p>



        @if ($tugas->cover)
        <!-- File tugas jika ada -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold">📂 File Tugas:</h2>
            <a href="{{ asset('storage/cover_tugas/'.$tugas->cover) }}" target="_blank" class="text-[#0A58CA] hover:underline">
                📄 Lihat / Download File
            </a>
        </div>
        @endif

        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold">📤 Jawaban Kamu</h2>

            @if ($userStatus && $userStatus->jawaban)
                <p class="text-gray-700">✅ Kamu sudah mengirim jawaban:</p>
                <a href="{{ asset('storage/jawaban_tugas/' . $userStatus->jawaban) }}" target="_blank" class="text-blue-600 hover:underline">
                    📄 Lihat / Download Jawaban
                </a>
            @elseif ($isExpired)
                <p class="text-red-600 font-semibold mt-4">❌ Maaf, waktu pengumpulan tugas telah berakhir.</p>
            @else
                <form action="{{ route('siswa.kirimJawaban', $tugas->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="jawaban" class="mt-2 p-2 w-full border rounded-lg" required>
                    <button class="mt-4 bg-[#0A58CA] text-white px-4 py-2 rounded-lg hover:bg-blue-600" type="submit">
                        Kirim Jawaban
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
