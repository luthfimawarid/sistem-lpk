@extends('admin.main.sidebar')

@section('content')

<main class="p-6">
    <!-- Header -->
    <div class="flex flex-row justify-between items-center mb-6">
        <h2 id="ebook-count" class="md:text-lg font-semibold my-2 md:my-0 md:order-1">
            {{ ucfirst($tipe) }} ({{ $materi->count() }})
        </h2>
        <div class="flex space-x-2 md:order-2">
            <a href="{{ route('materi.create', ['tipe' => 'ebook']) }}" class="bg-[#0A58CA] text-white font-semibold px-4 py-2 flex items-center rounded-lg">
                Tambah {{ ucfirst($tipe) }}
                <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7 7V5"/>
                </svg>
            </a>
            <!-- <button class="bg-[#0A58CA] text-white font-semibold  md:text-lg px-4 py-2 flex items-center rounded-lg">
                Sort By
                <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8 10 4 4 4-4"/>
                </svg>
            </button> -->
        </div>
    </div>

    <div class="grid mt-5 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
        @foreach ($materi as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('/logo.png') }}" alt="Cover {{ $item->judul }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">{{ $item->judul }}</h3>
                    <p class="text-xs text-gray-600 mt-2">By {{ $item->author }}</p>

                    <audio controls class="w-full mt-4">
                        <source src="{{ asset('storage/materi/'.$item->file) }}" type="audio/mpeg">
                        Browser Anda tidak mendukung pemutar audio.
                    </audio>

                    <div class="mt-4 flex justify-between items-center">
                        <div class="flex space-x-2">
                            <a href="{{ route('materi.edit', $item->id) }}" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg">Edit</a>
                            <form action="{{ route('materi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah yakin ingin menghapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg">Hapus</button>
                            </form>
                        </div>
                        <p class="text-sm italic">{{ ucfirst($item->status) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</main>

@endsection
