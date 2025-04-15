@extends('admin.main.sidebar')

@section('content')
<div class="header flex items-center bg-white p-3">
    <!-- Tombol Back -->
    <a href="/chat-admin" class="flex items-center space-x-2 text-white bg-[#0A58CA] shadow-lg rounded-full p-2 mx-2 font-semibold">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>

    <h1 class="md:text-xl font-semibold my-2">{{ $kelas ?? 'Nama Kelas' }}</h1>
</div>

<main class="p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="chat-box h-[60vh] overflow-y-auto border rounded-lg p-4 mb-4">
            <!-- Contoh chat -->
            <div class="flex items-start space-x-3 mb-4">
                <img src="/logo.png" alt="" class="w-10 h-10 border rounded-full">
                <div>
                    <h4 class="font-semibold">Alamsyah</h4>
                    <p class="text-sm bg-gray-100 p-2 rounded-lg">Halo, ada tugas apa hari ini?</p>
                </div>
            </div>
            <div class="flex items-start space-x-3 justify-end mb-4">
                <div class="text-right">
                    <h4 class="font-semibold">Kamu</h4>
                    <p class="text-sm bg-[#0A58CA] text-white p-2 rounded-lg">Sepertinya ada tugas Matematika.</p>
                </div>
                <img src="/logo.png" alt="" class="w-10 h-10 border rounded-full">
            </div>
        </div>

        <!-- Input chat -->
        <form action="#" method="POST" class="flex items-center space-x-2">
            <input type="text" placeholder="Ketik pesan..." class="flex-1 p-2 border rounded-lg">
            <button type="submit" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg">Kirim</button>
        </form>
    </div>
</main>
@endsection
