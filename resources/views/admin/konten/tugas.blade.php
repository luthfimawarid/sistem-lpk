@extends('admin.main.sidebar')

@section('content')

<main class="p-6 bg-gray-100 min-h-screen">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <!-- Filter Form -->
        <form method="GET" class="flex flex-wrap gap-2 items-center text-sm">
            <label for="filter_by" class="text-gray-700">Filter berdasarkan:</label>
            <select name="filter_by" id="filter_by" class="border rounded px-2 py-1" onchange="this.form.submit()">
                <option value="bidang" {{ $filterField == 'bidang' ? 'selected' : '' }}>Bidang</option>
                <option value="tipe" {{ $filterField == 'tipe' ? 'selected' : '' }}>Jenis Tugas</option>
                <option value="deadline" {{ $filterField == 'deadline' ? 'selected' : '' }}>Kadaluarsa</option>
            </select>

            @php
                $options = collect([]);
                if ($filterField == 'bidang') $options = $bidangOptions;
                elseif ($filterField == 'tipe') $options = $tipeOptions;
                elseif ($filterField == 'deadline') $options = $deadlineOptions;
            @endphp

            <select name="filter_value" id="filter_value" class="border rounded px-2 py-1">
                <option value="">-- Semua --</option>
                @foreach($options as $option)
                    <option value="{{ $option }}" {{ $filterValue == $option ? 'selected' : '' }}>
                        {{ $filterField == 'deadline' ? \Carbon\Carbon::parse($option)->format('d M Y') : ucfirst($option) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Terapkan</button>

            @if(request()->has('filter_by') || request()->has('filter_value'))
                <a href="{{ route('tugas.index') }}" class="text-blue-600 underline ml-2">Reset</a>
            @endif
        </form>

        <!-- Tombol Tambah Tugas -->
        <a href="{{ route('tugas.create') }}" class="bg-[#0A58CA] text-white px-4 py-2 rounded-md hover:bg-blue-600 transition whitespace-nowrap">
            Tambah Tugas
        </a>
    </div>

    <!-- Ujian Akhir -->
    @php $ujianAkhir = $tugas->where('tipe', 'ujian_akhir'); @endphp
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-4">Ujian Akhir ({{ $ujianAkhir->count() }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($ujianAkhir as $item)
            <div class="bg-white rounded-lg shadow p-4 text-center hover:shadow-md transition h-full flex flex-col">
                <!-- Bagian yang bisa diklik -->
                <a href="{{ route('admin.ujian.detail', $item->id) }}" class="flex-grow">
                    <img src="{{ asset('/logo.png') }}" alt="Evaluasi" class="mx-auto rounded-md h-40 object-cover">
                    <p class="mt-2 font-medium text-black">{{ $item->judul }}</p>
                    <p class="text-sm text-gray-500">Bidang: {{ ucfirst($item->bidang) }}</p>
                    <p class="text-sm text-red-600">Deadline: {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('d M Y') : '-' }}</p>
                </a>
                
                <!-- Tombol Edit dan Hapus di bagian bawah card -->
                <div class="flex justify-center gap-2 mt-4">
                    <a href="{{ route('tugas.edit', $item->id) }}" 
                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"
                    onclick="event.stopPropagation()">Edit</a>
                    <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" 
                        onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                        onclick="event.stopPropagation()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-gray-500">Belum ada ujian akhir.</p>
            @endforelse
        </div>
    </section>

    <!-- Tugas -->
    @php $tugasList = $tugas->where('tipe', 'tugas'); @endphp
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-4">Tugas ({{ $tugasList->count() }})</h2>
        <div class="flex flex-col gap-4 lg:flex-row lg:overflow-x-auto lg:space-x-4 px-1">
            @forelse ($tugasList as $item)
            <div class="flex-shrink-0 w-full lg:w-64">
                <div class="relative group">
                    <div class="bg-white rounded-lg shadow p-4 text-center group-hover:shadow-lg transition duration-200">
                        {{-- Seluruh kartu bisa diklik ke halaman detail --}}
                        <a href="{{ route('tugas.pengumpulan', $item->id) }}" class="block">
                            <img src="{{ asset('/logo.png') }}" alt="Evaluasi" class="mx-auto rounded-md h-40 object-cover">
                            <p class="mt-2 font-medium">{{ $item->judul }}</p>
                            <p class="text-sm text-gray-500">Bidang: {{ ucfirst($item->bidang) }}</p>
                            <p class="text-sm text-red-600">
                                Deadline: {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('d M Y') : '-' }}
                            </p>
                        </a>

                        {{-- Tombol Edit dan Hapus --}}
                        <div class="flex justify-center gap-2 mt-4">
                            <a href="{{ route('tugas.edit', $item->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Edit</a>
                            <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-500">Belum ada tugas.</p>
            @endforelse
        </div>
    </section>

    <!-- Kuis -->
    @php $kuisList = $tugas->where('tipe', 'kuis'); @endphp
    <section>
        <h2 class="text-2xl font-semibold mb-4">Kuis Harian ({{ $kuisList->count() }})</h2>
        <div class="flex flex-col gap-4 lg:flex-row lg:overflow-x-auto lg:space-x-4 px-1">
            @forelse ($kuisList as $item)
            <div class="flex-shrink-0 w-full lg:w-64">
                <div class="relative group">
                    <div class="bg-white rounded-lg shadow p-4 text-center group-hover:shadow-lg transition duration-200">
                        {{-- Seluruh kartu bisa diklik ke halaman detail --}}
                        <a href="{{ route('admin.kuis.detail', $item->id) }}" class="block">
                            <img src="{{ asset('/logo.png') }}" alt="Evaluasi" class="mx-auto rounded-md h-40 object-cover">
                            <p class="mt-2 font-medium">{{ $item->judul }}</p>
                            <p class="text-sm text-gray-500">Bidang: {{ ucfirst($item->bidang) }}</p>
                            <p class="text-sm text-red-600">
                                Deadline: {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('d M Y') : '-' }}
                            </p>
                        </a>

                        {{-- Tombol Edit dan Hapus --}}
                        <div class="flex justify-center gap-2 mt-4">
                            <a href="{{ route('tugas.edit', $item->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Edit</a>
                            <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            @empty
            <p class="text-gray-500">Belum ada kuis.</p>
            @endforelse
        </div>
    </section>

    <!-- Evaluasi Mingguan -->
    @php $evaluasiList = $tugas->where('tipe', 'evaluasi_mingguan'); @endphp
    <section class="mt-8">
        <h2 class="text-2xl font-semibold mb-4">Evaluasi Mingguan ({{ $evaluasiList->count() }})</h2>
        <div class="flex flex-col gap-4 lg:flex-row lg:overflow-x-auto lg:space-x-4 px-1">
            @forelse ($evaluasiList as $item)
            <div class="flex-shrink-0 w-full lg:w-64">
                <div class="relative group">
                    <div class="bg-white rounded-lg shadow p-4 text-center group-hover:shadow-lg transition duration-200">
                        {{-- Seluruh kartu bisa diklik ke halaman detail --}}
                        <a href="{{ route('tugas.pengumpulan', $item->id) }}" class="block">
                            <img src="{{ asset('/logo.png') }}" alt="Evaluasi" class="mx-auto rounded-md h-40 object-cover">
                            <p class="mt-2 font-medium">{{ $item->judul }}</p>
                            <p class="text-sm text-gray-500">Bidang: {{ ucfirst($item->bidang) }}</p>
                            <p class="text-sm text-red-600">
                                Deadline: {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('d M Y') : '-' }}
                            </p>
                        </a>

                        {{-- Tombol Edit dan Hapus --}}
                        <div class="flex justify-center gap-2 mt-4">
                            <a href="{{ route('tugas.edit', $item->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Edit</a>
                            <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            @empty
            <p class="text-gray-500">Belum ada evaluasi mingguan.</p>
            @endforelse
        </div>
    </section>

    <!-- Tryout -->
    @php $tryoutList = $tugas->where('tipe', 'tryout'); @endphp
    <section class="mt-8">
        <h2 class="text-2xl font-semibold mb-4">Tryout ({{ $tryoutList->count() }})</h2>
        <div class="flex flex-col gap-4 lg:flex-row lg:overflow-x-auto lg:space-x-4 px-1">
            @forelse ($tryoutList as $item)
            <div class="flex-shrink-0 w-full lg:w-64">
                <div class="relative group">
                    <div class="bg-white rounded-lg shadow p-4 text-center group-hover:shadow-lg transition duration-200">
                        {{-- Seluruh kartu bisa diklik ke halaman detail --}}
                        <a href="{{ route('admin.tryout.detail', $item->id) }}" class="block">
                            <img src="{{ asset('/logo.png') }}" alt="Evaluasi" class="mx-auto rounded-md h-40 object-cover">
                            <p class="mt-2 font-medium">{{ $item->judul }}</p>
                            <p class="text-sm text-gray-500">Bidang: {{ ucfirst(string: $item->bidang) }}</p>
                            <p class="text-sm text-red-600">
                                Deadline: {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('d M Y') : '-' }}
                            </p>
                        </a>

                        {{-- Tombol Edit dan Hapus --}}
                        <div class="flex justify-center gap-2 mt-4">
                            <a href="{{ route('tugas.edit', $item->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Edit</a>
                            <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-500">Belum ada tryout.</p>
            @endforelse
        </div>
    </section>

</main>

@endsection
