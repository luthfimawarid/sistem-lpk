@extends('admin.main.sidebar')

@section('content')

<main class="p-6">
    <form class="bg-white p-6 rounded-lg shadow-md" action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <h1 class="text-xl font-semibold mb-10">Tambah {{ ucfirst($tipe) }}</h1>

        <div class="my-6">
            <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
            <input type="text" id="judul" name="judul" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required placeholder="Masukkan Judul">
        </div>

        <div class="my-6">
            <label for="penulis" class="block text-sm font-medium text-gray-700">Penulis / Author</label>
            <input type="text" id="penulis" name="author" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required placeholder="Masukkan Nama Penulis">
        </div>

        <div class="my-6">
            <label for="cover" class="block text-sm font-medium text-gray-700">Cover</label>
            <input type="file" id="cover" name="cover" accept="image/png,image/jpeg,image/jpg" class="mt-1 block w-full" required>
        </div>

        <div class="my-6">
            <label for="file" class="block text-sm font-medium text-gray-700">File (PDF/MP3/MP4)</label>
            <input type="file" id="fileInput" name="file" class="mt-1 block w-full" required>
        </div>

        <div class="my-6">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" name="status" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required>
                <option value="aktif" selected>Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>

        <!-- Hidden Tipe -->
        <div class="my-6">
            <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe Materi</label>
            <select id="tipe" name="tipe" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required>
                <option value="" disabled selected>Pilih Tipe</option>
                <option value="ebook" {{ old('tipe', $tipe ?? '') == 'ebook' ? 'selected' : '' }}>Ebook</option>
                <option value="listening" {{ old('tipe', $tipe ?? '') == 'listening' ? 'selected' : '' }}>Listening</option>
                <option value="video" {{ old('tipe', $tipe ?? '') == 'video' ? 'selected' : '' }}>Video</option>
            </select>
        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</a>
            <button type="submit" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg">Simpan</button>
        </div>
    </form>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipeSelect = document.getElementById('tipe');
        const fileInput = document.getElementById('fileInput');

        function updateFileAccept() {
            const selectedTipe = tipeSelect.value;
            if (selectedTipe === 'ebook') {
                fileInput.accept = '.pdf';
                fileInput.placeholder = 'Unggah file PDF';
            } else if (selectedTipe === 'listening') {
                fileInput.accept = 'audio/*';
                fileInput.placeholder = 'Unggah file MP3';
            } else if (selectedTipe === 'video') {
                fileInput.accept = 'video/*';
                fileInput.placeholder = 'Unggah file MP4';
            }
        }

        // Set default jika ada value saat load
        updateFileAccept();

        // Update saat tipe dipilih ulang
        tipeSelect.addEventListener('change', updateFileAccept);
    });
</script>

@endsection
