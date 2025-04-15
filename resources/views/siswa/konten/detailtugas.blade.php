@extends('siswa.main.sidebar')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold">Detail Tugas</h1>
            <a href="/tugas" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
        </div>
        <p class="text-gray-600 mt-2">📘 Mata Pelajaran: <strong>Bahasa Jepang</strong></p>
        <p class="text-gray-600 mt-2">📝 Judul: <strong>Tugas 1 - Mengenal Hiragana</strong></p>
        <p class="text-gray-600 mt-2">📄 Deskripsi: <strong>Kerjakan latihan membaca dan menulis huruf Hiragana. Unggah jawaban dalam format PDF.</strong></p>
        <p class="text-gray-600 mt-2">⏳ Deadline: <strong class="text-red-500">10 Agustus 2024</strong></p>
        <p class="text-gray-600 mt-2">✅ Status: <strong class="text-green-500">Selesai</strong></p>

        <!-- Menampilkan File Tugas -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold">📂 File Tugas:</h2>
            <a href="#" class="text-[#0A58CA] hover:underline">
                📄 Download Tugas (tugas_1.pdf)
            </a>
        </div>

        <!-- Form Unggah Jawaban -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold">📤 Unggah Jawaban</h2>
            <input type="file" class="mt-2 p-2 w-full border rounded-lg">
            <button class="mt-4 bg-[#0A58CA] text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Kirim Jawaban
            </button>
        </div>

    </div>
</div>
@endsection
