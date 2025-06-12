@extends('admin.main.sidebar')

@section('content')
<main class="p-4 sm:p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Sertifikat Kelulusan</h2>
        <a href="{{ route('sertifikat.create') }}" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg">
            Buat Sertifikat
        </a>
    </div>

    {{-- Tabel Data Siswa dengan Sertifikat --}}
    <h3 class="text-lg font-semibold mb-3 mt-10">Daftar Siswa yang Memiliki Sertifikat</h3>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-sm table-auto">
            <thead class="bg-gray-100 text-left text-xs md:text-sm uppercase font-semibold text-gray-600">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Sertifikat Bahasa</th>
                    <th class="px-4 py-3">Sertifikat Skill</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usersWithCertificates as $index => $user)
                    @php
                        $bahasa = $user->sertifikat->firstWhere('tipe', 'bahasa');
                        $skill = $user->sertifikat->firstWhere('tipe', 'skill');
                    @endphp
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $user->nama_lengkap }}</td>
                        <td class="px-4 py-2">
                            @if($bahasa)
                                <a href="{{ asset('storage/' . $bahasa->file) }}" target="_blank" class="text-blue-600 underline">
                                    Lihat
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
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
