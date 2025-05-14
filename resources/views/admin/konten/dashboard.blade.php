@extends('admin.main.sidebar')

@section('content')

<div class="p-4 md:p-10 bg-blue-50">
<section class="mb-6">
    <div class="flex justify-between items-center">
        <p class="text-base md:text-lg font-semibold">Ongoing Courses (21)</p>
        <a href="/" class="px-3 py-1 text-sm md:text-base text-[#0A58CA] rounded-full font-semibold border border-[#0A58CA]">Lihat semua</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
        @foreach ($courses as $course)
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <img src="{{ asset('storage/materi/' . $course->cover) }}" alt="Course Image" class="rounded-lg mb-2 mx-auto max-w-[150px]">
                <p class="font-medium text-base">{{ $course->judul }}</p>
            </div>
        @endforeach
    </div>
</section>


    <div class="flex flex-col md:flex-row gap-4">
        <!-- Kursus Saya -->
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
                                <th class="py-2 px-4 text-center">Category</th>
                                <th class="py-2 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($myCourses as $materi)
                            <tr class="border-t">
                                <td class="py-2 px-4">{{ $materi->judul }}</td>
                                <td class="py-2 px-4 text-center">{{ ucfirst($materi->kategori) }}</td>
                                <td class="py-2 px-4 text-center">{{ ucfirst($materi->status) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Pesan -->
        <section class="w-full md:w-1/3 bg-white rounded-lg shadow p-4 h-full">
            <div class="flex justify-between items-center mb-2">
                <p class="text-base md:text-lg font-medium">Pesan</p>
                <a href="#" class="text-sm md:text-base text-blue-600 font-medium">Pergi ke pesan</a>
            </div>
            <p class="text-lg md:text-xl font-bold mb-4">Kelas NIRUMA</p>
            <div id="chat-box" class="h-40 md:h-60 overflow-y-auto space-y-3">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-gray-300 rounded-full flex items-center justify-center font-medium">A</div>
                    <div class="bg-gray-100 rounded-lg p-3 w-full">
                        <p class="text-sm md:text-base font-medium">~ Alamsyah</p>
                        <p class="text-sm md:text-base">Jangan lupa tugas hari ini guys!!</p>
                        <p class="text-xs text-right text-[#0A58CA] mt-1">18.42</p>
                    </div>
                </div>
            </div>
            <form id="chat-form" class="flex mt-4">
                <input type="text" id="chat-input" class="w-full bg-blue-50 rounded-l-full p-2 text-sm md:text-base" placeholder="Ketik pesan...">
                <button type="submit" class="bg-blue-600 text-white px-4 rounded-r-full flex items-center">➤</button>
            </form>
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
