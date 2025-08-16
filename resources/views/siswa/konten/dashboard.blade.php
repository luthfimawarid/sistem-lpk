@extends('siswa.main.sidebar')

@section('content')
<!-- @if($kuisBelumDikerjakan)
    <div id="kuisModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm sm:max-w-md p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-semibold mb-2 text-gray-800">Kuis Baru Tersedia!</h2>
            <p class="text-gray-600 mb-4 text-sm">Kamu memiliki kuis yang belum dikerjakan. Yuk kerjakan sekarang untuk meningkatkan nilai!</p>
            <div class="flex justify-end space-x-2">
                <button onclick="document.getElementById('kuisModal').classList.add('hidden')" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-sm">Nanti</button>
                <a href="{{ route('siswa.tugas') }}" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white text-sm">Kerjakan Sekarang</a>
            </div>
        </div>
    </div>
@endif -->

<div class="p-4 sm:p-5 md:p-10 bg-blue-50">
    {{-- Ebook --}}
    <section class="mb-6">
        <div class="flex justify-between items-center flex-wrap gap-2">
            <p id="ebook-count" class="text-base md:text-lg font-semibold">
                Ebook ({{ $materi->count() }})
            </p>
            <a href="/ebook" class="px-3 py-1 text-sm md:text-base text-[#0A58CA] border border-[#0A58CA] rounded-full font-semibold">
                Lihat semua
            </a>
        </div>

        <div class="mt-4">
            @if ($materi->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($materi->take(3) as $course)
                        <div class="bg-white rounded-lg shadow p-4 text-center">
                            <img src="{{ asset('/logo.png') }}" alt="Course Image"
                                class="rounded-lg mb-2 mx-auto max-w-[120px] sm:max-w-[140px]">
                            <p class="font-medium text-sm md:text-base">{{ $course->judul }}</p>
                            <div class="mt-3 flex flex-col sm:flex-row justify-center gap-2">
                                <a href="{{ asset('storage/materi/' . $course->file) }}" target="_blank"
                                class="bg-blue-500 text-white px-4 py-2 rounded text-xs sm:text-sm">Buka</a>
                                <a href="{{ asset('storage/materi/' . $course->file) }}" download
                                class="bg-green-500 text-white px-4 py-2 rounded text-xs sm:text-sm">Unduh</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-sm text-gray-500 mt-3">
                    Belum ada ebook yang tersedia saat ini.
                </p>
            @endif
        </div>
    </section>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Nilai Chart --}}
        <section class="md:col-span-2 bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
                <p class="text-base md:text-xl font-semibold">Nilai Latihan</p>
                <select id="intervalSelect" class="border text-sm md:text-base p-2 rounded-md">
                    <option value="daily">Harian</option>
                    <option value="weekly" selected>Mingguan</option>
                    <option value="monthly">Bulanan</option>
                </select>
            </div>
            <canvas id="nilaiChart" class="min-h-[200px] w-full"></canvas>
        </section>

        {{-- Chat --}}
        <section class="bg-white rounded-lg shadow p-4 sm:p-6 flex flex-col">
            <div class="flex justify-between items-center mb-2">
                <p class="text-base md:text-lg font-medium">Pesan</p>
                <a href="{{ route('chat.index') }}" class="text-sm text-[#0A58CA]">Lihat semua</a>
            </div>
            <div id="chat-list" class="mt-2 space-y-3">
                @if($rooms->isEmpty())
                    <p class="text-center text-gray-500 text-sm">Belum ada chat</p>
                @else
                    @foreach ($rooms as $room)
                        @php
                            $lastMessage = $room->messages->first();
                            $isGroup = $room->type === 'group';
                            $otherUser = !$isGroup ? $room->users->where('id', '!=', auth()->id())->first() : null;

                            $roomName = $isGroup
                                ? $room->name
                                : ($otherUser->nama_lengkap ?? 'Private Chat');

                            $messageText = $lastMessage->message ?? 'Belum ada pesan';
                            $messageTime = optional($lastMessage?->created_at)->format('H:i');

                            $photo = $isGroup
                                ? asset('/logo.png') // Grup pakai logo
                                : ($otherUser && $otherUser->photo
                                    ? asset('storage/' . $otherUser->photo)
                                    : asset('/default-user.png')); // Default kalau tidak ada foto
                        @endphp

                        <a href="{{ route('chat.show', $room->id) }}" class="flex items-center hover:bg-gray-100 transition p-2 rounded-lg">
                            <img src="{{ $photo }}" class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover mr-3 border" alt="Avatar">
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

    {{-- Job Matching & Prediksi --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        {{-- Job Matching --}}
        <section class="md:col-span-2 bg-white rounded-lg shadow p-4 sm:p-6">
            <p class="text-base md:text-xl font-semibold mb-4">Job Matching</p>

            {{-- ✅ Lowongan tanpa sertifikat --}}
            <h3 class="text-sm sm:text-base font-semibold mb-2 text-green-600">Lowongan Terbuka (Tanpa Sertifikat)</h3>
            @if ($jobTanpaSertifikat->isEmpty())
                <p class="text-gray-500 text-sm mb-4">Tidak ada lowongan yang tersedia tanpa sertifikat.</p>
            @else
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-[#0A58CA] text-white">
                            <tr>
                                <th class="py-2 px-4">Posisi</th>
                                <th class="py-2 px-4">Perusahaan</th>
                                <th class="py-2 px-4">Status Lamaran</th>
                                <th class="py-2 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobTanpaSertifikat as $job)
                                <tr class="border-t">
                                    <td class="py-2 px-4">{{ $job->posisi }}</td>
                                    <td class="py-2 px-4">{{ $job->nama_perusahaan }}</td>
                                    <td class="py-2 px-4">
                                        @if (isset($jobApplications[$job->id]))
                                            <span class="px-2 py-1 text-white rounded
                                                {{ $jobApplications[$job->id]->status == 'lolos' ? 'bg-green-500' :
                                                ($jobApplications[$job->id]->status == 'diproses' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                                {{ ucfirst($jobApplications[$job->id]->status) }}
                                            </span>

                                            @if ($jobApplications[$job->id]->interview_message)
                                                <div class="mt-1 text-sm text-blue-600">
                                                    <p>{{ $jobApplications[$job->id]->interview_message }}</p>
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-gray-500">Belum Melamar</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4">
                                        @if (!isset($jobApplications[$job->id]))
                                            <form action="{{ route('siswa.job-matching.apply', $job->id) }}" method="POST">
                                                @csrf
                                                <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                                    Lamar
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="bg-gray-300 text-gray-600 px-3 py-1 rounded">
                                                Sudah Melamar
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ✅ Lowongan butuh sertifikat --}}
            <h3 class="text-sm sm:text-base font-semibold mb-2 text-indigo-600">Lowongan Khusus (Butuh 2 Sertifikat)</h3>
            @if ($sertifikatLulus < 2)
                <p class="text-gray-500 text-sm">Kamu belum memiliki 2 sertifikat lulus. Dapatkan minimal 2 sertifikat untuk melihat lowongan ini.</p>
            @elseif ($jobButuhSertifikat->isEmpty())
                <p class="text-gray-500 text-sm">Tidak ada lowongan khusus saat ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-[#0A58CA] text-white">
                            <tr>
                                <th class="py-2 px-4">Posisi</th>
                                <th class="py-2 px-4">Perusahaan</th>
                                <th class="py-2 px-4">Status Lamaran</th>
                                <th class="py-2 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobButuhSertifikat as $job)
                                <tr class="border-t">
                                    <td class="py-2 px-4">{{ $job->posisi }}</td>
                                    <td class="py-2 px-4">{{ $job->nama_perusahaan }}</td>
                                    <td class="py-2 px-4">
                                        @if (isset($jobApplications[$job->id]))
                                            <span class="px-2 py-1 text-white rounded
                                                {{ $jobApplications[$job->id]->status == 'lolos' ? 'bg-green-500' :
                                                ($jobApplications[$job->id]->status == 'diproses' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                                {{ ucfirst($jobApplications[$job->id]->status) }}
                                            </span>

                                            @if ($jobApplications[$job->id]->interview_message)
                                                <div class="mt-1 text-sm text-blue-600">
                                                    <p>{{ $jobApplications[$job->id]->interview_message }}</p>
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-gray-500">Belum Melamar</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4">
                                        @if (!isset($jobApplications[$job->id]))
                                            <form action="{{ route('siswa.job-matching.apply', $job->id) }}" method="POST">
                                                @csrf
                                                <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                                    Lamar
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="bg-gray-300 text-gray-600 px-3 py-1 rounded">
                                                Sudah Melamar
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        {{-- Prediksi Kelulusan --}}
        <section class="bg-white rounded-lg shadow p-4 sm:p-6">
            <p class="text-base md:text-xl font-semibold mb-4">Prediksi Kelulusan</p>
            
            {{-- Menggunakan variabel yang sudah diolah di controller --}}
            @php
                $warnaBulatan = 'bg-gray-400';
                $warnaTeks = 'text-gray-700';
                
                if ($hasilPrediksi == 'Lulus') {
                    $warnaBulatan = 'bg-green-600';
                    $warnaTeks = 'text-green-600';
                } elseif ($hasilPrediksi == 'Beresiko') {
                    $warnaBulatan = 'bg-yellow-500';
                    $warnaTeks = 'text-yellow-600';
                } elseif ($hasilPrediksi == 'Tidak Lulus') {
                    $warnaBulatan = 'bg-red-600';
                    $warnaTeks = 'text-red-600';
                }
            @endphp
            
            <div class="flex justify-around items-center mb-4">
                {{-- Menggunakan variabel yang sudah diolah --}}
                <div class="bg {{ $warnaBulatan }} text-white rounded-full w-20 h-20 sm:w-24 sm:h-24 flex items-center justify-center text-base sm:text-lg font-bold">
                    {{ $nilaiPersen ?? 0 }}%
                </div>
                <p class="{{ $warnaTeks }} font-medium text-base sm:text-xl">
                    {{ $hasilPrediksi }}
                </p>
            </div>
            
            <button id="btnCekPrediksi" class="bg-[#0A58CA] w-full text-white px-4 py-2 rounded-full text-sm sm:text-base hover:bg-blue-600 transition flex items-center justify-center">
                <span id="textCek">Cek Prediksi</span>
                <svg id="loadingIcon" class="animate-spin ml-2 h-4 w-4 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-65" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
            </button>
            
            {{-- Kondisional untuk menampilkan catatan/saran --}}
            @if ($saran)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-3 my-4 rounded-md text-sm sm:text-base">
                    <strong>Catatan:</strong> {{ $saran }}
                </div>
            @endif
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
        const result = [];
        const now = new Date();

        if (interval === 'daily') {
            // Cari Senin minggu ini
            const currentDay = now.getDay();
            const distanceFromMonday = (currentDay + 6) % 7;
            const monday = new Date(now);
            monday.setDate(now.getDate() - distanceFromMonday);

            // Push Senin sampai Jumat
            for (let i = 0; i < 5; i++) {
                const d = new Date(monday);
                d.setDate(monday.getDate() + i);
                result.push(getDayName(d));
            }
            return result;
        }

        if (interval === 'weekly') {
            const start = new Date(tanggalTerdaftar);
            start.setHours(0, 0, 0, 0);
            const current = new Date();
            current.setHours(0, 0, 0, 0);
            const msPerWeek = 7 * 24 * 60 * 60 * 1000;
            const totalWeeks = Math.ceil((current - start) / msPerWeek);

            for (let i = 1; i <= totalWeeks; i++) {
                result.push(`Minggu ke-${i}`);
            }
            return result;
        }

        if (interval === 'monthly') {
            const startMonth = tanggalTerdaftar.getMonth();
            const startYear = tanggalTerdaftar.getFullYear();
            const currentMonth = now.getMonth();
            const currentYear = now.getFullYear();

            const totalMonths = (currentYear - startYear) * 12 + (currentMonth - startMonth) + 1;

            for (let i = 0; i < totalMonths; i++) {
                const d = new Date(startYear, startMonth + i);
                const monthYear = d.toLocaleString('id-ID', { month: 'long', year: 'numeric' });
                result.push(monthYear.charAt(0).toUpperCase() + monthYear.slice(1));
            }
            return result;
        }

        return result;
    }

    function formatDataByInterval(data, interval) {
        const grouped = {};
        const labelDates = {};
        const labelMap = new Map();
        const now = new Date();
        let index = 1;

        data.forEach(entry => {
            const date = new Date(entry.tanggal);
            let label = '';

            if (interval === 'daily') {
                // Ambil Senin-Jumat minggu ini
                const currentDay = now.getDay();
                const distanceFromMonday = (currentDay + 6) % 7;
                const monday = new Date(now);
                monday.setDate(now.getDate() - distanceFromMonday);
                monday.setHours(0, 0, 0, 0);

                const friday = new Date(monday);
                friday.setDate(monday.getDate() + 4);
                friday.setHours(23, 59, 59, 999);

                if (date < monday || date > friday) return;

                const day = date.getDay();
                if (day < 1 || day > 5) return; // Hanya Senin - Jumat

                label = getDayName(date);
            } else if (interval === 'weekly') {
                const start = new Date(tanggalTerdaftar);
                start.setHours(0, 0, 0, 0);
                const msPerWeek = 7 * 24 * 60 * 60 * 1000;
                const diffMs = date - start;
                if (diffMs < 0) return;
                const weekNumber = Math.floor(diffMs / msPerWeek) + 1;
                label = `Minggu ke-${weekNumber}`;
            } else if (interval === 'monthly') {
                const userStartMonth = tanggalTerdaftar.getMonth();
                const userStartYear = tanggalTerdaftar.getFullYear();

                if (
                    date.getFullYear() < userStartYear ||
                    (date.getFullYear() === userStartYear && date.getMonth() < userStartMonth)
                ) return;

                const labelDate = new Date(date.getFullYear(), date.getMonth());
                const monthYear = labelDate.toLocaleString('id-ID', { month: 'long', year: 'numeric' });
                label = monthYear.charAt(0).toUpperCase() + monthYear.slice(1);
            }

            if (!label) return;

            if (!grouped[label]) {
                grouped[label] = [];
                labelDates[label] = [];
                labelMap.set(label, index++);
            }

            grouped[label].push(entry.nilai);
            labelDates[label].push(entry.tanggal);
        });

        const sortedLabels = Array.from(labelMap.entries()).sort((a, b) => a[1] - b[1]).map(([label]) => label);
        const values = sortedLabels.map(label => {
            const nilai = grouped[label];
            return Math.round(nilai.reduce((a, b) => a + b, 0) / nilai.length);
        });

        return { labels: sortedLabels, values, dates: labelDates };
    }

    function formatTanggalID(dates, interval) {
        if (!dates || dates.length === 0) return "";

        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        const sorted = dates.map(d => new Date(d)).sort((a, b) => a - b);

        if (interval === 'daily') {
            return sorted[0].toLocaleDateString('id-ID', options);
        }

        if (interval === 'weekly') {
            return `${sorted[0].toLocaleDateString('id-ID', options)} - ${sorted[sorted.length - 1].toLocaleDateString('id-ID', options)}`;
        }

        return "";
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
                        intersect: false,
                        callbacks: {
                            title: function(tooltipItems) {
                                const index = tooltipItems[0].dataIndex;
                                const label = tooltipItems[0].chart.data.labels[index];
                                const tanggal = tugas.dates[label] || evaluasi.dates[label] || tryout.dates[label];

                                if (interval === 'monthly') {
                                    return label;
                                }

                                const tanggalFormat = formatTanggalID(tanggal, interval);
                                return `${label} (${tanggalFormat})`;
                            }
                        }
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
