@extends('siswa.main.sidebar')

@section('content')
<div class="p-4 md:p-6 bg-blue-50 min-h-screen">
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-4 md:p-6 gap-4">
            <h1 class="text-lg md:text-xl font-semibold">Detail Nilai: {{ ucfirst($tipe) }}</h1>
            <a href="{{ route('siswa.nilai') }}" class="bg-[#0A58CA] py-2 px-4 rounded text-white text-sm md:text-base">Kembali</a>
        </div>

        <!-- Tabel -->
        @if ($nilai->count())
            <div class="overflow-x-auto">
                <table class="w-full min-w-[500px] text-sm md:text-base">
                    <thead>
                        <tr class="bg-blue-100 text-left">
                            <th class="py-2 px-2 md:px-4">Judul</th>
                            <th class="py-2 px-2 md:px-4">Nilai</th>
                            <th class="py-2 px-2 md:px-4">Tanggal</th>
                            <th class="py-2 px-2 md:px-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nilai as $item)
                            <tr class="border-t">
                                <td class="py-2 px-2 md:px-4">{{ $item->judul }}</td>
                                <td class="py-2 px-2 md:px-4">{{ $item->nilai }}</td>
                                <td class="py-2 px-2 md:px-4">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                                <td class="py-2 px-2 md:px-4">
                                    <span class="text-{{ $item->nilai >= 75 ? 'green' : 'red' }}-600 font-medium">
                                        {{ $item->nilai >= 75 ? 'Baik' : 'Perlu Perbaikan' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600 px-4 pb-4">Belum ada nilai untuk tipe ini.</p>
        @endif
    </div>
</div>
@endsection
