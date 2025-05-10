@extends('admin.main.sidebar')

@section('content')


<div class="p-10 bg-blue-50">
    <div class="header flex justify-between items-center mb-10">
        <h1 class="text-xl font-semibold">Edit Sertifikat</h1>
        <a href="/sertifikat-admin" class="bg-[#0A58CA] py-2 px-4 text-white rounded-lg">Kembali</a>
    </div>
    <main class="">
        <form action="{{ route('sertifikat.update', $sertifikat->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block">Judul</label>
                <input type="text" name="judul" value="{{ $sertifikat->judul }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block">Deskripsi</label>
                <textarea name="deskripsi" class="w-full border p-2 rounded">{{ $sertifikat->deskripsi }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block">Gambar Saat Ini</label>
                <img src="{{ asset('storage/sertifikat/' . $sertifikat->gambar) }}" class="w-40 mb-2">
                <input type="file" name="gambar" class="w-full">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </main>
</div>
@endsection