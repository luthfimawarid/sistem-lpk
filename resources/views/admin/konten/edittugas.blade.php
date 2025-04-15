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
    <div class="header flex justify-between items-center pb-6">
        <h1 class="text-xl font-semibold">Edit Tugas</h1>
        <a href="/tugas-admin" class="bg-[#0A58CA] text-white py-2 px-4 rounded-lg">Kembali</a>
    </div>

    <main class="min-h-screen bg-gray-100">
        <form action="#" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Tugas</label>
                <input type="text" id="judul" name="judul" class="mt-1 p-2 w-full border rounded-md" placeholder="Masukkan judul tugas">
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 p-2 w-full border rounded-md" placeholder="Masukkan deskripsi tugas"></textarea>
            </div>
            <div class="mb-4">
                <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                <input type="date" id="deadline" name="deadline" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mb-4">
                <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe</label>
                <select id="tipe" name="tipe" class="mt-1 p-2 w-full border rounded-md">
                    <option value="tugas">Tugas</option>
                    <option value="kuis">Kuis</option>
                    <option value="ujian_akhir">Ujian Akhir</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </main>
</div>
@endsection