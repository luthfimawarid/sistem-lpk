@extends('admin.main.sidebar')

@section('content')

<main class="p-6">
    <form class="bg-white p-6 rounded-lg shadow-md" action="{{ route('materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <h1 class="text-xl font-semibold mb-10">Edit Materi</h1>

        <!-- Judul -->
        <div class="my-6">
            <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
            <input type="text" id="judul" name="judul" value="{{ $materi->judul }}" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required>
        </div>

        <!-- Author -->
        <div class="my-6">
            <label for="author" class="block text-sm font-medium text-gray-700">Penulis / Author</label>
            <input type="text" id="author" name="author" value="{{ $materi->author }}" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required>
        </div>

        <!-- File Lama -->
        <div class="my-6">
            <label class="block text-sm font-medium text-gray-700">File Saat Ini</label>
            <p class="mt-1 text-sm">{{ $materi->file }}</p>
        </div>

        <!-- Upload File Baru -->
        <div class="my-6">
            <label for="file" class="block text-sm font-medium text-gray-700">Ganti File (Opsional)</label>
            <input type="file" id="file" name="file" accept=".pdf, audio/*, video/*" class="mt-1 block w-full">
        </div>

        <!-- Tipe -->
        <div class="my-6">
            <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe Materi</label>
            <select id="tipe" name="tipe" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required>
                <option value="ebook" {{ $materi->tipe == 'ebook' ? 'selected' : '' }}>E-Book</option>
                <option value="listening" {{ $materi->tipe == 'listening' ? 'selected' : '' }}>Listening</option>
                <option value="video" {{ $materi->tipe == 'video' ? 'selected' : '' }}>Video</option>
            </select>
        </div>

        <!-- Status -->
        <div class="my-6">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" name="status" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required>
                <option value="aktif" {{ $materi->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ $materi->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</a>
            <button type="submit" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg">Simpan Perubahan</button>
        </div>
    </form>
</main>

@endsection
