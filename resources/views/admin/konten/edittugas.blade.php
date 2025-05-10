@extends('admin.main.sidebar')

@section('content')

<div class="p-6 bg-blue-50 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-semibold">Edit Tugas</h1>
        <a href="{{ route('tugas.index') }}" class="bg-[#0A58CA] text-white py-2 px-4 rounded-lg">Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('tugas.update', $tugas->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="judul" class="mt-1 p-2 w-full border rounded-md" value="{{ old('judul', $tugas->judul) }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="mt-1 p-2 w-full border rounded-md">{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Deadline</label>
                <input type="date" name="deadline" class="mt-1 p-2 w-full border rounded-md" value="{{ old('deadline', $tugas->deadline) }}">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tipe</label>
                <select name="tipe" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="tugas" {{ $tugas->tipe == 'tugas' ? 'selected' : '' }}>Tugas</option>
                    <option value="kuis" {{ $tugas->tipe == 'kuis' ? 'selected' : '' }}>Kuis</option>
                    <option value="ujian_akhir" {{ $tugas->tipe == 'ujian_akhir' ? 'selected' : '' }}>Ujian Akhir</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">File (opsional)</label>
                <input type="file" name="file" accept="image/png,image/jpeg" class="mt-1 p-2 w-full border rounded-md">
                @if($tugas->file)
                    <img src="{{ asset('storage/file_tugas/'.$tugas->file) }}" class="w-20 mt-2">
                @endif
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="belum_selesai" {{ $tugas->status == 'belum_selesai' ? 'selected' : '' }}>Belum Selesai</option>
                    <option value="selesai" {{ $tugas->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="mb-4" id="soal-group" style="display: none;">
                <label class="block text-sm font-medium text-gray-700">Soal</label>
                <textarea name="soal" rows="4" class="mt-1 p-2 w-full border rounded-md">{{ old('soal', $tugas->soal) }}</textarea>
            </div>


            <div class="flex justify-end">
                <button type="submit" class="bg-[#0A58CA] text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
<script>
    function toggleSoal() {
        const tipe = document.querySelector('select[name="tipe"]').value;
        const soalGroup = document.getElementById('soal-group');

        if (tipe === 'kuis' || tipe === 'ujian_akhir') {
            soalGroup.style.display = 'block';
        } else {
            soalGroup.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleSoal(); // run saat load awal
        document.querySelector('select[name="tipe"]').addEventListener('change', toggleSoal);
    });
</script>
