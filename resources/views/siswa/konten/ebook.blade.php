@extends('siswa.main.sidebar')

@section('content')
<main class="p-6">
        <!-- Title & Sort -->
        <div class="flex justify-between items-center mb-6">
            <h2 id="ebook-count" class="md:text-lg font-semibold my-2 md:my-0 md:order-1">
                {{ ucfirst($tipe) }} ({{ $materi->count() }})
            </h2>
            <!-- <button class="border-2 border-gray-400 font-semibold text-sm text-gray-400 px-4 flex items-center py-2 rounded-lg">
                Sort By
                <svg class="w-6 h-6 text-gray-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>
                </svg>
            </button> -->
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($materi as $item)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('storage/cover/' . $item->cover) }}" alt="Cover E-book" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ $item->judul }}</h3>
                        <p class="text-sm text-gray-600 mt-2">By {{ $item->author }}</p>
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ asset('storage/materi/' . $item->file) }}" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">Buka</a>
                            <a href="{{ asset('storage/materi/' . $item->file) }}" download class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm">Unduh</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center text-gray-500">
                    Belum ada materi.
                </div>
            @endforelse
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
