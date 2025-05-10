<!-- Halaman Tambah Sertifikat -->
@extends('admin.main.sidebar')

@section('content')
<div class="header flex justify-between items-center bg-white p-3">
    <h1 class="text-xl font-semibold my-2 mx-7">Tambah Sertifikat</h1>
</div>

<main class="p-6">
    <form action="{{ route('sertifikat.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="mb-4">
            <label for="user_id" class="block">Pilih Siswa</label>
            <select name="user_id" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Siswa --</option>
                @foreach ($siswa as $user)
                    <option value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="judul" class="block">Judul Sertifikat</label>
            <input type="text" name="judul" class="w-full border p-2 rounded" required>
        </div>
        
        <div class="mb-4">
            <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe</label>
            <select id="tipe" name="tipe" class="mt-1 p-2 w-full border rounded-md" onchange="toggleTipe()" required>
                <option value="bahasa">Bahasa</option>
                <option value="skill">Skill</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block">Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="w-full border p-2 rounded"></textarea>
        </div>

        <div class="mb-4">
            <label for="gambar" class="block">Unggah Gambar</label>
            <input type="file" name="gambar" class="w-full">
        </div>

        <div class="flex gap-3">
            <a href="{{ route('sertifikat.index') }}" class="bg-red-500 text-white px-4 py-2 rounded-lg">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan</button>
        </div>
    </form>

</main>
@endsection