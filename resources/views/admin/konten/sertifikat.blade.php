@extends('admin.main.sidebar')

@section('content')
<main class="p-4 sm:p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Sertifikat Kelulusan</h2>
        <a href="{{ route('sertifikat.create') }}" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg">
            Buat Sertifikat
        </a>
    </div>

    {{-- Sertifikat Bahasa --}}
    <h3 class="text-lg font-semibold mb-2">Sertifikat Bahasa</h3>
    @forelse ($sertifikatBahasa as $item)
    <div class="bg-white rounded-lg shadow-md p-4 flex flex-col md:flex-row items-center mb-6">
        <div class="w-full md:w-1/2 flex justify-center">
            <img src="{{ asset('storage/' . $item->file) }}" alt="Sertifikat" class="w-60 h-48 object-cover rounded-lg">
        </div>
        <div class="w-full md:w-1/2 text-center md:text-left">
            <h4 class="text-lg font-bold">{{ $item->judul }}</h4>
            <p class="my-2 text-sm">{{ $item->deskripsi }}</p>
            <div class="flex gap-2 mt-4 justify-center md:justify-start">
                <a href="{{ route('sertifikat.edit', $item->id) }}" class="bg-gray-300 text-black px-4 py-2 rounded-lg">
                    Edit Sertifikat
                </a>
                <form action="{{ route('sertifikat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg">
                        Hapus Sertifikat
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
        <p class="text-sm text-gray-500">Belum ada sertifikat bahasa.</p>
    @endforelse

    {{-- Sertifikat Skill --}}
    <h3 class="text-lg font-semibold mb-2 mt-10">Sertifikat Skill</h3>
    @forelse ($sertifikatSkill as $item)
    <div class="bg-white rounded-lg shadow-md p-4 flex flex-col md:flex-row items-center mb-6">
        <div class="w-full md:w-1/2 flex justify-center">
            <img src="{{ asset('storage/' . $item->file) }}" alt="Sertifikat" class="w-60 h-48 object-cover rounded-lg">
        </div>
        <div class="w-full md:w-1/2 text-center md:text-left">
            <h4 class="text-lg font-bold">{{ $item->judul }}</h4>
            <p class="my-2 text-sm">{{ $item->deskripsi }}</p>
            <div class="flex gap-2 mt-4 justify-center md:justify-start">
                <a href="{{ route('sertifikat.edit', $item->id) }}" class="bg-gray-300 text-black px-4 py-2 rounded-lg">
                    Edit Sertifikat
                </a>
                <form action="{{ route('sertifikat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg">
                        Hapus Sertifikat
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
        <p class="text-sm text-gray-500">Belum ada sertifikat skill.</p>
    @endforelse
</main>

@endsection
