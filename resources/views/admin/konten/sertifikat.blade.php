@extends('admin.main.sidebar')

@section('content')
<main class="p-4 sm:p-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h2 class="text-xl sm:text-2xl font-semibold">Sertifikat Kelulusan</h2>
        <a href="{{ route('sertifikat.create') }}" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg text-sm sm:text-base">
            Buat Sertifikat
        </a>
    </div>

    <!-- Subjudul -->
    <h3 class="text-base sm:text-lg font-semibold mb-3 mt-6">Daftar Siswa yang Memiliki Sertifikat</h3>

    <!-- Tabel -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-sm sm:text-base table-auto">
            <thead class="bg-[#0A58CA] text-white">
                <tr class="text-left">
                    <th class="px-4 py-3 whitespace-nowrap">No</th>
                    <th class="px-4 py-3 whitespace-nowrap">Nama</th>
                    <th class="px-4 py-3 whitespace-nowrap">Sertifikat Bahasa</th>
                    <th class="px-4 py-3 whitespace-nowrap">Sertifikat Skill</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usersWithCertificates as $index => $user)
                    @php
                        $bahasa = $user->sertifikat->firstWhere('tipe', 'bahasa');
                        $skill = $user->sertifikat->firstWhere('tipe', 'skill');
                    @endphp
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 whitespace-nowrap">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $user->nama_lengkap }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            @if($bahasa)
                                <a href="{{ asset('storage/' . $bahasa->file) }}" target="_blank" class="text-blue-600 underline">
                                    Lihat
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            @if($skill)
                                <a href="{{ asset('storage/' . $skill->file) }}" target="_blank" class="text-blue-600 underline">
                                    Lihat
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">Belum ada siswa yang memiliki sertifikat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
