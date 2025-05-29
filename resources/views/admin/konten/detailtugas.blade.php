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
                        <th class="border border-blue-100 px-4 py-2 text-left">File Jawaban</th>
                        <th class="border border-blue-100 px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengumpulan as $index => $item)
                    <tr>
                        <td class="border border-blue-100 px-4 py-2">{{ $index + 1 }}</td>
                        <td class="border border-blue-100 px-4 py-2">{{ $item->user->nama_lengkap ?? '-' }}</td>
                        <td class="border border-blue-100 px-4 py-2">{{ \Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F Y') }}</td>
                        <td class="border border-blue-100 px-4 py-2 capitalize">
                            @if ($item->nilai !== null)
                                <span class="text-green-600">Sudah Dikoreksi</span>
                            @else
                                <span class="text-red-500">Belum Dikoreksi</span>
                            @endif
                        </td>
                        <td class="border border-blue-100 px-4 py-2">
                            @if ($item->jawaban)
                                <a href="{{ asset('storage/jawaban_siswa/'.$item->jawaban) }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                            @else
                                <span class="text-gray-500 italic">Tidak ada file</span>
                            @endif
                        </td>
                        <td class="border border-blue-100 px-4 py-2 text-green-600">
                            <a href="/input-nilai/{{ $item->id }}" class="text-green-600 hover:underline">Beri Nilai</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Belum ada siswa yang mengumpulkan tugas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
