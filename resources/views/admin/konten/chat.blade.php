@extends('admin.main.sidebar')

@section('content')
<main class="p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg md:text-2xl font-semibold">Chat</h2>
            <button onclick="document.getElementById('modal-grup').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">+ Buat Grup</button>
        </div>

        {{-- Modal Buat Grup --}}
        <div id="modal-grup" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
            <div class="bg-white rounded-lg w-full max-w-xl p-6 relative">
                <h2 class="text-xl font-semibold mb-4">Buat Grup / Kelas</h2>
                <form action="{{ route('chat.admin.createGroup') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Nama Grup (Kelas)</label>
                        <input type="text" name="kelas" class="w-full border p-2 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Pilih Siswa</label>
                        <div class="max-h-48 overflow-y-auto border rounded p-2">
                            @foreach($allStudents as $siswa)
                                <label class="block mb-1">
                                    <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}" class="mr-2">
                                    {{ $siswa->nama_lengkap }} ({{ $siswa->kelas }})
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="document.getElementById('modal-grup').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Buat</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Input Pencarian --}}
        <div class="relative mb-4">
            <input type="text" placeholder="Cari chat" class="w-full p-2 pl-10 border rounded-lg text-gray-600" id="searchChat"/>
            <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
            </svg>
        </div>

        {{-- Daftar Chat --}}
        <div class="border rounded-lg py-3">
            @if($rooms->isEmpty())
                <p class="text-center text-gray-500 py-6">Belum ada chat</p>
            @else
                @foreach ($rooms as $room)
                    @php
                        $lastMessage = $room->messages->first();
                        $isGroup = $room->type === 'group';
                        $roomName = $isGroup ? $room->name : ($room->users->where('id', '!=', auth()->id())->first()->nama_lengkap ?? 'Private Chat');
                        $messageText = $lastMessage->message ?? 'Belum ada pesan';
                        $messageTime = optional($lastMessage?->created_at)->format('H:i');
                        $routeName = $isGroup ? route('chat.admin.show', $room->id) : route('chat.admin.start', ['userId' => $room->users->where('id', '!=', auth()->id())->first()->id ?? 0]);
                    @endphp
                    <a href="{{ $routeName }}" class="block hover:bg-gray-100 transition duration-200">
                        <div class="flex items-center justify-between px-3 h-12 my-3">
                            <div class="flex items-center">
                                <img src="/logo.png" alt="Room" class="w-10 h-10 md:w-12 md:h-12 border-2 rounded-full me-3 md:me-5 object-cover">
                                <div>
                                    <h3 class="text-sm md:text-lg font-bold">{{ $roomName }}</h3>
                                    <p class="text-xs md:text-sm text-gray-600 truncate">{{ $messageText }}</p>
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
    document.querySelectorAll('a[href^="#tab"]').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();

            // Hide all tab contents
            document.querySelectorAll('[id^="tab-"]').forEach(t => t.classList.add('hidden'));
            // Remove active state
            document.querySelectorAll('a[href^="#tab"]').forEach(t => t.classList.remove('active-tab'));
            // Show selected tab
            document.querySelector(this.getAttribute('href')).classList.remove('hidden');
            this.classList.add('active-tab');
        });
    });
</script>
@endsection