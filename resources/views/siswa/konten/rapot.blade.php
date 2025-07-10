@extends('siswa.main.sidebar')

@php
    $bobotTugas = 0.3;
    $bobotEvaluasi = 0.3;
    $bobotTryout = 0.4;

    $nilaiList = [];
    $totalBobot = 0;

    if (!is_null($rataTugas)) {
        $nilaiList[] = $rataTugas * $bobotTugas;
        $totalBobot += $bobotTugas;
    }
    if (!is_null($rataEvaluasi)) {
        $nilaiList[] = $rataEvaluasi * $bobotEvaluasi;
        $totalBobot += $bobotEvaluasi;
    }
    if (!is_null($rataTryout)) {
        $nilaiList[] = $rataTryout * $bobotTryout;
        $totalBobot += $bobotTryout;
    }

    $rataKeseluruhan = count($nilaiList) > 0 ? round(array_sum($nilaiList) / $totalBobot) : '-';

    if ($rataKeseluruhan === '-') {
        $statusKelulusan = '-';
        $warna = 'gray';
    } elseif ($rataKeseluruhan > 65) {
        $statusKelulusan = 'Lulus';
        $warna = 'green';
    } elseif ($rataKeseluruhan >= 60) {
        $statusKelulusan = 'Beresiko';
        $warna = 'yellow';
    } else {
        $statusKelulusan = 'Tidak Lulus';
        $warna = 'red';
    }

    function status($nilai) {
        return $nilai >= 75 ? 'Baik' : 'Perlu Perbaikan';
    }
