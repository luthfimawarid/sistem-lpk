@extends('admin.main.sidebar')

@section('content')
<div class="p-10 bg-blue-50 min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold mb-4">Detail Siswa</h1>
            <a href="{{ route('admin.siswa.index') }}" class="bg-[#0A58CA] text-white px-4 py-2 rounded">Kembali</a>
        </div>
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

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-semibold mb-4">Upload Dokumen</h2>
        <form action="{{ route('admin.siswa.upload_dokumen', $siswa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block">Jenis Dokumen</label>
                <input type="text" name="jenis_dokumen" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block">File</label>
                <input type="file" name="file" class="w-full" required>
            </div>
            <button class="bg-blue-600 text-white px-6 py-2 rounded">Upload</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow">
        <h2 class="text-xl p-6 font-semibold">Dokumen Siswa</h2>
        <table class="w-full">
            <thead>
                <tr class="text-left bg-blue-50">
                    <th class="py-2 px-6">Jenis Dokumen</th>
                    <th class="py-2 px-6">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa->dokumen as $dokumen)
                    <tr>
                        <td class="py-2 px-6">{{ $dokumen->jenis_dokumen }}</td>
                        <td class="py-2 px-6">
                            <a href="{{ asset('storage/'.$dokumen->file) }}" target="_blank" class="text-blue-600">Lihat</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-4 text-red-500">Belum ada dokumen</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white mt-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold p-6">Sertifikat Siswa</h2>
        <table class="w-full">
            <thead>
                <tr class="text-left bg-blue-50">
                    <th class="py-2 px-6">Judul</th>
                    <th class="py-2 px-6">Tipe</th>
                    <th class="py-2 px-6">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa->sertifikat as $sertifikat)
                    <tr>
                        <td class="py-2 px-6">{{ $sertifikat->judul }}</td>
                        <td class="py-2 px-6 capitalize">{{ $sertifikat->tipe }}</td>
                        <td class="py-2 px-6">
                            @if($sertifikat->file)
                                <a href="{{ asset('storage/' . $sertifikat->file) }}" target="_blank" class="text-blue-600">Lihat</a>
                            @else
                                <span class="text-gray-500">Tidak ada file</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-red-500">Belum ada sertifikat</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
