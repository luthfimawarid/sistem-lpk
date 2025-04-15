@extends('admin.main.sidebar')

@section('content')

<main class="p-4 sm:p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 mx-4 sm:mx-6">
        <h2 class="text-xl sm:text-2xl font-semibold">Sertifikat Kelulusan</h2>
        <a href="/buat-sertifikat" class="bg-blue-500 text-white px-4 py-2 rounded-lg w-full md:w-auto text-center">
            Buat Sertifikat
        </a>
    </div>

    <!-- Sertifikat Bahasa -->
    <h3 class="text-lg sm:text-xl font-semibold mb-3 mx-4 sm:mx-6">Sertifikat Bahasa</h3>
    <div class="bg-white rounded-lg shadow-md p-4 flex flex-col md:flex-row items-center mb-6 mx-4 sm:mx-6">
        <!-- Gambar -->
        <div class="w-full md:w-1/2 flex justify-center items-center mb-4 md:mb-0">
            <img src="/logo.png" alt="Sertifikat" class="w-60 h-48 object-cover rounded-lg">
        </div>

        <!-- Deskripsi -->
        <div class="w-full md:w-1/2 text-center md:text-left">
            <h4 class="text-lg font-bold">Kerja keras Anda terbayar!</h4>
            <p class="my-2 text-sm sm:text-base">
                Selamat telah menyelesaikan <br><i class="font-semibold">Basic Japanese Language</i><br>
                Teruslah berlatih dan gunakan bahasa ini untuk meraih mimpi Anda!
            </p>
            <div class="flex flex-col md:flex-row mt-4 gap-2 md:gap-4">
                <a href="/edit-sertifikat" class="bg-gray-300 text-black px-4 py-2 rounded-lg w-full md:w-auto text-center">
                    Edit Sertifikat
                </a>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg w-full md:w-auto">
                    Hapus Sertifikat
                </button>
            </div>
        </div>
    </div>

    <!-- Sertifikat Skill -->
    <h3 class="text-lg sm:text-xl font-semibold mb-3 mx-4 sm:mx-6">Sertifikat Skill</h3>
    <div class="bg-white rounded-lg shadow-md p-4 flex flex-col md:flex-row items-center mb-6 mx-4 sm:mx-6">
        <!-- Gambar -->
        <div class="w-full md:w-1/2 flex justify-center items-center mb-4 md:mb-0">
            <img src="/logo.png" alt="Sertifikat" class="w-60 h-48 object-cover rounded-lg">
        </div>

        <!-- Deskripsi -->
        <div class="w-full md:w-1/2 text-center md:text-left">
            <h4 class="text-lg font-bold">Kerja keras Anda terbayar!</h4>
            <p class="my-2 text-sm sm:text-base">
                Selamat telah menyelesaikan <br><i class="font-semibold">Basic Japanese Language</i><br>
                Teruslah berlatih dan gunakan bahasa ini untuk meraih mimpi Anda!
            </p>
            <div class="flex flex-col md:flex-row mt-4 gap-2 md:gap-4">
                <a href="/edit-sertifikat" class="bg-gray-300 text-black px-4 py-2 rounded-lg w-full md:w-auto text-center">
                    Edit Sertifikat
                </a>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg w-full md:w-auto">
                    Hapus Sertifikat
                </button>
            </div>
        </div>
    </div>

</main>

@endsection
