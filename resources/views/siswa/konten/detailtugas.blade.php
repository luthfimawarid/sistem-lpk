@extends('siswa.main.sidebar')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Detail {{ ucfirst(str_replace('_', ' ', $tugas->tipe)) }}</h1>
            <a href="{{ route('siswa.tugas') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
        </div>

        <div class="mt-4">
            <p class="text-gray-600">📝 Judul: <strong>{{ $tugas->judul }}</strong></p>
            <p class="text-gray-600 mt-2">📄 Deskripsi: <strong>{{ $tugas->deskripsi }}</strong></p>
            <p class="text-gray-600 mt-2">⏳ Deadline: 
                <strong class="text-white">
                    {{ $tugas->deadline ? \Carbon\Carbon::parse($tugas->deadline)->format('d M Y') : '-' }}
                </strong>
            </p>

            <p class="text-gray-600 mt-2">📘 Status: 
                <strong class="text-sm {{ $userStatus && $userStatus->status == 'selesai' ? 'text-blue-800' : 'text-red-600' }}">
                    {{ $userStatus && $userStatus->status == 'selesai' ? 'Selesai' : 'Belum Selesai' }}
                </strong>
            </p>
        </div>

        @if ($tugas->cover)
        <!-- 📂 File Tugas -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold">📂 File Tugas:</h2>
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 mt-2">
                <a href="{{ asset('storage/' . $tugas->cover) }}" target="_blank"
                   class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-[#0A58CA] text-sm flex items-center">
                   <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                   Lihat File
                </a>
                <a href="{{ asset('storage/' . $tugas->cover) }}" download
                   class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg hover:bg-blue-800 text-sm flex items-center">
                   <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25L13 11.15Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0ZM17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z" clip-rule="evenodd"/>
                    </svg>
                    Download File
                </a>
            </div>
        </div>
        @endif

        <!-- 📤 Jawaban Kamu -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold">📤 Jawaban Kamu</h2>

            @if ($userStatus && $userStatus->jawaban)
                <p class="text-gray-700">✅ Kamu sudah mengirim jawaban:</p>
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 mt-2">
                    <a href="{{ asset('storage/' . $tugas->cover) }}" target="_blank"
                       class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-[#0A58CA] text-sm flex items-center">
                       <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                       Lihat Jawaban
                    </a>
                    <a href="{{ asset('storage/' . $tugas->cover) }}" download
                       class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg hover:bg-blue-800 text-sm flex items-center">
                       <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25L13 11.15Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0ZM17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z" clip-rule="evenodd"/>
                        </svg>
                        Download Jawaban
                    </a>
                </div>
            @elseif ($isExpired)
                <p class="text-red-600 font-semibold mt-4">❌ Maaf, waktu pengumpulan tugas telah berakhir.</p>
            @else
                <form action="{{ route('siswa.kirimJawaban', $tugas->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700">Upload Jawaban:</label>
                    <input type="file" name="jawaban" class="mt-2 p-2 w-full border rounded-lg" required>
                    <button class="mt-4 bg-[#0A58CA] text-white px-4 py-2 rounded-lg hover:bg-[#0A58CA]" type="submit">
                        Kirim Jawaban
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
