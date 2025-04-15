@extends('admin.main.sidebar')

@section('content')

<div class="p-10 bg-blue-50">
    <div class="header flex justify-between items-center pb-6">
        <h1 class="text-xl font-semibold">Detail Kuis: Kuis Akhir</h1>
        <a href="/tugas-admin" class="bg-[#0A58CA] text-white py-2 px-4 rounded-lg">Kembali</a>
    </div>

    <main class="min-h-screen bg-gray-100">
        <!-- Detail Kuis -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-lg font-semibold">Deskripsi Kuis</h3>
            <p class="mt-2 text-gray-700">Kuis ini bertujuan untuk menguji pemahaman materi yang telah dipelajari. Kuis terdiri dari beberapa soal pilihan ganda.</p>
            <p class="mt-2 text-sm text-gray-500">Deadline: 10 Mei 2024</p>
        </div>

        <!-- Daftar Siswa yang Sudah Mengerjakan Kuis -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-lg font-semibold mb-4">Siswa yang Sudah Mengerjakan Kuis</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr>
                            <th class="py-2 text-left">Nama Siswa</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Nilai</th>
                            <th class="px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2">John Doe</td>
                            <td class="px-4 py-2 text-green-600">Selesai</td>
                            <td class="px-4 py-2">90</td>
                            <td class="px-4 py-2">
                                <a href="#" class="bg-yellow-500 text-white py-1 px-2 rounded-md">Edit Nilai</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2">Jane Smith</td>
                            <td class="px-4 py-2 text-red-600">Belum Selesai</td>
                            <td class="px-4 py-2">-</td>
                            <td class="px-4 py-2">
                                <a href="#" class="bg-yellow-500 text-white py-1 px-2 rounded-md">Edit Nilai</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2">Alice Johnson</td>
                            <td class="px-4 py-2 text-green-600">Selesai</td>
                            <td class="px-4 py-2">85</td>
                            <td class="px-4 py-2">
                                <a href="#" class="bg-yellow-500 text-white py-1 px-2 rounded-md">Edit Nilai</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

@endsection
