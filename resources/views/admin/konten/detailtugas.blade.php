@extends('admin.main.sidebar')

@section('content')

<div class="p-6 bg-blue-50">
    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <p class="text-lg font-semibold">Daftar Siswa yang Mengumpulkan Tugas</p>
            <a href="/tugas-admin" class="rounded text-white py-2 px-4 bg-[#0A58CA]">Kembali</a>
        </div>
        
        <!-- Tabel Daftar Siswa -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-blue-100">
                <thead class="bg-[#0A58CA] text-white">
                    <tr>
                        <th class="border border-blue-100 px-4 py-2 text-left">No</th>
                        <th class="border border-blue-100 px-4 py-2 text-left">Nama Siswa</th>
                        <th class="border border-blue-100 px-4 py-2 text-left">Tanggal Pengumpulan</th>
                        <th class="border border-blue-100 px-4 py-2 text-left">Status</th>
                        <th class="border border-blue-100 px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 10; $i++)
                    <tr>
                        <td class="border border-blue-100 px-4 py-2">{{ $i }}</td>
                        <td class="border border-blue-100 px-4 py-2">Siswa {{ $i }}</td>
                        <td class="border border-blue-100 px-4 py-2">10 Agustus 2024</td>
                        <td class="border border-blue-100 px-4 py-2">Belum Dinilai</td>
                        <td class="border border-blue-100 px-4 py-2 text-green-600">
                            <a href="/input-nilai/{{ $i }}" class="text-green-600 hover:underline">Beri Nilai</a>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
