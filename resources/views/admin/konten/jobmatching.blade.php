@extends('admin.main.sidebar')

@section('content')
<main class="p-4 sm:p-6">
    <div class="bg-white shadow rounded p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
            <h2 class="text-lg sm:text-xl font-semibold">Daftar Lowongan Job Matching</h2>
            <a href="{{ route('admin.job-matching.create') }}" class="bg-[#0A58CA] text-white px-3 py-2 rounded hover:bg-blue-600 text-sm sm:text-base w-full sm:w-auto text-center">+ Tambah Lowongan</a>
        </div>

        <!-- Table Responsive Wrapper -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm sm:text-base text-left border border-gray-200 min-w-[640px]">
                <thead>
                    <tr class="bg-[#0A58CA] text-white">
                        <th class="px-4 py-2">Posisi</th>
                        <th class="px-4 py-2">Perusahaan</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Jumlah Pelamar</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.job-matching.pelamar', $job->id) }}" class="hover:underline text-blue-600">
                                    {{ $job->posisi }}
                                </a>
                            </td>
                            <td class="px-4 py-2">{{ $job->nama_perusahaan }}</td>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