@endphp

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
            <div class="bg-white rounded-lg shadow p-6 flex flex-col h-full">            
                <div class="flex justify-between items-center mb-4">
                    <p class="text-sm md:text-lg font-semibold">Prediksi Kelulusan</p>
                </div>

                @php
                    $warnaBulatan = 'bg-gray-400';
                    $warnaTeks = 'text-gray-700';
                    $persen = $nilaiPersen ?? 0;
                    $saran = 'Belum ada data prediksi.';

                    if ($hasilPrediksi == 'Lulus') {
                        $warnaBulatan = 'bg-green-600';
                        $warnaTeks = 'text-green-600';
                        $saran = 'Pertahankan konsistensi belajar agar hasil tetap optimal.';
                    } elseif ($hasilPrediksi == 'Beresiko') {
                        $warnaBulatan = 'bg-yellow-500';
                        $warnaTeks = 'text-yellow-600';
                        $saran = 'Tingkatkan konsistensi belajar dan konsultasikan dengan tutor.';
                    } elseif ($hasilPrediksi == 'Tidak Lulus') {
                        $warnaBulatan = 'bg-red-600';
                        $warnaTeks = 'text-red-600';
                        $saran = 'Segera evaluasi proses belajar dan minta bantuan mentor.';
                    }
                @endphp

                <div class="flex justify-around items-center mb-4">
                    <div id="nilaiPersenBox" class="{{ $warnaBulatan }} text-white rounded-full w-24 h-24 flex items-center justify-center text-xl md:text-2xl font-bold">
                        {{ $persen }}%
                    </div>
                    <p id="hasilPrediksiTeks" class="{{ $warnaTeks }} font-medium md:text-xl">
                        {{ $hasilPrediksi }}
                    </p>
                </div>

                <button id="btnCekPrediksi" class="bg-[#0A58CA] w-full text-white px-4 py-2 rounded-full text-sm md:text-base hover:bg-blue-600 transition flex items-center justify-center">
                    <span id="textCek">Cek Prediksi</span>
                    <svg id="loadingIcon" class="animate-spin ml-2 h-4 w-4 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </button>

                @if ($hanyaSatuNilai)
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-3 my-4 rounded-md text-sm md:text-base">
                        <strong>Catatan:</strong> Saat ini prediksi hanya dihitung berdasarkan satu jenis nilai. Untuk hasil prediksi yang lebih akurat, lengkapi nilai dari Tugas, Evaluasi, dan Tryout.
                    </div>
                @endif

                @if (!$hanyaSatuNilai && $rataTugas > 0 && $rataEvaluasi > 0 && $rataTryout > 0)
                    <div class="bg-gray-100 p-3 mt-3 rounded-md text-sm md:text-base text-gray-700">
                        <p><strong>Saran:</strong> <span id="saranText">{{ $saran }}</span></p>
                    </div>
                @endif
            </div>
        </section>

    </div>

    <section class="my-6 w-full overflow-x-auto">
        <div class="bg-white rounded-lg shadow min-w-[600px] md:w-full">
            <p class="text-xl px-6 py-5 font-semibold">Rapor dan Nilai Saya</p>
            <table class="w-full">
                <thead>
                    <tr class="text-gray-600 bg-blue-50">
                        <th class="py-3 px-6 text-left">Tipe Penilaian</th>
                        <th class="py-3 px-6 text-center">Nilai</th>
                        <th class="py-3 px-6 text-center">Keterangan</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="py-3 px-6">Tugas</td>
                        <td class="py-3 px-6 text-center">{{ $rataTugas ?? '-' }}</td>
                        <td class="py-3 px-6 text-center text-{{ $rataTugas >= 75 ? 'green' : ($rataTugas >= 60 ? 'yellow' : 'red') }}-600 font-medium">
                            {{ $statusTugas }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('siswa.nilai.detail', ['tipe' => 'tugas']) }}" class="text-[#0A58CA] hover:underline">Lihat</a>
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-3 px-6">Evaluasi</td>
                        <td class="py-3 px-6 text-center">{{ $rataEvaluasi ?? '-' }}</td>
                        <td class="py-3 px-6 text-center text-{{ $rataEvaluasi >= 75 ? 'green' : ($rataEvaluasi >= 60 ? 'yellow' : 'red') }}-600 font-medium">
                            {{ $statusEvaluasi }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('siswa.nilai.detail', ['tipe' => 'evaluasi_mingguan']) }}" class="text-[#0A58CA] hover:underline">Lihat</a>
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-3 px-6">Tryout</td>
                        <td class="py-3 px-6 text-center">{{ $rataTryout ?? '-' }}</td>
                        <td class="py-3 px-6 text-center text-{{ $rataTryout >= 75 ? 'green' : ($rataTryout >= 60 ? 'yellow' : 'red') }}-600 font-medium">
                            {{ $statusTryout }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('siswa.nilai.detail', ['tipe' => 'tryout']) }}" class="text-[#0A58CA] hover:underline">Lihat</a>
                        </td>
                    </tr>
                    <tr class="border-t bg-gray-100">
                        <td class="py-3 px-6 font-semibold">Rata-rata Keseluruhan</td>
                        <td class="py-3 px-6 text-center font-semibold text-[#0A58CA]">
                            {{ $nilaiPersen }}
                        </td>
                        <td class="py-3 px-6 text-center font-semibold text-{{ $warna }}-600">
                            {{ $statusKelulusan }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="p-6 flex justify-end">
                <a href="{{ route('siswa.unduh.rapor') }}">
                    <button class="bg-[#0A58CA] text-white px-6 py-2 rounded-lg shadow-md hover:bg-[#084298]">
                        Unduh Rapor
                    </button>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.getElementById('btnCekPrediksi').addEventListener('click', function () {
        const btn = this;
        const loading = document.getElementById('loadingIcon');
        const text = document.getElementById('textCek');

        loading.classList.remove('hidden');
        text.textContent = 'Memproses...';
        btn.disabled = true;

        fetch("{{ route('siswa.refresh.prediksi') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({}),
        })
        .then(res => res.json())
        .then(data => {
            const persenBox = document.getElementById('nilaiPersenBox');
            const hasilTeks = document.getElementById('hasilPrediksiTeks');
            const saranList = document.getElementById('saranList');

            persenBox.textContent = data.persen + '%';

            hasilTeks.textContent = data.hasil;
            hasilTeks.className = 'font-medium text-lg text-left';
            if (data.hasil === 'Lulus') {
                hasilTeks.classList.add('text-green-500');
                saranList.innerHTML = '<li>Pertahankan konsistensi belajar</li>';
            } else if (data.hasil === 'Beresiko') {
                hasilTeks.classList.add('text-yellow-500');
                saranList.innerHTML = '<li>Latihan soal lebih rutin</li><li>Perbanyak mendengarkan percakapan Jepang</li>';
            } else {
                hasilTeks.classList.add('text-red-500');
                saranList.innerHTML = '<li>Latihan soal lebih rutin</li><li>Perbanyak mendengarkan percakapan Jepang</li>';
            }
        })
        .catch(err => {
            alert('Gagal mengambil prediksi. Coba lagi.');
            console.error(err);
        })
        .finally(() => {
            loading.classList.add('hidden');
            text.textContent = 'Cek Prediksi';
            btn.disabled = false;
        });
    });
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
            const currentDay = now.getDay();
            const distanceFromMonday = (currentDay + 6) % 7;
            const monday = new Date(now);
            monday.setDate(now.getDate() - distanceFromMonday);
            monday.setHours(0, 0, 0, 0);

            for (let i = 0; i < 6; i++) {
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
                const monday = new Date(now);
                const day = now.getDay();
                const distanceFromMonday = (day + 6) % 7;
                monday.setDate(now.getDate() - distanceFromMonday);
                monday.setHours(0, 0, 0, 0);
                const endOfWeek = new Date(monday);
                endOfWeek.setDate(monday.getDate() + 6);

                if (date < monday || date > endOfWeek) return;

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
