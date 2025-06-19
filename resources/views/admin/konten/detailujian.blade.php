@extends('admin.main.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="header flex justify-between items-center pb-6">
        <h1 class="text-xl font-semibold">Detail Ujian: Ujian Akhir</h1>
        <a href="/tugas-admin" class="bg-[#0A58CA] text-white py-2 px-4 rounded-lg">Kembali</a>
    </div>

    <main class="min-h-screen bg-gray-100">
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-lg font-semibold">Deskripsi Ujian</h3>
            <p class="mt-2 text-gray-700">{{ $tugas->deskripsi }}</p>
            <p class="mt-2 text-sm text-gray-500">Deadline: 
                {{ $tugas->deadline ? \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d F Y') : '-' }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-lg font-semibold mb-4">Siswa yang Sudah Mengerjakan Kuis</h3>
            <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Nama Siswa</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tugas->tugasUser as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->user->nama_lengkap ?? '-' }}</td>
                        <td class="px-4 py-2 {{ $item->status === 'selesai' ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst($item->status) }}
                        </td>
                        <td class="px-4 py-2">
                            @if($item->status === 'selesai')
                                {{ $item->nilai ?? '0' }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

    </main>
</div>
@endsection