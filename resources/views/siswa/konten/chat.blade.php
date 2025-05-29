@extends('siswa.main.sidebar')

@section('content')
<main class="p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg md:text-2xl font-semibold mb-4">Chat</h2>

        <div class="relative mb-4">
            <input type="text" placeholder="Cari chat" class="w-full p-2 pl-10 border rounded-lg text-gray-600" id="searchChat"/>
            <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
            </svg>
        </div>

        <div class="border rounded-lg py-3">
            @php
                // Urutkan rooms berdasarkan waktu pesan terakhir (descending)
                $sortedRooms = $rooms->sortByDesc(function($room) {
                    return optional($room->messages->first())->created_at;
                });
            @endphp

            @if($sortedRooms->isEmpty())
                <p class="text-center text-gray-500 py-6">Belum ada chat</p>
            @else
                @foreach ($sortedRooms as $room)
                @php
                    $lastMessage = $room->messages->first();
                @endphp
                <a href="{{ route('chat.show', $room->id) }}" class="block hover:bg-gray-100 transition duration-200">
                    <div class="flex items-center justify-between px-3 h-12 my-3">
                        <div class="flex items-center">
                            <img src="/logo.png" alt="Room" class="w-10 h-10 md:w-12 md:h-12 border-2 rounded-full me-3 md:me-5 object-cover">
                            <div>
                                <h3 class="text-sm md:text-lg font-bold">
                                    @if($room->type == 'group')
                                        {{ $room->name }}
                                    @else
                                        {{-- Private chat: tampilkan nama user lawan chat --}}
                                        {{ $room->users->where('id', '!=', auth()->id())->first()->nama_lengkap ?? 'Private Chat' }}
                                    @endif
                                </h3>
                                <p class="text-xs md:text-sm text-gray-600">
                                    {{ $lastMessage->message ?? 'Belum ada pesan' }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs md:text-sm text-gray-400">
                                {{ $lastMessage && $lastMessage->created_at ? $lastMessage->created_at->format('H:i') : '' }}
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            @endif
        </div>
    </div>
</main>
@endsection
