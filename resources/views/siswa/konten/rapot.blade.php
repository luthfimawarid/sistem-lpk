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
                            <option value="harian">Harian</option>
                            <option value="mingguan">Mingguan</option>
                            <option value="bulanan" selected>Bulanan</option>
                        </select>
                    </div>
                </div>
                <!-- Membungkus grafik dalam div yang bisa di-scroll -->
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

    <!-- Tabel Nilai Siswa -->
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
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('nilaiChart').getContext('2d');
            const selectInterval = document.getElementById('intervalSelect');

            // Dataset Harian
            const dataHarian = {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Nilai Bahasa Jepang',
                    data: [65, 87, 70, 79, 95, 73, 80],
                    backgroundColor: 'rgba(10, 88, 202, 0.2)',
                    borderColor: '#0A58CA',
                    borderWidth: 2
                }, {
                    label: 'Nilai Budaya Jepang',
                    data: [68, 82, 72, 90, 77, 84, 82],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 2
                }]
            };

            // Dataset Mingguan
            const dataMingguan = {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [{
                    label: 'Nilai Bahasa Jepang',
                    data: [70, 88, 69, 93],
                    backgroundColor: 'rgba(10, 88, 202, 0.2)',
                    borderColor: '#0A58CA',
                    borderWidth: 2
                }, {
                    label: 'Nilai Budaya Jepang',
                    data: [79, 70, 64, 85],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 2
                }]
            };

            // Dataset Bulanan
            const dataBulanan = {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei'],
                datasets: [{
                    label: 'Nilai Bahasa Jepang',
                    data: [65, 80, 75, 94, 80],
                    backgroundColor: 'rgba(10, 88, 202, 0.2)',
                    borderColor: '#0A58CA',
                    borderWidth: 2
                }, {
                    label: 'Nilai Budaya Jepang',
                    data: [68, 84, 76, 66, 85],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 2
                }]
            };

            // Buat grafik awal (default: Bulanan)
            let nilaiChart = new Chart(ctx, {
                type: 'line',
                data: dataBulanan,
                options: {
                    responsive: true,
                    maintainAspectRatio: true, // Supaya grafik lebih proporsional
                    aspectRatio: 2, // Menyesuaikan tinggi grafik agar tidak terlalu tinggi di mobile
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 10 // Ukuran teks lebih kecil di mobile
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 10,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });

            // Event Listener untuk mengganti data berdasarkan dropdown
            selectInterval.addEventListener('change', function() {
                if (this.value === 'harian') {
                    nilaiChart.data = dataHarian;
                } else if (this.value === 'mingguan') {
                    nilaiChart.data = dataMingguan;
                } else {
                    nilaiChart.data = dataBulanan;
                }
                nilaiChart.update();
            });
        });
    </script>
@endsection
