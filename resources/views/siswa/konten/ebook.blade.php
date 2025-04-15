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
        <!-- Title & Sort -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">E-book (15)</h2>
            <button class="border-2 border-gray-400 font-semibold text-sm text-gray-400 px-4 flex items-center py-2 rounded-lg">
                Sort By
                <svg class="w-6 h-6 text-gray-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="/logo.png" alt="Cover E-book" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Belajar Hiragana</h3>
                    <p class="text-sm text-gray-600 mt-2">By Nakamura</p>
                    <div class="mt-4 flex space-x-2">
                        <a href="/ebooks/belajar-hiragana.pdf" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">Buka</a>
                        <a href="/ebooks/belajar-hiragana.pdf" download class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm">Unduh</a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="/logo.png" alt="Cover E-book" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Kanji Dasar</h3>
                    <p class="text-sm text-gray-600 mt-2">By Yamada</p>
                    <div class="mt-4 flex space-x-2">
                        <a href="/ebooks/kanji-dasar.pdf" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">Buka</a>
                        <a href="/ebooks/kanji-dasar.pdf" download class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm">Unduh</a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="/logo.png" alt="Cover E-book" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Percakapan Sehari-hari</h3>
                    <p class="text-sm text-gray-600 mt-2">By Fujimoto</p>
                    <div class="mt-4 flex space-x-2">
                        <a href="/ebooks/percakapan-sehari-hari.pdf" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">Buka</a>
                        <a href="/ebooks/percakapan-sehari-hari.pdf" download class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm">Unduh</a>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="/logo.png" alt="Cover E-book" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Percakapan Sehari-hari</h3>
                    <p class="text-sm text-gray-600 mt-2">By Fujimoto</p>
                    <div class="mt-4 flex space-x-2">
                        <a href="/ebooks/percakapan-sehari-hari.pdf" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">Buka</a>
                        <a href="/ebooks/percakapan-sehari-hari.pdf" download class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm">Unduh</a>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="/logo.png" alt="Cover E-book" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Percakapan Sehari-hari</h3>
                    <p class="text-sm text-gray-600 mt-2">By Fujimoto</p>
                    <div class="mt-4 flex space-x-2">
                        <a href="/ebooks/percakapan-sehari-hari.pdf" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">Buka</a>
                        <a href="/ebooks/percakapan-sehari-hari.pdf" download class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm">Unduh</a>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="/logo.png" alt="Cover E-book" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Percakapan Sehari-hari</h3>
                    <p class="text-sm text-gray-600 mt-2">By Fujimoto</p>
                    <div class="mt-4 flex space-x-2">
                        <a href="/ebooks/percakapan-sehari-hari.pdf" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">Buka</a>
                        <a href="/ebooks/percakapan-sehari-hari.pdf" download class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm">Unduh</a>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="/logo.png" alt="Cover E-book" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Percakapan Sehari-hari</h3>
                    <p class="text-sm text-gray-600 mt-2">By Fujimoto</p>
                    <div class="mt-4 flex space-x-2">
                        <a href="/ebooks/percakapan-sehari-hari.pdf" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">Buka</a>
                        <a href="/ebooks/percakapan-sehari-hari.pdf" download class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm">Unduh</a>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('nilaiChart').getContext('2d');
        const nilaiChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Nilai',
                    data: [80, 85, 90, 70, 75, 95, 100], // Contoh data
                    backgroundColor: '#0A58CA',
                    borderColor: '#0A58CA',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
