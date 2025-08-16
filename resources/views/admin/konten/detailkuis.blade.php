@extends('admin.main.sidebar')

@section('content')

<div class="p-10 bg-blue-50">

    <main class="min-h-screen bg-gray-100">

        <!-- Info Detail Kuis -->
        <div class="p-6 bg-white rounded-lg shadow-md mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">{{ $tugas->judul }}</h2>
                <a href="/tugas-admin" class="rounded text-white py-2 px-4 bg-[#0A58CA]">Kembali</a>
            </div>

            <p class="mb-1"><strong>Deskripsi:</strong> {{ $tugas->deskripsi }}</p>
            <p class="mb-1"><strong>Tipe:</strong> {{ ucfirst(str_replace('_', ' ', $tugas->tipe)) }}</p>
            <p class="mb-1"><strong>Bidang:</strong> {{ $tugas->bidang }}</p>

            @if (!empty($tugas->jumlah_soal))
                <p class="mb-1"><strong>Jumlah Soal:</strong> {{ $tugas->jumlah_soal }}</p>
            @endif

            @if ($tugas->deadline)
                <p class="mb-1"><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d F Y') }}</p>
            @endif

            @if ($tugas->durasi)
                <p class="mb-1"><strong>Durasi Ujian:</strong> {{ $tugas->durasi }} menit</p>
            @endif

            @if ($tugas->cover)
                <p class="mb-1"><strong>File Soal:</strong>
                    <a href="{{ asset('storage/' . $tugas->cover) }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                </p>
            @endif
        </div>

        <!-- Daftar Siswa -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-lg font-semibold mb-4">Siswa yang Sudah Mengerjakan Kuis</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2">Nama Siswa</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tugas->tugasUser as $item)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $item->user->nama_lengkap ?? '-' }}</td>
                                <td class="px-4 py-2 {{ $item->status === 'selesai' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ ucfirst($item->status) }}
                                </td>
                                <td class="px-4 py-2">{{ $item->nilai ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center text-gray-500">Belum ada siswa yang mengerjakan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

@endsection
