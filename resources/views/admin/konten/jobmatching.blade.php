@extends('admin.main.sidebar')

@section('content')
<main class="p-6">
    <div class="p-6 bg-white shadow rounded">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold mb-4">Daftar Lowongan Job Matching</h2>
            <a href="{{ route('admin.job-matching.create') }}" class="bg-[#0A58CA] text-white px-3 py-2 rounded hover:bg-blue-600 mb-4 inline-block">+ Tambah Lowongan</a>
        </div>

        <table class="w-full text-left border">
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
                                <a href="{{ route('admin.job-matching.pelamar', $job->id) }}" class=" hover:underline">
                                    {{ $job->posisi }}
                                </a>
                            </td>
                            <td class="px-4 py-2">{{ $job->nama_perusahaan }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-white rounded {{ $job->status == 'terbuka' ? 'bg-green-500' : 'bg-gray-500' }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $job->job_applications_count }} pelamar</td>
                            <td class="px-4 py-2 space-x-1">
                                <a href="{{ route('admin.job-matching.edit', $job->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('admin.job-matching.destroy', $job->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
</main>
@endsection
