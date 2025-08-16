@extends('siswa.main.sidebar')

@section('content')
<div class="p-6 md:p-10 bg-blue-50 min-h-screen">
    <div class="flex flex-col md:flex-row gap-4">
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

    <section class="w-full md:w-[32.5%]">
        <div class="bg-white rounded-lg shadow p-6 flex flex-col h-full">
            <div class="flex justify-between items-center mb-4">
                <p class="text-sm md:text-lg font-semibold">Prediksi Kelulusan</p>
            </div>

            <div class="flex justify-around items-center mb-4">
                <div id="nilaiPersenBox" class="{{ $warnaBox }} text-white rounded-full w-24 h-24 flex items-center justify-center text-xl md:text-2xl font-bold">
                    {{ $persenTampil ?? '0' }}%
                </div>
                <p id="hasilPrediksiTeks" class="{{ $warnaKelulusan }} font-medium md:text-xl">
                    {{ $hasilPrediksi }}
                </p>
            </div>

            <button id="btnCekPrediksi" class="bg-[#0A58CA] w-full text-white px-4 py-2 rounded-full text-sm md:text-base hover:bg-blue-600 transition flex items-center justify-center">
                <span id="textCek">Cek Prediksi</span>
                <svg id="loadingIcon" class="animate-spin ml-2 h-4 w-4 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-65" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
            </button>

            {{-- Menggunakan logika kondisional yang lebih sederhana --}}
            @if ($saran)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-3 my-4 rounded-md text-sm sm:text-base">
                    <strong>Catatan:</strong> {{ $saran }}
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
                        <td class="py-3 px-6 text-center">{{ number_format($rataTugas, 0) ?? '-' }}</td>
                        <td class="py-3 px-6 text-center text-{{ $rataTugas >= 65 ? 'green' : ($rataTugas >= 60 ? 'yellow' : 'red') }}-600 font-medium">
                            {{ $statusTugas }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('siswa.nilai.detail', ['tipe' => 'tugas']) }}" class="text-[#0A58CA] hover:underline">Lihat</a>
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-3 px-6">Evaluasi</td>
                        <td class="py-3 px-6 text-center">{{ number_format($rataEvaluasi, 0) ?? '-' }}</td>
                        <td class="py-3 px-6 text-center text-{{ $rataEvaluasi >= 65 ? 'green' : ($rataEvaluasi >= 60 ? 'yellow' : 'red') }}-600 font-medium">
                            {{ $statusEvaluasi }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('siswa.nilai.detail', ['tipe' => 'evaluasi_mingguan']) }}" class="text-[#0A58CA] hover:underline">Lihat</a>
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-3 px-6">Tryout</td>
                        <td class="py-3 px-6 text-center">{{ number_format($rataTryout, 0) ?? '-' }}</td>
                        <td class="py-3 px-6 text-center text-{{ $rataTryout >= 65 ? 'green' : ($rataTryout >= 60 ? 'yellow' : 'red') }}-600 font-medium">
                            {{ $statusTryout }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('siswa.nilai.detail', ['tipe' => 'tryout']) }}" class="text-[#0A58CA] hover:underline">Lihat</a>
                        </td>
                    </tr>
                    <tr class="border-t bg-gray-100">
                        <td class="py-3 px-6 font-semibold">Rata-rata Keseluruhan</td>
                        <td class="py-3 px-6 text-center font-semibold text-[#0A58CA]">
                            {{ $persenTampil ?? '-' }}
                        </td>
                        <td class="py-3 px-6 text-center font-semibold {{ $warnaKelulusan }}">
                            {{ $statusKelulusan }}
                        </td>
                        <td class="py-3 px-6 text-center"></td>
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
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('btnCekPrediksi');
    const loading = document.getElementById('loadingIcon');
    const text = document.getElementById('textCek');
    const persenBox = document.getElementById('nilaiPersenBox');
    const hasilTeks = document.getElementById('hasilPrediksiTeks');
    const saranText = document.getElementById('saranText');

    btn.addEventListener('click', () => {
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
            // Update persen dan hasil prediksi
            if (persenBox) {
                persenBox.textContent = data.persen + '%';
                persenBox.className = '';
                persenBox.classList.add('rounded-full', 'w-24', 'h-24', 'flex', 'items-center', 'justify-center', 'text-xl', 'md:text-2xl', 'font-bold');
                if (data.hasil === 'Lulus') {
                    persenBox.classList.add('bg-green-600', 'text-white');
                } else if (data.hasil === 'Beresiko') {
                    persenBox.classList.add('bg-yellow-500', 'text-white');
                } else {
                    persenBox.classList.add('bg-red-600', 'text-white');
                }
            }

            if (hasilTeks) {
                hasilTeks.textContent = data.hasil;
                hasilTeks.className = 'font-medium md:text-xl';
                if (data.hasil === 'Lulus') {
                    hasilTeks.classList.add('text-green-600');
                } else if (data.hasil === 'Beresiko') {
                    hasilTeks.classList.add('text-yellow-500');
                } else {
                    hasilTeks.classList.add('text-red-600');
                }
            }

            // Update saran
            if (saranText) {
                saranText.textContent = data.saran;
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

    // ===== Bagian Chart (nilaiTugas, nilaiEvaluasi, nilaiTryout) =====
    const nilaiTugas = @json($nilaiTugas);
    const nilaiEvaluasi = @json($nilaiEvaluasi);
    const nilaiTryout = @json($nilaiTryout);
    const tanggalTerdaftar = new Date("{{ $tanggalTerdaftar }}");
    const intervalSelect = document.getElementById('intervalSelect');
    let chartInstance = null;

    function getDayName(dateStr) {
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return days[new Date(dateStr).getDay()];
    }

    function getDefaultLabels(interval) {
        const result = [];
        const now = new Date();
        if (interval === 'daily') {
            const monday = new Date(now);
            const distanceFromMonday = (now.getDay() + 6) % 7;
            monday.setDate(now.getDate() - distanceFromMonday);
            for (let i = 0; i < 6; i++) {
                const d = new Date(monday);
                d.setDate(monday.getDate() + i);
                result.push(getDayName(d));
            }
        } else if (interval === 'weekly') {
            const start = new Date(tanggalTerdaftar);
            const current = new Date();
            const msPerWeek = 7 * 24 * 60 * 60 * 1000;
            const totalWeeks = Math.ceil((current - start) / msPerWeek);
            for (let i = 1; i <= totalWeeks; i++) result.push(`Minggu ke-${i}`);
        } else if (interval === 'monthly') {
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
        }
        return result;
    }

    function formatDataByInterval(data, interval) {
        const grouped = {};
        const labelMap = new Map();
        let index = 1;
        data.forEach(entry => {
            const date = new Date(entry.tanggal);
            let label = '';
            if (interval === 'daily') label = getDayName(date);
            else if (interval === 'weekly') label = `Minggu ke-${Math.floor((date - tanggalTerdaftar) / (7*24*60*60*1000)) + 1}`;
            else if (interval === 'monthly') {
                const monthYear = date.toLocaleString('id-ID', { month: 'long', year: 'numeric' });
                label = monthYear.charAt(0).toUpperCase() + monthYear.slice(1);
            }
            if (!grouped[label]) {
                grouped[label] = [];
                labelMap.set(label, index++);
            }
            grouped[label].push(entry.nilai);
        });
        const sortedLabels = Array.from(labelMap.entries()).sort((a,b)=>a[1]-b[1]).map(([label])=>label);
        const values = sortedLabels.map(label => {
            const arr = grouped[label];
            return Math.round(arr.reduce((a,b)=>a+b,0)/arr.length);
        });
        return { labels: sortedLabels, values };
    }

    function renderChart(interval) {
        const defaultLabels = getDefaultLabels(interval);
        const tugas = formatDataByInterval(nilaiTugas, interval);
        const evaluasi = formatDataByInterval(nilaiEvaluasi, interval);
        const tryout = formatDataByInterval(nilaiTryout, interval);

        const alignData = (labels, dataset) => labels.map(label => {
            const idx = dataset.labels.indexOf(label);
            return idx !== -1 ? dataset.values[idx] : null;
        });

        if (chartInstance) chartInstance.destroy();

        chartInstance = new Chart(document.getElementById('nilaiChart'), {
            type: 'line',
            data: {
                labels: defaultLabels,
                datasets: [
                    { label:'Tugas', data: alignData(defaultLabels,tugas), borderColor:'#0A58CA', backgroundColor:'rgba(10,88,202,0.2)', tension:0.4, spanGaps:true },
                    { label:'Evaluasi', data: alignData(defaultLabels,evaluasi), borderColor:'#FFCE56', backgroundColor:'rgba(255,206,86,0.2)', tension:0.4, spanGaps:true },
                    { label:'Tryout', data: alignData(defaultLabels,tryout), borderColor:'#FF6384', backgroundColor:'rgba(255,99,132,0.2)', tension:0.4, spanGaps:true },
                ]
            },
            options: {
                responsive:true,
                scales:{ y:{ beginAtZero:true } },
                plugins:{
                    legend:{ position:'top' }
                }
            }
        });
    }

    if (intervalSelect) {
        renderChart(intervalSelect.value);
        intervalSelect.addEventListener('change', () => renderChart(intervalSelect.value));
    }
});
</script>

@endsection