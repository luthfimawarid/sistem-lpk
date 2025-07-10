@extends('siswa.main.sidebar')

@section('content')

<main class="p-6 bg-gray-100 min-h-screen">
    <!-- Ujian Akhir -->
    @php $ujianAkhir = $tugas->where('tipe', 'ujian_akhir'); @endphp
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-4">Ujian Akhir ({{ $ujianAkhir->count() }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($ujianAkhir as $item)
                @php
                    $userStatus = $item->tugasUser->where('user_id', Auth::id())->first();
                    $isSelesai = $userStatus && $userStatus->status === 'selesai';
                    $link = $isSelesai 
                        ? route('siswa.tugas.ujian.selesai', ['id' => $item->id]) 
                        : route('siswa.tugas.ujian.soal', ['id' => $item->id, 'nomor' => 1]);
                @endphp

                <a href="{{ $link }}" class="block bg-white rounded-lg shadow p-4 text-center hover:shadow-md transition h-full">
                    <img src="{{ $item->cover ? asset('storage/cover_tugas/'.$item->cover) : '/logo.png' }}" class="mx-auto rounded-md h-40 object-cover" alt="{{ $item->judul }}">
                    <p class="mt-2 font-medium text-blue-600">{{ $item->judul }}</p>
                    <p class="text-sm text-gray-600">Deadline: {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('d M Y') : '-' }}</p>
                    <p class="text-sm {{ $isSelesai ? 'text-green-600' : 'text-red-600' }}">
                        Status: {{ $isSelesai ? 'Selesai' : 'Belum Selesai' }}
                    </p>
                </a>
            @empty
                <p class="text-gray-500">Belum ada ujian akhir.</p>
            @endforelse
        </div>
    </section>

    <!-- Tugas -->
    @php $tugasList = $tugas->where('tipe', 'tugas'); @endphp
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-4">Tugas ({{ $tugasList->count() }})</h2>
        <div class="flex flex-col gap-4 lg:flex-row lg:overflow-x-auto px-1">
            @forelse ($tugasList as $item)
            <a href="{{ route('siswa.tugas.detail', $item->id) }}" class="flex-shrink-0 w-full lg:w-64">
                <div class="bg-white rounded-lg shadow p-4 text-center h-full">
                    <img src="{{ asset('/logo.png') }}" alt="Evaluasi" class="mx-auto rounded-md h-40 object-cover">
                    <p class="mt-2 font-medium text-blue-600">{{ $item->judul }}</p>
                    <p class="text-sm text-gray-600">Deadline: {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('d M Y') : '-' }}</p>
                    @php
                        $userStatus = $item->tugasUser->where('user_id', Auth::id())->first();
                    @endphp
                    <p class="text-sm {{ $userStatus && $userStatus->status == 'selesai' ? 'text-green-600' : 'text-red-600' }}">
                        Status: {{ $userStatus && $userStatus->status == 'selesai' ? 'Selesai' : 'Belum Selesai' }}
                    </p>
                </div>
            </a>
            @empty
            <p class="text-gray-500">Belum ada tugas.</p>
            @endforelse
        </div>
    </section>

    <!-- Kuis -->
    @php $kuisList = $tugas->where('tipe', 'kuis'); @endphp
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-4">Kuis Harian ({{ $kuisList->count() }})</h2>
        <div class="flex flex-col gap-4 lg:flex-row lg:overflow-x-auto px-1">
            @forelse ($kuisList as $item)
            <a href="{{ route('siswa.tugas.detail', $item->id) }}" class="flex-shrink-0 w-full lg:w-64">
                <div class="bg-white rounded-lg shadow p-4 text-center h-full">
                    <img src="{{ asset('/logo.png') }}" alt="Evaluasi" class="mx-auto rounded-md h-40 object-cover">
                    <p class="mt-2 font-medium text-blue-600">{{ $item->judul }}</p>
                    <p class="text-sm text-gray-600">Deadline: {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('d M Y') : '-' }}</p>
                    @php
                        $tugasUser = $item->tugasUser->first(); // Sudah difilter by user_id di controller
                    @endphp
                    <p class="text-sm {{ $tugasUser && $tugasUser->status == 'selesai' ? 'text-green-600' : 'text-red-600' }}">
                        Status: {{ ucfirst(str_replace('_', ' ', $tugasUser->status ?? 'belum_selesai')) }}
                    </p>
                </div>
            </a>
            @empty
            <p class="text-gray-500">Belum ada kuis.</p>
            @endforelse
        </div>
    </section>

    <!-- Evaluasi Mingguan -->
    @php $evaluasiList = $tugas->where('tipe', 'evaluasi_mingguan'); @endphp
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-4">Evaluasi Mingguan ({{ $evaluasiList->count() }})</h2>
        <div class="flex flex-col gap-4 lg:flex-row lg:overflow-x-auto px-1">
            @forelse ($evaluasiList as $item)
            <a href="{{ route('siswa.tugas.detail', $item->id) }}" class="flex-shrink-0 w-full lg:w-64">
                <div class="bg-white rounded-lg shadow p-4 text-center h-full">
                    <img src="{{ asset('/logo.png') }}" alt="Evaluasi" class="mx-auto rounded-md h-40 object-cover">
                    <p class="mt-2 font-medium text-blue-600">{{ $item->judul }}</p>
                    <p class="text-sm text-gray-600">Deadline: {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('d M Y') : '-' }}</p>
                    @php
                        $tugasUser = $item->tugasUser->first(); // Sudah difilter by user_id di controller
                    @endphp
                    <p class="text-sm {{ $tugasUser && $tugasUser->status == 'selesai' ? 'text-green-600' : 'text-red-600' }}">
                        Status: {{ ucfirst(str_replace('_', ' ', $tugasUser->status ?? 'belum_selesai')) }}
                    </p>
                </div>
            </a>
            @empty
            <p class="text-gray-500">Belum ada evaluasi mingguan.</p>
            @endforelse
        </div>
    </section>

    <!-- Tryout -->
    @php $tryoutList = $tugas->where('tipe', 'tryout'); @endphp
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-4">Tryout ({{ $tryoutList->count() }})</h2>
        <div class="flex flex-col gap-4 lg:flex-row lg:overflow-x-auto px-1">
            @forelse ($tryoutList as $item)
            <a href="{{ route('siswa.tugas.detail', $item->id) }}" class="flex-shrink-0 w-full lg:w-64">
                <div class="bg-white rounded-lg shadow p-4 text-center h-full">
                    <img src="{{ asset('/logo.png') }}" alt="Evaluasi" class="mx-auto rounded-md h-40 object-cover">
                    <p class="mt-2 font-medium text-blue-600">{{ $item->judul }}</p>
                    <p class="text-sm text-gray-600">Deadline: {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('d M Y') : '-' }}</p>
                    @php
                        $tugasUser = $item->tugasUser->first(); // Sudah difilter by user_id di controller
                    @endphp
                    <p class="text-sm {{ $tugasUser && $tugasUser->status == 'selesai' ? 'text-green-600' : 'text-red-600' }}">
                        Status: {{ ucfirst(str_replace('_', ' ', $tugasUser->status ?? 'belum_selesai')) }}
                    </p>
                </div>
            </a>
            @empty
            <p class="text-gray-500">Belum ada tryout.</p>
            @endforelse
        </div>
    </section>
</main>

@endsection
