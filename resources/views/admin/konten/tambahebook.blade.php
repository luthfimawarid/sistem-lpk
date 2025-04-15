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


<main class="p-6 my-4">
    <form class="bg-white p-6 rounded-lg shadow-md" action="#" method="POST" enctype="multipart/form-data">
        <h1 class="text-xl font-semibold mb-10">Tambah E-book</h1>
        <div class="my-6">
            <input type="text" id="judul" name="judul" class="mt-1 block w-full border-b py-1 text-sm border-gray-400 focus:ring-blue-500 focus:border-blue-500" required placeholder="masukan nama e-book">
        </div>

        <div class="my-6">
            <label for="cover" class="block text-sm font-medium text-gray-700">Cover E-book</label>
            <input type="file" id="cover" name="cover" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="my-6">
            <label for="file" class="block text-sm font-medium text-gray-700">File E-book (PDF)</label>
            <input type="file" id="file" name="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="ebook-admin" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan</button>
        </div>
    </form>
</main>
@endsection