@extends('siswa.main.sidebar')

@section('content')
<div class="p-6 md:p-10 bg-blue-50 min-h-screen">
    <div class="bg-white rounded-lg shadow">
        <div class="flex justify-between items-center p-6">
            <h1 class="text-xl font-semibold ">Detail Nilai: {{ ucfirst($tipe) }}</h1>
            <a href="{{ route('siswa.nilai') }}" class="bg-[#0A58CA] py-2 px-4 rounded text-white">Kembali</a>
        </div>

        @if ($nilai->count())
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-100 text-left">
                        <th class="py-2 px-4">Judul</th>
                        <th class="py-2 px-4">Nilai</th>
                        <th class="py-2 px-4">Tanggal</th>
                        <th class="py-2 px-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nilai as $item)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $item->judul }}</td>
                            <td class="py-2 px-4">{{ $item->nilai }}</td>
                            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                            <td class="py-2 px-4">
                                <span class="text-{{ $item->nilai >= 75 ? 'green' : 'red' }}-600 font-medium">
                                    {{ $item->nilai >= 75 ? 'Baik' : 'Perlu Perbaikan' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600">Belum ada nilai untuk tipe ini.</p>
        @endif
    </div>
</div>
@endsection
