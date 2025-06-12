@extends('siswa.main.sidebar')

@section('content')
<main class="p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg md:text-2xl font-semibold mb-4">Chat</h2>

        {{-- Input Pencarian --}}
        <div class="relative mb-4">
            <input type="text" placeholder="Cari chat" class="w-full p-2 pl-10 border rounded-lg text-gray-600" id="searchChat"/>
            <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
            </svg>
        </div>

        {{-- Daftar Chat --}}
        <div class="border rounded-lg py-3">
            @php
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
                    $roomName = $room->type == 'group'
                        ? $room->name
                        : ($room->users->where('id', '!=', auth()->id())->first()->nama_lengkap ?? 'Private Chat');
                    $messageText = $lastMessage->message ?? 'Belum ada pesan';
                    $messageTime = $lastMessage && $lastMessage->created_at ? $lastMessage->created_at->format('H:i') : '';
                @endphp
                <a href="{{ route('chat.show', $room->id) }}" class="chat-item block hover:bg-gray-100 transition duration-200">
                    <div class="flex items-center justify-between px-3 h-12 my-3">
                        <div class="flex items-center">
                            <img src="/logo.png" alt="Room" class="w-10 h-10 md:w-12 md:h-12 border-2 rounded-full me-3 md:me-5 object-cover">
                            <div>
                                <h3 class="room-name text-sm md:text-lg font-bold">{{ $roomName }}</h3>
                                <p class="message-preview text-xs md:text-sm text-gray-600">{{ $messageText }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs md:text-sm text-gray-400">{{ $messageTime }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            @endif
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.getElementById('searchChat').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const chats = document.querySelectorAll('.chat-item');

        chats.forEach(chat => {
            const roomName = chat.querySelector('.room-name').textContent.toLowerCase();
            const messagePreview = chat.querySelector('.message-preview').textContent.toLowerCase();

            if (roomName.includes(keyword) || messagePreview.includes(keyword)) {
                chat.style.display = 'block';
            } else {
                chat.style.display = 'none';
            }
        });
    });
</script>
@endsection
