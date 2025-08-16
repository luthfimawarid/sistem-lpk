@extends('admin.main.sidebar')

@section('content')
<main class="p-6">
    <div class="flex flex-row justify-between items-center mb-6">
        <h2 id="ebook-count" class="md:text-lg font-semibold my-2 md:my-0 md:order-1">
            {{ ucfirst($tipe) }} ({{ $materi->count() }})
        </h2>
        <div class="flex space-x-2 md:order-2">
            <a href="{{ route('materi.create', ['tipe' => 'ebook']) }}" class="bg-[#0A58CA] text-white lg:text-md font-semibold px-4 py-2 flex items-center rounded-lg">
                Tambah {{ ucfirst($tipe) }}
                <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7 7V5"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Grid -->
    <div class="grid mt-5 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
        @foreach ($materi as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            {{-- Gambar placeholder --}}
            <img src="{{ asset('/logo.png') }}" alt="Cover {{ $item->judul }}" class="w-full h-48 object-cover">

            <div class="p-4">
                {{-- Judul dan penulis --}}
                <h3 class="text-lg font-semibold">{{ $item->judul }}</h3>
                <p class="text-gray-600 mt-2">By {{ $item->author }}</p>

                {{-- Aksi: Edit, Hapus, Lihat File --}}
                <div class="mt-4 flex justify-between items-center">
                    <div class="flex space-x-2 items-center">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('materi.edit', $item->id) }}" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg">Edit</a>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('materi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg">Hapus</button>
                        </form>

                        {{-- Tombol Lihat File (ikon mata) --}}
                        @if ($item->file)
                            <a href="{{ asset('storage/materi/' . $item->file) }}" target="_blank" class="text-[#0A58CA] hover:text-blue-600" title="Lihat File">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                    <p class="text-sm italic">{{ ucfirst($item->status) }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</main>
@endsection
