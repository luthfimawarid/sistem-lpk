@extends('admin.main.sidebar')

@section('content')
<!-- <div class="header flex justify-between items-center bg-white p-3">
    <div class="kiri">
        <h1 class="text-xl font-semibold my-2 mx-7">Welcome Back, Alamsyah!</h1>
    </div>
    <div class="kanan flex items-center me-5">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
        </svg>
        <svg class="w-10 h-8 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
        </svg>
    </div>
</div> -->

<div class="p-10 bg-blue-50">
    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="atas flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Input Nilai Siswa</h2>
            <a href="/tugas-admin" class="rounded text-white py-2 px-4 bg-[#0A58CA]">Kembali</a>
        </div>

        <form action="/simpan-nilai" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="nama" class="block font-medium text-gray-700">Nama Siswa</label>
                <input type="text" id="nama" name="nama" class="w-full p-2 border rounded-lg" placeholder="Masukkan nama siswa" required>
            </div>

            <div>
                <label for="nilai" class="block font-medium text-gray-700">Nilai</label>
                <input type="number" id="nilai" name="nilai" class="w-full p-2 border rounded-lg" min="0" max="100" placeholder="Masukkan nilai (0-100)" required>
            </div>

            <div>
                <label for="catatan" class="block font-medium text-gray-700">Catatan</label>
                <textarea id="catatan" name="catatan" rows="4" class="w-full p-2 border rounded-lg" placeholder="Tambahkan catatan (opsional)"></textarea>
            </div>

            <button type="submit" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg w-full">Simpan Nilai</button>
        </form>
    </div>
</div>
@endsection
