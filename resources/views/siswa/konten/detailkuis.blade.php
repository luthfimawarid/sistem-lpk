@extends('siswa.main.sidebar')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold">Detail Kuis</h1>
            <a href="/tugas" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
        </div>        <p class="text-gray-600 mt-2">📘 Mata Pelajaran: <strong>Bahasa Jepang</strong></p>
        <p class="text-gray-600 mt-2"><strong>Pilih jawaban yang benar untuk setiap pertanyaan terkait huruf Hiragana.</strong></p>
        <p class="text-gray-600 mt-2">⏳ Deadline: <strong class="text-red-500">5 Agustus 2024</strong></p>
        <p class="text-gray-600 mt-2">🔴 Status: <strong class="text-red-500">Belum Dikerjakan</strong></p>

        <!-- Form Kuis (Hanya Frontend) -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-semibold">📝 Soal Kuis</h2>

            <!-- Soal 1 -->
            <div class="mt-4">
                <p class="font-medium">1. Apa bunyi dari huruf Hiragana ini? (あ)</p>
                <label class="block mt-2">
                    <input type="radio" name="soal_1" class="mr-2"> A
                </label>
                <label class="block">
                    <input type="radio" name="soal_1" class="mr-2"> I
                </label>
                <label class="block">
                    <input type="radio" name="soal_1" class="mr-2"> U
                </label>
            </div>

            <!-- Soal 2 -->
            <div class="mt-4">
                <p class="font-medium">2. Pilih huruf Hiragana yang sesuai dengan bunyi "ka"</p>
                <label class="block mt-2">
                    <input type="radio" name="soal_2" class="mr-2"> か
                </label>
                <label class="block">
                    <input type="radio" name="soal_2" class="mr-2"> き
                </label>
                <label class="block">
                    <input type="radio" name="soal_2" class="mr-2"> く
                </label>
            </div>

            <!-- Soal 3 -->
            <div class="mt-4">
                <p class="font-medium">3. Huruf "さ" dibaca sebagai?</p>
                <label class="block mt-2">
                    <input type="radio" name="soal_3" class="mr-2"> Sa
                </label>
                <label class="block">
                    <input type="radio" name="soal_3" class="mr-2"> Shi
                </label>
                <label class="block">
                    <input type="radio" name="soal_3" class="mr-2"> Su
                </label>
            </div>

            <!-- Tombol Kirim -->
            <button onclick="alert('Jawaban berhasil dikirim!')" 
                class="mt-6 bg-[#0A58CA] text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Kirim Jawaban
            </button>
        </div>
    </div>
</div>
@endsection
