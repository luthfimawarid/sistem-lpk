@extends('admin.main.sidebar')

@section('content')

<div class="p-10 bg-blue-50">
    <div class="header flex justify-between items-center pb-6">
        <h1 class="md:text-xl font-semibold">Tambah Tugas/Kuis/Ujian Akhir</h1>
        <a href="/tugas-admin" class="bg-[#0A58CA] text-white py-2 px-4 rounded-lg">Kembali</a>
    </div>

    <main class="min-h-screen bg-gray-100">
        <form action="#" method="POST" class="bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" id="judul" name="judul" class="mt-1 p-2 w-full border rounded-md" placeholder="Masukkan judul tugas/kuis/ujian" required>
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 p-2 w-full border rounded-md" placeholder="Masukkan deskripsi" required></textarea>
            </div>
            <div class="mb-4">
                <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                <input type="date" id="deadline" name="deadline" class="mt-1 p-2 w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe</label>
                <select id="tipe" name="tipe" class="mt-1 p-2 w-full border rounded-md" onchange="toggleFileUpload()" required>
                    <option value="tugas">Tugas</option>
                    <option value="kuis">Kuis</option>
                    <option value="ujian_akhir">Ujian Akhir</option>
                </select>
            </div>

            <!-- Tugas: Upload File -->
            <div id="file-upload" class="mb-4 hidden">
                <label for="file" class="block text-sm font-medium text-gray-700">Unggah File Tugas</label>
                <input type="file" id="file" name="file" class="mt-1 p-2 w-full border rounded-md" accept="application/pdf, image/*">
            </div>

            <!-- Kuis dan Ujian Akhir: Pertanyaan -->
            <div id="soal" class="mb-4 hidden">
                <label for="soal" class="block text-sm font-medium text-gray-700">Soal</label>
                <textarea id="soal" name="soal" rows="4" class="mt-1 p-2 w-full border rounded-md" placeholder="Masukkan soal kuis/ujian" required></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </main>
</div>

<script>
    // Fungsi untuk menampilkan bagian yang sesuai berdasarkan tipe
    function toggleFileUpload() {
        const tipe = document.getElementById('tipe').value;
        const fileUpload = document.getElementById('file-upload');
        const soal = document.getElementById('soal');
        
        if (tipe === 'tugas') {
            fileUpload.classList.remove('hidden');
            soal.classList.add('hidden');
        } else {
            fileUpload.classList.add('hidden');
            soal.classList.remove('hidden');
        }
    }

    // Panggil toggleFileUpload saat halaman pertama kali dimuat
    window.onload = toggleFileUpload;
</script>

@endsection
