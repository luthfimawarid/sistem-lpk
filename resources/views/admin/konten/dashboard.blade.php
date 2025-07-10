@extends('admin.main.sidebar')

@section('content')

<div class="p-4 md:p-10 bg-blue-50">
<section class="mb-6">
    <div class="flex justify-between items-center">
        <h2 id="ebook-count" class="md:text-lg font-semibold my-2 md:my-0 md:order-1">
            {{ ucfirst($tipe) }} ({{ $materi->count() }})
        </h2>
        <a href="/ebook-admin" class="px-3 py-1 text-sm md:text-base text-[#0A58CA] rounded-full font-semibold border border-[#0A58CA]">Lihat semua</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
        @foreach ($materi as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ asset('/logo.png') }}" alt="Cover {{ $item->judul }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold">{{ $item->judul }}</h3>
                <p class=" text-gray-600 mt-2">By {{ $item->author }}</p>
                <div class="mt-4 flex justify-between items-center">
                    <div class="flex space-x-2">
                        <a href="{{ route('materi.edit', $item->id) }}" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg ">Edit</a>
                        <form action="{{ route('materi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg ">Hapus</button>
                        </form>
                    </div>
                    <p class="text-sm italic">{{ ucfirst($item->status) }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>


    <div class="flex flex-col md:flex-row gap-4">
        <section class="w-full md:w-2/3">
            <div class="bg-white rounded-lg shadow overflow-hidden h-full">
                <div class="flex justify-between mx-4 my-5">
                    <p class="text-base md:text-lg font-semibold">Kursus Saya</p>
                    <a href="/ebook-admin" class="text-sm md:text-base text-blue-600">Lihat semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm md:text-base">
                        <thead>
                            <tr class="text-gray-600 bg-blue-50">
                                <th class="py-2 px-4">Courses Name</th>
                                <th class="py-2 px-4 text-center">Tipe</th>
                                <th class="py-2 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $materi)
                            <tr class="border-t">
                                <td class="py-2 px-4">{{ $materi->judul }}</td>
                                <td class="py-2 px-4 text-center">{{ ucfirst($materi->tipe) }}</td>
                                <td class="py-2 px-4 text-center">{{ ucfirst($materi->status) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Pesan -->
        <section class="w-full md:w-1/3 bg-white rounded-lg shadow p-4 h-full flex flex-col">
            <div class="flex justify-between items-center">
                <p class="text-base md:text-lg font-medium">Pesan</p>
                <a href="{{ route('chat.admin') }}" class="text-sm text-blue-600 font-medium">Lihat semua</a>
            </div>

            <div id="chat-list" class="mt-4 space-y-3 overflow-y-auto h-60">
                @if($rooms->isEmpty())
                    <p class="text-center text-gray-500 text-sm">Belum ada chat</p>
                @else
                    @foreach ($rooms as $room)
                        @php
                            $lastMessage = $room->messages->first();
                            $otherUser = $room->users->where('id', '!=', auth()->id())->first();

                            if (!$otherUser) continue; // SKIP jika user sudah dihapus

                            $roomName = $room->type === 'group' ? $room->name : $otherUser->nama_lengkap;
                            $messageText = $lastMessage->message ?? 'Belum ada pesan';
                            $messageTime = optional($lastMessage?->created_at)->format('H:i');
                            $link = $room->type === 'group'
                                ? route('chat.admin.show', $room->id)
                                : route('chat.admin.start', ['userId' => $otherUser->id]);
                        @endphp

                        <a href="{{ $link }}" class="flex items-center hover:bg-gray-100 transition p-2 rounded-lg">
                            <img src="/logo.png" class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover mr-3" alt="Avatar">
                            <div class="flex-1">
                                <p class="text-xs md:text-sm font-semibold truncate">{{ $roomName }}</p>
                                <p class="text-xs text-gray-600 truncate">{{ $messageText }}</p>
                            </div>
                            <span class="text-xs text-gray-400 ml-2">{{ $messageTime }}</span>
                        </a>
                    @endforeach
                @endif
            </div>
        </section>
    </div>

    <!-- Data Siswa -->
    <section class="mt-6 bg-white rounded-lg shadow">
        <div class="flex justify-between items-center px-4 py-4">
            <p class="text-base md:text-lg font-semibold">Data Siswa</p>
            <a href="/siswa" class="text-sm md:text-base text-blue-600 font-medium">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm md:text-base">
                <thead>
                    <tr class="text-gray-600 bg-blue-50">
                        <th class="py-2 px-4">Nama</th>
                        <th class="py-2 px-4 text-center">Kelas</th>
                        <th class="py-2 px-4 text-center">Status</th>
                        <th class="py-2 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($siswa as $user)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ $user->nama_lengkap }}</td>
                    <td class="py-2 px-4 text-center">{{ $user->kelas ?? '-' }}</td>
                    <td class="py-2 px-4 text-center">Aktif</td>
                    <td class="py-2 px-4 text-center relative">
                        <div class="relative inline-block">
                            <!-- Icon Aksi -->
                            <svg onclick="toggleDropdown(this)" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>

                            <!-- Dropdown Menu -->
                            <div class="dropdown hidden absolute right-0 mt-2 w-40 bg-white border rounded-md shadow-lg z-50">
                                <ul class="py-1 text-gray-700">
                                    <li>
                                        <a href="{{ route('admin.siswa.edit', $user->id) }}" class="block text-left px-4 py-2 hover:bg-gray-100">Edit</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.siswa.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-100">Hapus</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>

<script>
    function toggleDropdown(element) {
        // Tutup semua dropdown lainnya
        document.querySelectorAll('.dropdown').forEach(drop => {
            if (drop !== element.nextElementSibling) {
                drop.classList.add('hidden');
            }
        });

        // Toggle dropdown saat ini
        const dropdown = element.nextElementSibling;
        dropdown.classList.toggle('hidden');
    }

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function (e) {
        const isDropdownButton = e.target.closest('svg');
        if (!isDropdownButton) {
            document.querySelectorAll('.dropdown').forEach(drop => drop.classList.add('hidden'));
        }
    });
</script>

@endsection