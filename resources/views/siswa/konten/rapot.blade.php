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
                        <th class="py-3 px-4 text-left">Tipe Penilaian</th>
                        <th class="py-3 px-4 text-center">Nilai</th>
                        <th class="py-3 px-4 text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="py-3 px-4">Tugas</td>
                        <td class="py-3 px-4 text-center">{{ $rataTugas ?? '-' }}</td>
                        <td class="py-3 px-4 text-center text-{{ $rataTugas >= 75 ? 'green' : 'red' }}-600 font-medium">
                            {{ $rataTugas !== null ? $status($rataTugas) : '-' }}
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-3 px-4">Evaluasi Mingguan</td>
                        <td class="py-3 px-4 text-center">{{ $rataEvaluasi ?? '-' }}</td>
                        <td class="py-3 px-4 text-center text-{{ $rataEvaluasi >= 75 ? 'green' : 'red' }}-600 font-medium">
                            {{ $rataEvaluasi !== null ? $status($rataEvaluasi) : '-' }}
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-3 px-4">Tryout</td>
                        <td class="py-3 px-4 text-center">{{ $rataTryout ?? '-' }}</td>
                        <td class="py-3 px-4 text-center text-{{ $rataTryout >= 75 ? 'green' : 'red' }}-600 font-medium">
                            {{ $rataTryout !== null ? $status($rataTryout) : '-' }}
                        </td>
                    </tr>

                    <tr class="border-t bg-gray-100">
                        <td class="py-3 px-4 font-semibold">Rata-rata Keseluruhan</td>
                        <td class="py-3 px-4 text-center font-semibold text-blue-600">
                            {{
                                collect([$rataTugas, $rataEvaluasi, $rataTryout])
                                    ->filter()
                                    ->avg() ? round(collect([$rataTugas, $rataEvaluasi, $rataTryout])
                                    ->filter()
                                    ->avg()) : '-'
                            }}
                        </td>
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
    const nilaiTugas = @json($nilaiTugas);
    const nilaiEvaluasi = @json($nilaiEvaluasi);
    const nilaiTryout = @json($nilaiTryout);

    function getDayName(dateStr) {
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return days[new Date(dateStr).getDay()];
    }

    function formatDataByInterval(data, interval) {
        const grouped = {};
        const labelMap = new Map();

        let index = 1;

        data.forEach(entry => {
            const date = new Date(entry.tanggal);
            let label = '';

            if (interval === 'daily') {
                label = getDayName(entry.tanggal);
            } else if (interval === 'weekly') {
                const yearStart = new Date(date.getFullYear(), 0, 1);
                const weekNumber = Math.ceil((((date - yearStart) / 86400000) + yearStart.getDay() + 1) / 7);
                label = `Minggu ke-${weekNumber}`;
            } else if (interval === 'monthly') {
                label = `Bulan ke-${date.getMonth() + 1}`;
            }

            if (!grouped[label]) {
                grouped[label] = [];
                if (!labelMap.has(label)) labelMap.set(label, index++);
            }

            grouped[label].push(entry.nilai);
        });

        const sortedLabels = Array.from(labelMap.entries()).sort((a, b) => a[1] - b[1]).map(l => l[0]);
        const values = sortedLabels.map(label => {
            const nilai = grouped[label];
            return Math.round(nilai.reduce((a, b) => a + b, 0) / nilai.length); // rata-rata
        });

        return { labels: sortedLabels, values };
    }

    const intervalSelect = document.getElementById('intervalSelect');
    let chartInstance = null;

    function renderChart(interval) {
        const tugas = formatDataByInterval(nilaiTugas, interval);
        const evaluasi = formatDataByInterval(nilaiEvaluasi, interval);
        const tryout = formatDataByInterval(nilaiTryout, interval);

        const allLabels = [...new Set([...tugas.labels, ...evaluasi.labels, ...tryout.labels])];

        const alignData = (labels, dataset) => {
            return labels.map(label => {
                const idx = dataset.labels.indexOf(label);
                return idx !== -1 ? dataset.values[idx] : null;
            });
        };

        if (chartInstance) chartInstance.destroy();

        chartInstance = new Chart(document.getElementById('nilaiChart'), {
            type: 'line',
            data: {
                labels: allLabels,
                datasets: [
                    {
                        label: 'Tugas',
                        data: alignData(allLabels, tugas),
                        borderColor: '#0A58CA',
                        backgroundColor: 'rgba(10, 88, 202, 0.2)',
                        borderWidth: 2,
                        tension: 0.4
                    },
                    {
                        label: 'Evaluasi',
                        data: alignData(allLabels, evaluasi),
                        borderColor: '#FFCE56',
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderWidth: 2,
                        tension: 0.4
                    },
                    {
                        label: 'Tryout',
                        data: alignData(allLabels, tryout),
                        borderColor: '#FF6384',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderChart(intervalSelect.value);
    });

    intervalSelect.addEventListener('change', () => {
        renderChart(intervalSelect.value);
    });
</script>
@endsection
