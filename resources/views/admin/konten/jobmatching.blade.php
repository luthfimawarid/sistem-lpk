@extends('admin.main.sidebar')

@section('content')
<main class="p-4 sm:p-6">
    <div class="bg-white shadow rounded p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
            <h2 class="text-lg sm:text-xl font-semibold">Daftar Lowongan Job Matching</h2>
            <a href="{{ route('admin.job-matching.create') }}" class="bg-[#0A58CA] text-white px-3 py-2 rounded hover:bg-blue-600 text-sm sm:text-base w-full sm:w-auto text-center">+ Tambah Lowongan</a>
        </div>

        <!-- Filter & Sort Form -->
        <form method="GET" class="flex flex-wrap items-center gap-2 mb-4 text-sm">
            <label for="sort_by" class="text-gray-700">Filter berdasarkan:</label>
            <select name="sort_by" id="sort_by" class="border rounded px-2 py-1" onchange="this.form.submit()">
                <option value="posisi" {{ $sortField == 'posisi' ? 'selected' : '' }}>Nama Pekerjaan</option>
                <option value="bidang" {{ $sortField == 'bidang' ? 'selected' : '' }}>Bidang</option>
                <option value="lokasi" {{ $sortField == 'lokasi' ? 'selected' : '' }}>Lokasi</option>
                <option value="nama_perusahaan" {{ $sortField == 'nama_perusahaan' ? 'selected' : '' }}>Perusahaan</option>
            </select>

            @php
                $options = collect([]);
                if ($sortField == 'posisi') $options = $posisiOptions;
                elseif ($sortField == 'bidang') $options = $bidangOptions;
                elseif ($sortField == 'lokasi') $options = $lokasiOptions;
                elseif ($sortField == 'nama_perusahaan') $options = $perusahaanOptions;
            @endphp

            <select name="filter_value" id="filter_value" class="border rounded px-2 py-1">
                <option value="">-- Semua --</option>
                @foreach($options as $option)
                    <option value="{{ $option }}" {{ $sortValue == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Terapkan</button>
        </form>

        <!-- Table Responsive Wrapper -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm sm:text-base text-left border border-gray-200 min-w-[800px]">
                <thead>
                    <tr class="bg-[#0A58CA] text-white">
                        <th class="px-4 py-2">Posisi</th>
                        <th class="px-4 py-2">Perusahaan</th>
                        <th class="px-4 py-2">Bidang</th>
                        <th class="px-4 py-2">Lokasi</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Jumlah Pelamar</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.job-matching.pelamar', $job->id) }}" class="hover:underline text-blue-600">
                                    {{ $job->posisi }}
                                </a>
                            </td>
                            <td class="px-4 py-2">{{ $job->nama_perusahaan }}</td>
                            <td class="px-4 py-2">{{ $job->bidang }}</td>
                            <td class="px-4 py-2">{{ $job->lokasi }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-white text-xs sm:text-sm rounded {{ $job->status == 'terbuka' ? 'bg-green-500' : 'bg-gray-500' }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $job->job_applications_count }} pelamar</td>
                            <td class="px-4 py-2 space-y-1 sm:space-y-0 sm:space-x-1 flex flex-col sm:flex-row">
                                <a href="{{ route('admin.job-matching.edit', $job->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 text-center text-sm">Edit</a>
                                <form action="{{ route('admin.job-matching.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-sm w-full text-center">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">Tidak ada data lowongan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
