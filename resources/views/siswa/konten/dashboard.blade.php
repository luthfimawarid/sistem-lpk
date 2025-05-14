@extends('siswa.main.sidebar')

@section('content')
<div class="p-5 md:p-10 bg-blue-50">
    <!-- Ongoing Courses -->
<section class="mb-6">
    <div class="flex justify-between items-center">
        <p class="text-base md:text-lg font-semibold">Ongoing Courses (21)</p>
        <a href="/ebook" class="px-3 py-1 text-sm md:text-base text-[#0A58CA] rounded-full font-semibold border border-[#0A58CA]">Lihat semua</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
        @foreach ($courses as $course)
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <img src="{{ asset('storage/cover/' . $course->cover) }}" alt="Course Image" class="rounded-lg mb-2 mx-auto max-w-[150px]">
                <p class="font-medium text-base md:text-lg">{{ $course->judul }}</p>
            </div>
        @endforeach
    </div>
</section>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <section class="md:col-span-2 bg-white rounded-lg shadow p-4 md:p-6">
            <div class="flex justify-between items-center mb-4">
                <p class="text-lg md:text-xl font-semibold">Nilai Latihan</p>
                <select id="intervalSelect" class="border text-xs md:text-lg p-2 rounded-md">
                    <option value="daily">Harian</option>
                    <option value="weekly" selected>Mingguan</option>
                    <option value="monthly">Bulanan</option>
                </select>
            </div>
            <canvas id="nilaiChart"></canvas>
        </section>

        <!-- Chat -->
        <section class="bg-white rounded-lg shadow p-4 md:p-6 flex flex-col">
            <div class="flex justify-between items-center">
                <p class="text-lg font-medium">Pesan</p>
                <a href="/chat" class="text-sm text-[#0A58CA]">Lihat semua</a>
            </div>
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
                        <th class="py-2 px-3 md:py-3 md:px-6">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myCourses as $materi)
                        <tr class="border-t">
                            <td class="py-2 px-3 md:py-3 md:px-6">{{ $materi->judul }}</td>
                            <td class="py-2 px-3 md:py-3 md:px-6">{{ ucfirst($materi->tipe) }}</td>
                            <td class="py-2 px-3 md:py-3 md:px-6">aktif</td> {{-- Dummy progress --}}
                        </tr>
                    @endforeach
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
