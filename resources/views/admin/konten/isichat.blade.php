@extends('admin.main.sidebar')

@section('content')
<div class="header flex flex-col border-t-2 bg-white p-3 space-y-1">
    <!-- Header Top -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
        <div class="flex items-center space-x-2">
            <a href="{{ route('chat.admin') }}" class="flex items-center space-x-2 text-white bg-[#0A58CA] shadow-lg rounded-full p-2 font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <h1 class="text-sm sm:text-base md:text-xl font-semibold">
                @if($room->type === 'group')
                    {{ $room->name ?? 'Grup' }}
                @else
                    {{ $otherUser->nama_lengkap ?? 'Private Chat' }}
                @endif
            </h1>
        </div>

        @if($room->type === 'group')
        <div class="flex flex-wrap gap-2 justify-start md:justify-end">
            <button onclick="document.getElementById('modal-edit-grup').classList.remove('hidden')"
                class="text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1.5 rounded-full text-sm">
                ✏️ Edit Grup
            </button>
            <button onclick="document.getElementById('modal-tambah-peserta').classList.remove('hidden')"
                class="text-white bg-[#0A58CA] hover:bg-blue-700 px-3 py-1.5 rounded-full text-sm">
                + Tambah
            </button>
        </div>
        @endif
    </div>

    <!-- Anggota grup -->
    @if($room->type === 'group')
        <div class="text-xs text-gray-500 ml-0 md:ml-14 flex flex-wrap gap-2 pt-2">
            @foreach($room->users as $user)
                <div class="flex items-center bg-gray-100 px-2 py-1 rounded-full space-x-1">
                    <span>{{ $user->nama_lengkap }}</span>
                    @if($user->id !== auth()->id())
                        <form action="{{ route('chat.admin.removeUser', [$room->id, $user->id]) }}" method="POST" onsubmit="return confirm('Keluarkan {{ $user->nama_lengkap }} dari grup?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 text-xs hover:underline">✖</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

<main class="p-4 md:p-6">
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
        <!-- Chat Box -->
        <div class="chat-box h-[60vh] md:h-[65vh] overflow-y-auto border rounded-lg p-4 mb-4 flex flex-col space-y-4">
            @if($room->messages->isEmpty())
                <p class="text-center text-gray-500 mt-10">Belum ada pesan</p>
            @else
                @foreach ($room->messages as $message)
                    @php
                        $isOwn = $message->user_id == auth()->id();
                        $fotoUser = $message->user->photo
                            ? asset('storage/' . $message->user->photo)
                            : asset('default-user.png');
                    @endphp

                    <div class="flex items-start space-x-3 {{ $isOwn ? 'justify-end' : '' }}">
                        @if(!$isOwn)
                            <a href="{{ route('chat.start', $message->user_id) }}">
                                <img src="{{ $fotoUser }}" alt="{{ $message->user->nama_lengkap }}" class="w-8 h-8 md:w-10 md:h-10 border rounded-full hover:opacity-80 transition object-cover">
                            </a>
                        @endif

                        <div class="{{ $isOwn ? 'text-right' : '' }} max-w-[80%]">
                            @if($room->type === 'group')
                                <h4 class="font-semibold text-xs md:text-sm">{{ $message->user->nama_lengkap }}</h4>
                            @endif
                            <p class="text-sm md:text-base {{ $isOwn ? 'bg-[#0A58CA] text-white' : 'bg-gray-100' }} p-2 rounded-lg inline-block break-words">
                                {{ $message->message }}
                            </p>
                        </div>

                        @if($isOwn)
                            <img src="{{ $fotoUser }}" alt="Saya" class="w-8 h-8 md:w-10 md:h-10 border rounded-full object-cover">
                        @endif
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Input Pesan -->
        <form action="{{ route('chat.admin.send', $room->id) }}" method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
            @csrf
            <input name="message" type="text" placeholder="Ketik pesan..." class="flex-1 p-2 border rounded-lg text-sm" autocomplete="off" required>
            <button type="submit" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg text-sm">Kirim</button>
        </form>
    </div>

    <!-- Modal Tambah Peserta -->
    <div id="modal-tambah-peserta" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
            <h2 class="text-xl font-semibold mb-4">Tambah Peserta ke Grup</h2>
            <form method="POST" action="{{ route('chat.admin.addUserToGroup', $room->id) }}">
                @csrf
                <div class="max-h-48 overflow-y-auto border rounded p-2 mb-4">
                    @foreach($allStudents as $siswa)
                        @if(!$room->users->contains($siswa->id))
                            <label class="block mb-1 text-sm">
                                <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}" class="mr-2">
                                {{ $siswa->nama_lengkap }} ({{ $siswa->kelas }})
                            </label>
                        @endif
                    @endforeach
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('modal-tambah-peserta').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-[#0A58CA] text-white rounded">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Grup -->
    <div id="modal-edit-grup" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
            <h2 class="text-xl font-semibold mb-4">Edit Grup</h2>
            <form method="POST" action="{{ route('chat.admin.updateGroup', $room->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Grup</label>
                    <input type="text" name="name" id="name" value="{{ $room->name }}" required class="mt-1 block w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label for="photo" class="block text-sm font-medium text-gray-700">Foto Grup (Opsional)</label>
                    <input type="file" name="photo" id="photo" accept="image/*" class="mt-1 block w-full border rounded px-2 py-1">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('modal-edit-grup').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
