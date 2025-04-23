@extends('admin.main.sidebar')

@section('content')

<!-- Main Content -->
<main class="p-6 bg-gray-100 min-h-screen">
    <!-- Tombol Tambah -->
    <div class="flex justify-end mb-6">
        <a href="/tambah-tugas" class="bg-[#0A58CA] text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">Tambah Tugas</a>
    </div>

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
            @for ($i = 1; $i <= 7; $i++)
            <a href="{{ route('admin.tugas.detail', ['id' => $i]) }}" class="block">
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
            <a href="{{ route('admin.kuis.detail', ['id' => $i]) }}" class="block">
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
