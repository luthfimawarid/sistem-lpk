@extends('admin.main.sidebar')

@section('content')

<main class="p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Judul Chat -->
        <h2 class="text-lg md:text-2xl font-semibold mb-4">Chat</h2>

        <!-- Input Pencarian -->
        <div class="relative mb-4">
            <input type="text" placeholder="Cari chat" class="w-full p-2 pl-10 border rounded-lg text-gray-600"/>
            <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
            </svg>
        </div>

        <!-- List Chat -->
        <div class="border rounded-lg py-3">
            @foreach (['Kelas NIRUMA', 'Kelas INOVA', 'Kelas SUPREMA', 'Kelas VIRTUA'] as $index => $kelas)
            <a href="{{ route('kelas.admin.show', ['id' => $index + 1]) }}" class="block hover:bg-gray-100 transition duration-200">
                <div class="flex items-center justify-between px-3 h-12 my-3">
                    <div class="flex items-center">
                        <img src="/logo.png" alt="" class="w-10 h-10 md:w-12 md:h-12 border-2 rounded-full me-3 md:me-5 object-cover">
                        <div>
                            <h3 class="text-sm md:text-lg font-bold">{{ $kelas }}</h3>
                            <p class="text-xs md:text-sm text-gray-600">~ Alamsyah : Guys hari ini ada tugas apa?</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs md:text-sm text-gray-400">13.42</span>
                        <div class="bg-blue-500 text-white text-[10px] md:text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center ml-auto mt-2">4</div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</main>

@endsection
