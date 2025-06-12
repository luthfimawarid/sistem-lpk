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
        @foreach ($courses as $course)
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <img src="{{ asset('/logo.png') }}" alt="Course Image" class="rounded-lg mb-2 mx-auto max-w-[150px]">
                <p class="font-medium text-base">{{ $course->judul }}</p>
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
                            @foreach ($myCourses as $materi)
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
                            $roomName = $room->type === 'group' ? $room->name : ($otherUser->nama_lengkap ?? 'Private Chat');
                            $messageText = $lastMessage->message ?? 'Belum ada pesan';
                            $messageTime = optional($lastMessage?->created_at)->format('H:i');
                            $link = $room->type === 'group'
                                ? route('chat.admin.show', $room->id)
                                : route('chat.admin.start', ['userId' => $otherUser->id ?? 0]);
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
                    <td class="py-2 px-4 text-center flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>

@endsection
