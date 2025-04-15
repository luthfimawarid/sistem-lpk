@extends('siswa.main.sidebar')

@section('content')
<!-- <div class="header flex justify-between items-center bg-white p-3 md:p-5">
    <h1 class="text-lg md:text-xl font-semibold mx-3 md:mx-7">Welcome Back, Alamsyah!</h1>
    <div class="kanan flex items-center space-x-3 md:space-x-5 me-3 md:me-5">
        <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
        </svg>
        <svg class="w-8 h-6 md:w-10 md:h-8 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
        </svg>
    </div>
</div> -->

<div class="p-5 md:p-10 bg-blue-50">
    <!-- Ongoing Courses -->
    <section class="mb-6">
        <div class="header flex justify-between items-center">
            <p class="text-lg md:text-xl font-semibold">Ongoing Courses (21)</p>
            <a href="/ebook" class="px-3 py-2 text-xs md:text-sm text-blue-600 border border-blue-600 rounded-full font-semibold">Lihat semua</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div class="bg-white rounded-lg shadow p-3 md:p-4 text-center">
                <img src="/logo.png" alt="Kanji Course" class="rounded-lg mb-2 mx-auto w-3/4 md:w-full">
                <p class="text-sm md:text-base font-medium">Mengenal Kanji Dasar (JLPT N5-N4)</p>
            </div>
            <div class="bg-white rounded-lg shadow p-3 md:p-4 text-center">
                <img src="/logo.png" alt="Conversation Course" class="rounded-lg mb-2 mx-auto w-3/4 md:w-full">
                <p class="text-sm md:text-base font-medium">Percakapan Sehari-hari dalam Bahasa Jepang</p>
            </div>
            <div class="bg-white rounded-lg shadow p-3 md:p-4 text-center">
                <img src="/logo.png" alt="Culture Course" class="rounded-lg mb-2 mx-auto w-3/4 md:w-full">
                <p class="text-sm md:text-base font-medium">Keberagaman Budaya Jepang</p>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Nilai Latihan -->
        <section class="md:col-span-2 bg-white rounded-lg shadow p-4 md:p-6">
            <div class="flex justify-between items-center mb-4">
                <p class="text-lg md:text-xl font-semibold">Nilai Latihan</p>
                <select id="chartFilter" class="border text-xs md:text-lg p-2 rounded-md">
                    <option value="daily">Harian</option>
                    <option value="weekly" selected>Mingguan</option>
                    <option value="monthly">Bulanan</option>
                </select>
            </div>
            <canvas id="nilaiChart"></canvas>
        </section>

        <!-- Chat -->
        <section class="bg-white rounded-lg shadow p-4 md:p-6 flex flex-col">
            <p class="text-lg font-medium">Pesan</p>
            <div id="chat-box" class="flex-1 overflow-y-auto space-y-3 mt-4">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-gray-300 rounded-full flex items-center justify-center font-medium">A</div>
                    <div class="bg-gray-100 rounded-lg p-2 md:p-3 w-full">
                        <p class="text-xs md:text-sm font-medium">~ Alamsyah</p>
                        <p class="text-xs md:text-sm">Jangan lupa tugas hari ini guys!!</p>
                        <p class="text-xs text-right text-blue-600">18.42</p>
                    </div>
                </div>
            </div>
            <form id="chat-form" class="flex mt-4">
                <input type="text" id="chat-input" class="w-full bg-blue-50 rounded-l-full p-2 text-xs md:text-sm" placeholder="Ketik pesan...">
                <button type="submit" class="bg-blue-600 text-white px-3 md:px-4 rounded-r-full">➤</button>
            </form>
        </section>
    </div>

    <!-- Kursus Saya & Prediksi Kelulusan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <section class="md:col-span-2 bg-white rounded-lg shadow p-4 md:p-6">
            <p class="text-lg md:text-xl font-semibold">Kursus Saya</p>
            <table class="w-full text-xs md:text-sm text-left mt-3">
                <thead>
                    <tr class="text-gray-600 bg-blue-50">
                        <th class="py-2 px-3 md:py-3 md:px-6">Courses Name</th>
                        <th class="py-2 px-3 md:py-3 md:px-6">Category</th>
                        <th class="py-2 px-3 md:py-3 md:px-6">Progress</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="py-2 px-3 md:py-3 md:px-6">Mengenal Kanji Dasar (JLPT N5-N4)</td>
                        <td class="py-2 px-3 md:py-3 md:px-6">Video</td>
                        <td class="py-2 px-3 md:py-3 md:px-6">45%</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="bg-white rounded-lg shadow p-4 md:p-6">
            <div class="flex justify-between items-center mb-4">
                <p class="text-lg md:text-xl font-semibold">Prediksi Kelulusan</p>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm md:text-base hover:bg-blue-600 transition">
                    Cek Prediksi
                </button>
            </div>
            <div class="flex justify-around items-center mb-4">
                <div class="bg-blue-600 text-white rounded-full w-14 h-14 md:w-20 md:h-20 flex items-center justify-center text-lg md:text-2xl font-bold">
                    62%
                </div>
                <p class="text-red-500 font-medium text-sm md:text-lg">Beresiko tidak lulus</p>
            </div>
            <div class="bg-gray-100 p-3 rounded-md text-sm md:text-base text-gray-700">
                <p><strong>Saran:</strong> Tingkatkan konsistensi belajar dan konsultasikan dengan dosen atau tutor untuk memperbaiki pemahaman materi.</p>
            </div>
        </section>

    </div>
</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('nilaiChart').getContext('2d');
        const chartFilter = document.getElementById('chartFilter');

        const chartData = {
            daily: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                nilaiBahasa: [80, 85, 90, 70, 75, 95, 100],
                nilaiBudaya: [70, 75, 85, 65, 80, 90, 95]
            },
            weekly: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                nilaiBahasa: [85, 88, 90, 92],
                nilaiBudaya: [75, 78, 80, 85]
            },
            monthly: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                nilaiBahasa: [75, 80, 85, 90, 88, 92, 95, 90, 85, 80, 78, 85],
                nilaiBudaya: [70, 72, 78, 80, 75, 85, 90, 85, 80, 75, 73, 80]
            }
        };

        let nilaiChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData['weekly'].labels,
                datasets: [
                    {
                        label: 'Nilai Bahasa',
                        data: chartData['weekly'].nilaiBahasa,
                        backgroundColor: '#0A58CA',
                        borderColor: '#0A58CA',
                        borderWidth: 1
                    },
                    {
                        label: 'Nilai Budaya',
                        data: chartData['weekly'].nilaiBudaya,
                        backgroundColor: '#FF7F00',
                        borderColor: '#FF7F00',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });

        chartFilter.addEventListener('change', function () {
            const selectedOption = this.value;
            nilaiChart.data.labels = chartData[selectedOption].labels;
            nilaiChart.data.datasets[0].data = chartData[selectedOption].nilaiBahasa;
            nilaiChart.data.datasets[1].data = chartData[selectedOption].nilaiBudaya;
            nilaiChart.update();
        });
    });
</script>
@endsection
