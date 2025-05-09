@extends('siswa.main.sidebar')

@section('content')
<div class="p-6 md:p-10 bg-blue-50 min-h-screen">
    <div class="flex flex-col md:flex-row gap-4">
        <!-- Grafik Perkembangan Nilai -->
        <section class="w-full md:w-[67.5%]">
            <div class="bg-white rounded-lg shadow p-4 md:p-6 h-full flex flex-col justify-between">
                <div class="flex justify-between items-center">
                    <p class="text-xs md:text-xl font-semibold mb-2 md:mb-4">Grafik Perkembangan Nilai</p>
                    <div class="mb-2 md:mb-4">
                        <select id="intervalSelect" class="ml-2 p-1 border text-xs md:text-lg rounded">
                            <option value="daily">Harian</option>
                            <option value="weekly" selected>Mingguan</option>
                            <option value="monthly">Bulanan</option>
                        </select>
                    </div>
                </div>
                <div class="w-full overflow-x-auto">
                    <canvas id="nilaiChart" class="w-full"></canvas>
                </div>
            </div>
        </section>

        <!-- Prediksi Kelulusan -->
        <section class="w-full md:w-[32.5%]">
            <div class="bg-white rounded-lg shadow p-6 h-full flex flex-col">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-sm md:text-lg font-semibold">Prediksi Kelulusan</p>
                    <button class="bg-[#0A58CA] text-white px-2 py-2 rounded-lg text-sm md:text-sm hover:bg-blue-600 transition">
                        Cek Prediksi
                    </button>
                </div>
                <div class="flex justify-around items-center mb-4">
                    <div class="bg-[#0A58CA] text-white rounded-full w-20 h-20 flex items-center justify-center text-2xl font-bold">
                        78%
                    </div>
                    <p class="text-green-500 font-medium text-lg text-left">
                        Lulus
                    </p>
                </div>
                <div class="text-sm">
                    <p class="font-bold mb-1">Saran Perbaikan</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Latihan soal lebih rutin</li>
                        <li>Perbanyak mendengarkan percakapan Jepang</li>
                    </ul>
                </div>
            </div>
        </section>
    </div>

    <section class="my-6 w-full overflow-x-auto">
        <div class="bg-white rounded-lg shadow min-w-[600px] md:w-full">
            <div class="mx-6 mt-5 pt-10 pb-2">
                <p class="text-xl font-semibold">Rapor dan Nilai Saya</p>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-gray-600 bg-blue-50">
                        <th class="py-3 px-4 text-left">Mata Pelajaran</th>
                        <th class="py-3 px-4 text-center">Nilai Bahasa</th>
                        <th class="py-3 px-4 text-center">Nilai Budaya</th>
                        <th class="py-3 px-4 text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="py-3 px-4">Bahasa Jepang</td>
                        <td class="py-3 px-4 text-center">78</td>
                        <td class="py-3 px-4 text-center">85</td>
                        <td class="py-3 px-4 text-center text-green-600 font-medium">Lulus</td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-3 px-4">Budaya Jepang</td>
                        <td class="py-3 px-4 text-center">74</td>
                        <td class="py-3 px-4 text-center">80</td>
                        <td class="py-3 px-4 text-center text-green-600 font-medium">Lulus</td>
                    </tr>
                    <!-- Baris untuk Rata-rata Nilai -->
                    <tr class="border-t bg-gray-100">
                        <td class="py-3 px-4 font-semibold">Rata-rata</td>
                        <td class="py-3 px-4 text-center font-semibold text-blue-600">76</td>
                        <td class="py-3 px-4 text-center font-semibold text-blue-600">82.5</td>
                        <td class="py-3 px-4 text-center font-semibold text-gray-700">-</td>
                    </tr>
                </tbody>
            </table>
            <div class="p-6 flex justify-end">
                <button class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600">
                    Unduh Rapor
                </button>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('nilaiChart').getContext('2d');
        const intervalSelect = document.getElementById('intervalSelect');

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
                        backgroundColor: 'rgba(10, 88, 202, 0.2)',
                        borderColor: '#0A58CA',
                        borderWidth: 2,
                        tension: 0.3
                    },
                    {
                        label: 'Nilai Budaya',
                        data: chartData['weekly'].nilaiBudaya,
                        backgroundColor: 'rgba(255, 127, 0, 0.2)',
                        borderColor: '#FF7F00',
                        borderWidth: 2,
                        tension: 0.3
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

        intervalSelect.addEventListener('change', function () {
            const selectedOption = this.value;
            nilaiChart.data.labels = chartData[selectedOption].labels;
            nilaiChart.data.datasets[0].data = chartData[selectedOption].nilaiBahasa;
            nilaiChart.data.datasets[1].data = chartData[selectedOption].nilaiBudaya;
            nilaiChart.update();
        });
    });
</script>
@endsection
