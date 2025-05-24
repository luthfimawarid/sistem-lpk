@extends('admin.main.sidebar')

@section('content')
<div class="p-10 bg-blue-50 min-h-screen">
    <h1 class="text-2xl font-semibold mb-6">Edit Data Siswa: {{ $siswa->nama_lengkap }}</h1>

    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg">
        @csrf

        <div class="mb-4">
            <label for="nama_lengkap" class="block font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ $siswa->nama_lengkap }}" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ $siswa->email }}" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block font-medium mb-1">Password Baru (opsional)</label>
            <input type="password" name="password" id="password" class="w-full border rounded p-2" placeholder="Biarkan kosong jika tidak diganti">
        </div>

        <div class="mb-4">
            <label for="kelas" class="block font-medium mb-1">Kelas</label>
            <input type="text" name="kelas" id="kelas" value="{{ $siswa->kelas }}" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="foto" class="block font-medium mb-1">Ganti Foto (opsional)</label>
            <input type="file" name="foto" id="foto" class="w-full">
            @if($siswa->foto)
                <p class="mt-2 text-sm">Foto saat ini: <a href="{{ asset('storage/' . $siswa->foto) }}" target="_blank" class="text-blue-600 underline">Lihat</a></p>
            @endif
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
