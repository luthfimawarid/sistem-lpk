@extends('siswa.main.sidebar')

@section('content')
<div class="header flex flex-col bg-white p-3 space-y-1">
    <!-- Tombol Back dan Header -->
    <div class="flex items-center">
        <a href="{{ route('chat.index') }}" class="flex items-center space-x-2 text-white bg-[#0A58CA] shadow-lg rounded-full p-2 mx-2 font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        @php
            $adminId = auth()->id();
            $otherUser = $room->users->firstWhere('id', '!=', $adminId);
        @endphp

        <h1 class="text-sm md:text-xl font-semibold my-2">
            @if($room->type === 'group')
                {{ $room->name ?? 'Grup' }}
            @else
                {{ $otherUser->nama_lengkap ?? 'Private Chat' }}
            @endif
        </h1>
    </div>

    <!-- 👇 Tambahkan Ini Jika Grup -->
    @if($room->type === 'group')
        <div class="text-xs text-gray-500 ml-14 flex flex-wrap gap-x-2 gap-y-1">
            @foreach($room->users as $user)
                <span class="bg-gray-100 px-2 py-1 rounded-full">{{ $user->nama_lengkap }}</span>
            @endforeach
        </div>
    @endif
</div>

<main class="p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="chat-box h-[60vh] overflow-y-auto border rounded-lg p-4 mb-4 flex flex-col space-y-4">
            @if($room->messages->isEmpty())
                <p class="text-center text-gray-500 mt-10">Belum ada pesan</p>
            @else
                @foreach ($room->messages as $message)
                    <div class="flex items-start space-x-3 {{ $message->user_id == auth()->id() ? 'justify-end' : '' }}">
                        @if($message->user_id != auth()->id())
                            <img src="/logo.png" alt="" class="w-10 h-10 border rounded-full">
                        @endif
                        <div class="{{ $message->user_id == auth()->id() ? 'text-right' : '' }}">
                            @if($room->type === 'group')
                                <h4 class="font-semibold">{{ $message->user->nama_lengkap }}</h4>
                            @endif
                            <p class="text-sm {{ $message->user_id == auth()->id() ? 'bg-[#0A58CA] text-white' : 'bg-gray-100' }} p-2 rounded-lg">
                                {{ $message->message }}
                            </p>
                        </div>
                        @if($message->user_id == auth()->id())
                            <img src="/logo.png" alt="" class="w-10 h-10 border rounded-full">
                        @endif
                    </div>
                @endforeach
            @endif
        </div>

        <form action="{{ route('chat.send', $room->id) }}" method="POST" class="flex items-center space-x-2 mt-4">
            @csrf
            <input name="message" type="text" placeholder="Ketik pesan..." class="flex-1 p-2 border rounded-lg" autocomplete="off" required>
            <button type="submit" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg">Kirim</button>
        </form>
    </div>
</main>
@endsection
