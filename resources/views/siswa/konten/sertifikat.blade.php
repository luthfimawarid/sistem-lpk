@extends('siswa.main.sidebar')

@section('content')

<main class="p-6">
    <h2 class="text-xl md:text-2xl font-semibold mb-4">Sertifikat Kelulusan</h2>

    {{-- Bahasa --}}
    <h3 class="text-lg font-semibold mb-2">Sertifikat Bahasa</h3>
    @forelse ($sertifikatBahasa as $sertifikat)
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col md:flex-row items-center mb-6">
            <div class="md:w-1/2 flex justify-center">
                <img src="{{ asset('storage/' . $sertifikat->file) }}" alt="Sertifikat" class="w-60 h-48 object-cover rounded-lg">
            </div>
            <div class="md:w-1/2 text-center md:text-left mt-4 md:mt-0">
                <h4 class="font-bold">{{ $sertifikat->judul }}</h4>
                <p class="my-2 text-sm">{{ $sertifikat->deskripsi }}</p>
                <div class="flex gap-2 justify-center md:justify-start mt-4">
                    <a href="{{ asset('storage/' . $sertifikat->file) }}" target="_blank" class="bg-gray-300 px-4 py-2 rounded">Lihat</a>
                    <a href="{{ asset('storage/' . $sertifikat->file) }}" download class="bg-blue-500 text-white px-4 py-2 rounded">Unduh</a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-sm text-gray-500 mb-6">Belum ada sertifikat bahasa.</p>
    @endforelse

    {{-- Skill --}}
    <h3 class="text-lg font-semibold mb-2">Sertifikat Skill</h3>
    @forelse ($sertifikatSkill as $sertifikat)
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col md:flex-row items-center mb-6">
            <div class="md:w-1/2 flex justify-center">
                <img src="{{ asset('storage/' . $sertifikat->file) }}" alt="Sertifikat" class="w-60 h-48 object-cover rounded-lg">
            </div>
            <div class="md:w-1/2 text-center md:text-left mt-4 md:mt-0">
                <h4 class="font-bold">{{ $sertifikat->judul }}</h4>
                <p class="my-2 text-sm">{{ $sertifikat->deskripsi }}</p>
                <div class="flex gap-2 justify-center md:justify-start mt-4">
                    <a href="{{ asset('storage/' . $sertifikat->file) }}" target="_blank" class="bg-gray-300 px-4 py-2 rounded">Lihat</a>
                    <a href="{{ asset('storage/' . $sertifikat->file) }}" download class="bg-blue-500 text-white px-4 py-2 rounded">Unduh</a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-sm text-gray-500 mb-6">Belum ada sertifikat skill.</p>
    @endforelse
</main>


@endsection
