@extends('admin.main.sidebar')

@section('content')
<main class="px-4 py-6 md:px-6 lg:px-12">
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
        {{-- Header dan Tombol Grup --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <h2 class="text-lg sm:text-xl md:text-2xl font-semibold">Chat</h2>
            <button onclick="document.getElementById('modal-grup').classList.remove('hidden')"
                class="w-full sm:w-auto bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm md:text-base">
                + Buat Grup
            </button>
        </div>

        {{-- Modal Buat Grup --}}
        <div id="modal-grup" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center px-4">
            <div class="bg-white rounded-lg w-full max-w-xl p-6 relative max-h-[90vh] overflow-y-auto">
                <h2 class="text-xl font-semibold mb-4">Buat Grup / Kelas</h2>
                <form action="{{ route('chat.admin.createGroup') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Nama Grup (Kelas)</label>
                        <input type="text" name="kelas" class="w-full border p-2 rounded text-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Pilih Siswa</label>
                        <div class="max-h-48 overflow-y-auto border rounded p-2 space-y-1 text-sm">
                            @foreach($allStudents as $siswa)
                                <label class="block">
                                    <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}" class="mr-2">
                                    {{ $siswa->nama_lengkap }} ({{ $siswa->kelas }})
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="document.getElementById('modal-grup').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded text-sm">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm">Buat</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Input Pencarian --}}
        <div class="relative mb-4">
            <input type="text" placeholder="Cari chat" id="searchChat"
                   class="w-full p-2 pl-10 border rounded-lg text-sm md:text-base text-gray-600" />
            <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
            </svg>
        </div>

        {{-- Tabs dengan animasi underline --}}
        <div class="relative mb-4">
            <div class="flex space-x-6 text-sm md:text-base border-b border-gray-300" id="tabs">
                <button onclick="switchTab('semua')" class="tab-button relative text-blue-600 font-semibold pb-3 transition-all" id="tab-semua">Semua</button>
                <button onclick="switchTab('grup')" class="tab-button relative text-gray-600 pb-3 transition-all" id="tab-grup">Grup/Kelas</button>
                <button onclick="switchTab('siswa')" class="tab-button relative text-gray-600 pb-3 transition-all" id="tab-siswa">Siswa</button>
            </div>
            <div id="tab-underline" class="tab-underline absolute bottom-0 left-0 h-0.5 bg-blue-600 w-16 rounded transition-all duration-300"></div>
        </div>

        {{-- Daftar Chat --}}
        <div class="border rounded-lg py-3">
            @if($rooms->isEmpty())
                <p class="text-center text-gray-500 py-6">Belum ada chat</p>
            @else
                @foreach ($rooms as $room)
                    @php
                        $isGroup = $room->type === 'group';
                        $otherUser = $room->users->where('id', '!=', auth()->id())->first();
                        $roomName = $isGroup 
                            ? $room->name 
                            : ($otherUser ? $otherUser->nama_lengkap : 'User tidak tersedia');

                        $lastMessage = $room->messages->first();
                        $messageText = $lastMessage->message ?? 'Belum ada pesan';
                        $messageTime = optional($lastMessage?->created_at)->format('H:i');

                        $routeName = $isGroup
                            ? route('chat.admin.show', $room->id)
                            : ($otherUser 
                                ? route('chat.admin.start', ['userId' => $otherUser->id])
                                : '#');

                        $dataType = $isGroup ? 'grup' : 'siswa';
                    @endphp

                    <a href="{{ $routeName }}"
                       class="chat-item block hover:bg-gray-100 transition duration-200"
                       data-type="{{ $dataType }}">
                        <div class="flex items-center justify-between px-3 py-3 md:py-4">
                            <div class="flex items-center gap-3 md:gap-5">
                                <img src="/logo.png" alt="Room"
                                    class="w-10 h-10 md:w-12 md:h-12 border-2 rounded-full object-cover" />
                                <div>
                                    <h3 class="room-name text-sm md:text-lg font-bold truncate w-[160px] md:w-[240px]">
                                        {{ $roomName }}
                                    </h3>
                                    <p class="message-preview text-xs md:text-sm text-gray-600 truncate w-[160px] md:w-[240px]">
                                        {{ $messageText }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs md:text-sm text-gray-400">{{ $messageTime }}</span>
                                @if($isGroup)
                                    <form action="{{ route('chat.admin.deleteGroup', $room->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus grup ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs md:text-sm ml-3">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
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
<style>
    .tab-underline {
        transition: all 0.3s ease-in-out;
    }
</style>

<script>
    function switchTab(type) {
        const allChats = document.querySelectorAll('.chat-item');
        const tabButtons = document.querySelectorAll('.tab-button');
        const underline = document.getElementById('tab-underline');

        // Reset all tabs
        tabButtons.forEach(btn => {
            btn.classList.remove('text-blue-600', 'font-semibold');
            btn.classList.add('text-gray-600');
        });

        // Set active tab
        const activeTab = document.getElementById(`tab-${type}`);
        activeTab.classList.add('text-blue-600', 'font-semibold');
        activeTab.classList.remove('text-gray-600');

        // Animate underline
        const tabContainer = document.getElementById('tabs');
        const containerLeft = tabContainer.getBoundingClientRect().left;
        const activeRect = activeTab.getBoundingClientRect();
        const offsetLeft = activeRect.left - containerLeft;

        underline.style.width = `${activeRect.width}px`;
        underline.style.left = `${offsetLeft}px`;

        // Filter chat list
        allChats.forEach(chat => {
            const chatType = chat.getAttribute('data-type');
            chat.style.display = (type === 'semua' || type === chatType) ? 'block' : 'none';
        });
    }

    // Pencarian
    document.getElementById('searchChat').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const chats = document.querySelectorAll('.chat-item');

        chats.forEach(chat => {
            const roomName = chat.querySelector('.room-name').textContent.toLowerCase();
            const messagePreview = chat.querySelector('.message-preview').textContent.toLowerCase();
            chat.style.display = (roomName.includes(keyword) || messagePreview.includes(keyword)) ? 'block' : 'none';
        });
    });

    // Inisialisasi default
    document.addEventListener('DOMContentLoaded', function () {
        switchTab('semua');
    });
</script>
@endsection
