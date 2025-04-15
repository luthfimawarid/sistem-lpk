@extends('siswa.main.sidebar')

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
<main class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Listening (10)</h2>
        <button class="border-2 border-gray-400 font-semibold text-sm text-gray-400 px-4 flex items-center py-2 rounded-lg">
            Sort By
            <svg class="w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m8 10 4 4 4-4"/>
            </svg>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @for ($i = 1; $i <= 6; $i++)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="/logo.png" alt="Cover Listening" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold">Listening Exercise {{ $i }}</h3>
                <p class="text-sm text-gray-600 mt-2">By Author {{ $i }}</p>
                <audio controls class="w-full mt-4">
                    <source src="#" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </div>
        </div>
        @endfor
    </div>
</main>
@endsection
