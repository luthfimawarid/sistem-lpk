@extends('admin.main.sidebar')

@section('content')

<main class="p-6">
    <!-- ALERT NOTIF -->
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form class="bg-white p-6 rounded-lg shadow-md" action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <h1 class="text-xl font-semibold mb-10">Tambah Materi</h1>

        <div class="my-6">
            <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
            <input type="text" id="judul" name="judul" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required placeholder="Masukkan Judul" value="{{ old('judul') }}">
        </div>

        <div class="my-6">
            <label for="penulis" class="block text-sm font-medium text-gray-700">Penulis / Author</label>
            <input type="text" id="penulis" name="author" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required placeholder="Masukkan Nama Penulis" value="{{ old('author') }}">
        </div>

        @php
            $listBidang = [
                'Perawatan (Kaigo/Caregiver)',
                'Pembersihan Gedung',
                'Konstruksi',
                'Manufaktur Mesin Industri',
                'Elektronik dan Listrik',
                'Perhotelan',
                'Pertanian',
                'Perikanan',
                'Pengolahan Makanan dan Minuman',
                'Restoran/Cafe'
            ];
        @endphp

        <div class="my-6">
            <label for="bidang" class="block text-sm font-medium text-gray-700">Bidang</label>
            <select id="bidang" name="bidang" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required>
                <option value="" disabled {{ old('bidang') ? '' : 'selected' }}>-- Pilih Bidang --</option>
                @foreach($listBidang as $bidang)
                <option value="{{ $bidang }}" {{ old('bidang') == $bidang ? 'selected' : '' }}>{{ $bidang }}</option>
                @endforeach
            </select>
        </div>

        <div class="my-6">
            <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe Materi</label>
            <select id="tipe" name="tipe" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required>
                <option value="" disabled {{ old('tipe') ? '' : 'selected' }}>-- Pilih Tipe --</option>
                <option value="ebook" {{ old('tipe') == 'ebook' ? 'selected' : '' }}>Ebook</option>
                <option value="listening" {{ old('tipe') == 'listening' ? 'selected' : '' }}>Listening</option>
                <option value="video" {{ old('tipe') == 'video' ? 'selected' : '' }}>Video</option>
            </select>
        </div>

        <div class="my-6">
            <label for="file" class="block text-sm font-medium text-gray-700">File (PDF/MP3/MP4)</label>
            <input type="file" id="fileInput" name="file" class="mt-1 block w-full" required>
        </div>

        <div class="my-6">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" name="status" class="mt-1 block w-full border-b py-1 text-sm border-gray-400" required>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
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
                fileInput.accept = 'application/pdf';
            } else if (selectedTipe === 'listening') {
                fileInput.accept = 'audio/*';
            } else if (selectedTipe === 'video') {
                fileInput.accept = 'video/*';
            } else {
                fileInput.accept = '';
            }
        }

        updateFileAccept();
        tipeSelect.addEventListener('change', updateFileAccept);
    });
</script>

@endsection
