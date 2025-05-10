@extends('admin.main.sidebar')

@section('content')

<main class="p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div class="flex space-x-2 md:order-2">
        <a href="{{ route('materi.create', ['tipe' => 'video']) }}" class="border-2 border-[#0A58CA] text-[#0A58CA] font-semibold text-xs md:text-lg px-4 py-2 flex items-center rounded-lg">
            Tambah {{ ucfirst($tipe) }}
                <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7 7V5"/>
                </svg>
            </a>
        </div>
    </div>

    <h2 class="md:text-lg font-semibold my-2 md:my-0 md:order-1">{{ ucfirst($tipe) }} ({{ $materi->count() }})</h2>

    <div class="grid mt-5 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
        @foreach ($materi as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <video controls class="w-full">
                    <source src="{{ asset('storage/materi/'.$item->file) }}" type="video/mp4">
                    Browser Anda tidak mendukung pemutar video.
                </video>

                <div class="p-4">
                    <h3 class="text-lg font-semibold">{{ $item->judul }}</h3>
                    <p class="text-xs text-gray-600 mt-2">By {{ $item->author }}</p>

                    <div class="mt-4 flex justify-between items-center">
                        <div class="flex space-x-2">
                            <a href="{{ route('materi.edit', $item->id) }}" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg text-xs">Edit</a>
                            <form action="{{ route('materi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah yakin ingin menghapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-xs">Hapus</button>
                            </form>
                        </div>
                        <p class="text-xs italic">{{ ucfirst($item->status) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</main>

@endsection
