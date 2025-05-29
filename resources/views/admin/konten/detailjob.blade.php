@extends('admin.main.sidebar')

@section('content')
<main class="p-6">
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-xl font-semibold mb-2">{{ $job->posisi }}</h2>
        <p class="mb-1"><strong>Perusahaan:</strong> {{ $job->nama_perusahaan }}</p>
        <p class="mb-1"><strong>Status:</strong> {{ ucfirst($job->status) }}</p>
        <p class="mb-3"><strong>Deskripsi:</strong> {{ $job->deskripsi }}</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">Daftar Pelamar</h3>
        @if($applicants->isEmpty())
            <p>Tidak ada pelamar untuk lowongan ini.</p>
        @else
            <table class="w-full text-sm text-left border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Kelas</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Status Lamaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applicants as $app)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $app->user->nama_lengkap }}</td>
                            <td class="px-4 py-2">{{ $app->user->kelas }}</td>
                            <td class="px-4 py-2">{{ $app->user->email }}</td>
                            <td class="px-4 py-2">{{ ucfirst($app->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</main>
@endsection
