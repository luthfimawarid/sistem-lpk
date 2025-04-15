@extends('siswa.main.sidebar')

@section('content')
<!-- <div class="header flex justify-between items-center bg-white p-4 shadow-sm">
    <h1 class="text-xl font-semibold">Welcome Back, Alamsyah!</h1>
    <div class="flex items-center space-x-4">
        <svg class="w-6 h-6 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
        </svg>
        <svg class="w-8 h-8 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
        </svg>
    </div>
</div> -->

<!-- Main Content -->
<main class="p-6 bg-gray-100 min-h-screen">
    <!-- Ujian Akhir -->
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-4">Ujian Akhir (2)</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <img src="/logo.png" alt="Kanji" class="mx-auto rounded-md">
                <p class="mt-2 font-medium">Mengenal Kanji Dasar (JLPT N5-N4)</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <img src="/logo.png" alt="Budaya Jepang" class="mx-auto rounded-md">
                <p class="mt-2 font-medium">Keberagaman Budaya Jepang</p>
            </div>
        </div>
    </section>

    <!-- Tugas -->
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-4">Tugas (7)</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @for ($i = 1; $i <= 3; $i++)
            <a href="{{ route('siswa.tugas.detail', ['id' => $i]) }}" class="block">
                <div class="bg-white rounded-lg shadow p-4 text-center hover:shadow-md transition h-full">
                    <img src="/logo.png" alt="Tugas {{ $i }}" class="mx-auto rounded-md">
                    <p class="mt-2 font-medium text-blue-500 hover:underline">Tugas {{ $i }}</p>
                    <p class="text-sm text-gray-600">Deadline: 10 Agustus 2024</p>
                    <p class="text-sm text-green-600">Status: Selesai</p>
                </div>
            </a>
            @endfor
        </div>
    </section>

    <!-- Kuis Harian -->
    <section>
        <h2 class="text-2xl font-semibold mb-4">Kuis Harian</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @for ($i = 1; $i <= 3; $i++)
            <a href="{{ route('siswa.kuis.detail', ['id' => $i]) }}" class="block">
                <div class="bg-white rounded-lg shadow p-4 text-center hover:shadow-md transition h-full">
                    <img src="/logo.png" alt="Kuis {{ $i }}" class="mx-auto rounded-md">
                    <p class="mt-2 font-medium text-blue-500 hover:underline">Kuis {{ $i }}</p>
                    <p class="text-sm text-gray-600">Deadline: 5 Agustus 2024</p>
                    <p class="text-sm text-red-600">Status: Belum Selesai</p>
                </div>
            </a>
            @endfor
        </div>
    </section>
</main>
@endsection
