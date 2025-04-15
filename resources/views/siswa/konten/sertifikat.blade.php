@extends('siswa.main.sidebar')

@section('content')

<main class="p-6">
    <div class="flex justify-between items-center mb-4 mx-4 md:mx-6">
        <h2 class="text-xl md:text-2xl font-semibold">Sertifikat Kelulusan</h2>
        <button class="bg-blue-500 text-white px-3 md:px-4 py-1 md:py-2 rounded-lg text-sm md:text-base">
            Unduh Semua
        </button>
    </div>

    <!-- Sertifikat Bahasa -->
    <h3 class="text-lg md:text-xl font-semibold mb-3 mx-4 md:mx-6">Sertifikat Bahasa</h3>
    <div class="bg-white rounded-lg shadow-md p-3 md:p-4 flex flex-col md:flex-row items-center mb-6 mx-4 md:mx-6">
        <div class="w-full md:w-1/2 flex justify-center items-center">
            <img src="/logo.png" alt="Sertifikat" class="w-48 md:w-60 h-36 md:h-48 object-cover rounded-lg">
        </div>

        <div class="w-full md:w-1/2 text-center md:text-left mt-4 md:mt-0">
            <h4 class="text-base md:text-lg font-bold">Kerja keras Anda terbayar!</h4>
            <p class="my-2 text-sm md:text-base">
                Selamat telah menyelesaikan <br>
                <i class="font-semibold">Basic Japanese Language</i><br>
                Teruslah berlatih dan gunakan bahasa ini untuk meraih mimpi Anda!
            </p>
            <div class="flex flex-col md:flex-row mt-4">
                <button class="bg-gray-300 text-black px-3 md:px-4 py-1 md:py-2 rounded-lg text-sm md:text-base mb-2 md:mb-0 md:mr-2">
                    Lihat Sertifikat
                </button>
                <button class="bg-blue-500 text-white px-3 md:px-4 py-1 md:py-2 rounded-lg text-sm md:text-base">
                    Unduh Sertifikat
                </button>
            </div>
        </div>
    </div>

    <!-- Sertifikat Skill -->
    <h3 class="text-lg md:text-xl font-semibold mb-3 mx-4 md:mx-6">Sertifikat Skill</h3>
    <div class="bg-white rounded-lg shadow-md p-3 md:p-4 flex flex-col md:flex-row items-center mb-6 mx-4 md:mx-6">
        <div class="w-full md:w-1/2 flex justify-center items-center">
            <img src="/logo.png" alt="Sertifikat" class="w-48 md:w-60 h-36 md:h-48 object-cover rounded-lg">
        </div>

        <div class="w-full md:w-1/2 text-center md:text-left mt-4 md:mt-0">
            <h4 class="text-base md:text-lg font-bold">Kerja keras Anda terbayar!</h4>
            <p class="my-2 text-sm md:text-base">
                Selamat telah menyelesaikan <br>
                <i class="font-semibold">Basic Japanese Language</i><br>
                Teruslah berlatih dan gunakan bahasa ini untuk meraih mimpi Anda!
            </p>
            <div class="flex flex-col md:flex-row mt-4">
                <button class="bg-gray-300 text-black px-3 md:px-4 py-1 md:py-2 rounded-lg text-sm md:text-base mb-2 md:mb-0 md:mr-2">
                    Lihat Sertifikat
                </button>
                <button class="bg-blue-500 text-white px-3 md:px-4 py-1 md:py-2 rounded-lg text-sm md:text-base">
                    Unduh Sertifikat
                </button>
            </div>
        </div>
    </div>

</main>

@endsection
