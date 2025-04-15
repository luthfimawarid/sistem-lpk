<!-- Halaman Tambah Sertifikat -->
@extends('admin.main.sidebar')

@section('content')
<div class="header flex justify-between items-center bg-white p-3">
    <h1 class="text-xl font-semibold my-2 mx-7">Tambah Sertifikat</h1>
</div>

<main class="p-6">
    <form action="#" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Sertifikat</label>
            <input type="text" id="judul" name="judul" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>

        <div class="mb-4">
            <label for="gambar" class="block text-sm font-medium text-gray-700">Unggah Gambar</label>
            <input type="file" id="gambar" name="gambar" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border file:border-gray-300 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        <div class="flex">
            <a href="/sertifikat-admin" class="bg-red-500 text-white px-4 py-2 rounded-lg">Batal</a>
            <button type="submit" class="bg-[#0A58CA] text-white px-4 py-2 mx-3 rounded-lg">Simpan</button>
        </div>
    </form>
</main>
@endsection