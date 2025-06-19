@extends('admin.main.sidebar')

@section('content')
<div class="p-4 md:p-10 bg-blue-50 min-h-screen space-y-6">
    <!-- Detail Siswa -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex flex-row justify-between items-center md:items-center space-y-0 md:space-y-0">
            <h1 class="text-xl md:text-2xl font-semibold">Detail Siswa</h1>
            <a href="{{ route('admin.siswa.index') }}" class="bg-[#0A58CA] text-white px-4 py-2 rounded text-sm">Kembali</a>
        </div>
        <div class="mt-4 space-y-2 text-sm md:text-base">
            <p><strong>Nama Lengkap:</strong> {{ $siswa->nama_lengkap }}</p>
            <p><strong>Email:</strong> {{ $siswa->email }}</p>
            <p><strong>Kelas:</strong> {{ $siswa->kelas }}</p>
            <p>
                <strong>Status:</strong>
                @if($statusLengkap)
                    <span class="text-green-600 font-semibold">Lengkap</span>
                @else
                    <span class="text-red-600 font-semibold">Belum Lengkap</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Upload Dokumen -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg md:text-xl font-semibold mb-4">Upload Dokumen</h2>
        <form action="{{ route('admin.siswa.upload_dokumen', $siswa->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium">Jenis Dokumen</label>
                <input type="text" name="jenis_dokumen" class="w-full border rounded p-2 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium">File</label>
                <input type="file" name="file" class="w-full text-sm" required>
            </div>
            <button class="bg-blue-600 text-white px-6 py-2 rounded text-sm">Upload</button>
        </form>
    </div>

    <!-- Dokumen Siswa -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <h2 class="text-lg md:text-xl font-semibold p-6">Dokumen Siswa</h2>
        <table class="min-w-full text-sm md:text-base">
            <thead>
                <tr class="bg-blue-50 text-left">
                    <th class="py-2 px-4">Jenis Dokumen</th>
                    <th class="py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa->dokumen as $dokumen)
                    <tr class="border-t">
                        <td class="py-2 px-4">{{ $dokumen->jenis_dokumen }}</td>
                        <td class="py-2 px-4 flex flex-wrap gap-2 items-center">
                            <a href="{{ asset('storage/'.$dokumen->file) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                            <form action="{{ route('admin.siswa.delete_dokumen', [$siswa->id, $dokumen->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center py-4 text-red-500">Belum ada dokumen</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Sertifikat Siswa -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <h2 class="text-lg md:text-xl font-semibold p-6">Sertifikat Siswa</h2>
        <table class="min-w-full text-sm md:text-base">
            <thead>
                <tr class="bg-blue-50 text-left">
                    <th class="py-2 px-4">Judul</th>
                    <th class="py-2 px-4">Tipe</th>
                    <th class="py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa->sertifikat as $sertifikat)
                    <tr class="border-t">
                        <td class="py-2 px-4">{{ $sertifikat->judul }}</td>
                        <td class="py-2 px-4 capitalize">{{ $sertifikat->tipe }}</td>
                        <td class="py-2 px-4">
                            @if($sertifikat->file)
                                <a href="{{ asset('storage/' . $sertifikat->file) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                            @else
                                <span class="text-gray-500">Tidak ada file</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-4 text-red-500">Belum ada sertifikat</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
