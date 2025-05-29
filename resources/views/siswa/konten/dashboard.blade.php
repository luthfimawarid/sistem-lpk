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
                <a href="{{ route('chat.index') }}" class="text-sm text-[#0A58CA]">Lihat semua</a>
            </div>

            <div id="chat-list" class="mt-4 space-y-3">
                @if($rooms->isEmpty())
                    <p class="text-center text-gray-500">Belum ada chat</p>
                @else
                    @foreach ($rooms as $room)
                        @php
                            $lastMessage = $room->messages->first();
                            $otherUser = $room->users->where('id', '!=', auth()->id())->first();
                            $roomName = $room->type === 'group' ? $room->name : ($otherUser->nama_lengkap ?? 'Private Chat');
                            $messageText = $lastMessage->message ?? 'Belum ada pesan';
                            $messageTime = optional($lastMessage?->created_at)->format('H:i');
                        @endphp
                        <a href="{{ route('chat.show', $room->id) }}" class="flex items-center hover:bg-gray-100 transition p-2 rounded-lg">
                            <img src="/logo.png" class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover mr-3" alt="Avatar">
                            <div class="flex-1">
                                <p class="text-xs md:text-sm font-semibold truncate">{{ $roomName }}</p>
                                <p class="text-xs text-gray-600 truncate">{{ $messageText }}</p>
                            </div>
                            <span class="text-xs text-gray-400 ml-2">{{ $messageTime }}</span>
                        </a>
                    @endforeach
                @endif
            </div>
        </section>
    </div>

    <!-- Kursus Saya & Prediksi Kelulusan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <section class="md:col-span-2 bg-white rounded-lg shadow p-4 md:p-6">
            <p class="text-lg md:text-xl font-semibold">Job Matching</p>

            @if ($sertifikatLulus < 2)
                <p class="text-center text-gray-500 mt-4">
                    Job Matching akan tersedia setelah kamu mendapatkan minimal 2 sertifikat lulus.
                </p>
            @else
                @if (count($jobMatchings) > 0)
                    <table class="w-full text-xs md:text-sm text-left mt-3">
                        <thead>
                            <tr class="text-gray-600 bg-blue-50">
                                <th class="py-2 px-3 md:py-3 md:px-6">Posisi</th>
                                <th class="py-2 px-3 md:py-3 md:px-6">Perusahaan</th>
                                <th class="py-2 px-3 md:py-3 md:px-6">Status Lamaran</th>
                                <th class="py-2 px-3 md:py-3 md:px-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobMatchings as $job)
                                <tr class="border-t">
                                    <td class="py-2 px-3 md:py-3 md:px-6">{{ $job->posisi }}</td>
                                    <td class="py-2 px-3 md:py-3 md:px-6">{{ $job->nama_perusahaan }}</td>
                                    <td class="py-2 px-3 md:py-3 md:px-6">
                                        @if (isset($jobApplications[$job->id]))
                                            <span class="px-2 py-1 rounded-full text-white text-xs
                                                {{ $jobApplications[$job->id]->status === 'lolos' ? 'bg-green-500' : ($jobApplications[$job->id]->status === 'diproses' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                                {{ ucfirst($jobApplications[$job->id]->status) }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 rounded-full text-gray-500 text-xs">
                                                Belum Melamar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-3 md:py-3 md:px-6">
                                        @if (!isset($jobApplications[$job->id]))
                                            <form action="{{ url('/job-matching/apply/' . $job->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                                    Ajukan Lamaran
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="bg-gray-300 text-gray-600 px-3 py-1 rounded text-xs">
                                                Sudah Melamar
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center text-gray-500 mt-4">
                        Tidak ada lowongan tersedia saat ini.
                    </p>
                @endif
            @endif
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
    const tanggalTerdaftar = new Date("{{ $tanggalTerdaftar }}");

    function getDayName(dateStr) {
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return days[new Date(dateStr).getDay()];
    }

    function getDefaultLabels(interval) {
        const today = new Date();
        const result = [];

        if (interval === 'daily') {
            return ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        }

        if (interval === 'weekly') {
            const month = today.getMonth();
            const year = today.getFullYear();
            const date = new Date(year, month, 1);

            const weeks = new Set();

            while (date.getMonth() === month) {
                const firstDayOfMonth = new Date(year, month, 1);
                const offset = (date.getDate() + firstDayOfMonth.getDay() - 1);
                const weekNumber = Math.floor(offset / 7) + 1;
                weeks.add(`Minggu ke-${weekNumber}`);
                date.setDate(date.getDate() + 1);
            }

            return Array.from(weeks);
        }

        if (interval === 'monthly') {
            const startMonth = tanggalTerdaftar.getMonth();
            const startYear = tanggalTerdaftar.getFullYear();
            const currentMonth = today.getMonth();
            const currentYear = today.getFullYear();

            const totalMonths = (currentYear - startYear) * 12 + (currentMonth - startMonth) + 1;

            for (let i = 0; i < totalMonths; i++) {
                const labelDate = new Date(startYear, startMonth + i);
                const monthYear = labelDate.toLocaleString('id-ID', { month: 'long', year: 'numeric' });
                result.push(monthYear.charAt(0).toUpperCase() + monthYear.slice(1));
            }

            return result;
        }

        return [];
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
                const today = new Date();
                const currentMonth = today.getMonth();
                const currentYear = today.getFullYear();

                if (date.getMonth() !== currentMonth || date.getFullYear() !== currentYear) return;

                const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
                const offset = (date.getDate() + firstDayOfMonth.getDay() - 1);
                const weekNumber = Math.floor(offset / 7) + 1;
                label = `Minggu ke-${weekNumber}`;
            } else if (interval === 'monthly') {
                const userStartMonth = tanggalTerdaftar.getMonth();
                const userStartYear = tanggalTerdaftar.getFullYear();

                if (
                    date.getFullYear() < userStartYear ||
                    (date.getFullYear() === userStartYear && date.getMonth() < userStartMonth)
                ) {
                    return; // skip data sebelum akun dibuat
                }

                const monthDiff = (date.getFullYear() - userStartYear) * 12 + (date.getMonth() - userStartMonth);
                const labelDate = new Date(date.getFullYear(), date.getMonth());
                const monthYear = labelDate.toLocaleString('id-ID', { month: 'long', year: 'numeric' });
                label = monthYear.charAt(0).toUpperCase() + monthYear.slice(1);
            }

            if (!label) return;

            if (!grouped[label]) {
                grouped[label] = [];
                if (!labelMap.has(label)) labelMap.set(label, index++);
            }

            grouped[label].push(entry.nilai);
        });

        const sortedLabels = Array.from(labelMap.entries()).sort((a, b) => a[1] - b[1]).map(l => l[0]);

        const values = sortedLabels.map(label => {
            const nilai = grouped[label];
            return Math.round(nilai.reduce((a, b) => a + b, 0) / nilai.length);
        });

        return { labels: sortedLabels, values };
    }

    const intervalSelect = document.getElementById('intervalSelect');
    let chartInstance = null;

    function renderChart(interval) {
        const defaultLabels = getDefaultLabels(interval);

        const tugas = formatDataByInterval(nilaiTugas, interval);
        const evaluasi = formatDataByInterval(nilaiEvaluasi, interval);
        const tryout = formatDataByInterval(nilaiTryout, interval);

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
                labels: defaultLabels,
                datasets: [
                    {
                        label: 'Tugas',
                        data: alignData(defaultLabels, tugas),
                        borderColor: '#0A58CA',
                        backgroundColor: 'rgba(10, 88, 202, 0.2)',
                        borderWidth: 2,
                        tension: 0.4,
                        spanGaps: true
                    },
                    {
                        label: 'Evaluasi',
                        data: alignData(defaultLabels, evaluasi),
                        borderColor: '#FFCE56',
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderWidth: 2,
                        tension: 0.4,
                        spanGaps: true
                    },
                    {
                        label: 'Tryout',
                        data: alignData(defaultLabels, tryout),
                        borderColor: '#FF6384',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        tension: 0.4,
                        spanGaps: true
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
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
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
