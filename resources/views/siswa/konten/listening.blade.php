@extends('siswa.main.sidebar')

@section('content')
<main class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 id="ebook-count" class="md:text-lg font-semibold my-2 md:my-0 md:order-1">
            {{ ucfirst($tipe) }} ({{ $materi->count() }})
        </h2>
        <!-- <button class="border-2 border-gray-400 font-semibold text-sm text-gray-400 px-4 flex items-center py-2 rounded-lg">
            Sort By
            <svg class="w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m8 10 4 4 4-4"/>
            </svg>
        </button> -->
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($materi as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('/logo.png') }}" alt="Cover Listening" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">{{ $item->judul }}</h3>
                    <p class="text-sm text-gray-600 mt-2">By {{ $item->author }}</p>
                    <audio controls class="w-full mt-4">
                        <source src="{{ asset('storage/materi/' . $item->file) }}" type="audio/mpeg">
                        Browser Anda tidak mendukung pemutar audio.
                    </audio>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center text-gray-500">
                Belum ada materi.
            </div>
        @endforelse
    </div>
</main>
@endsection
