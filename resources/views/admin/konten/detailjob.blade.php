@extends('admin.main.sidebar')

@section('content')
<main class="p-6">
    <div class="bg-white p-6 rounded shadow mb-6">
        <a href="{{ route('admin.job-matching.index') }}" class="inline-block mb-2 text-white bg-[#0A58CA] px-4 py-2 rounded">
            Kembali
        </a>
        <h2 class="text-xl font-semibold mb-2">{{ $job->posisi }}</h2>
        <p class="mb-1"><strong>Perusahaan:</strong> {{ $job->nama_perusahaan }}</p>
        <p class="mb-1"><strong>Status:</strong> {{ ucfirst($job->status) }}</p>

        {{-- Tampilkan bidang --}}
        <p class="mb-1"><strong>Bidang:</strong> {{ $job->bidang }}</p>

        {{-- Tampilkan kualifikasi sertifikat --}}
        <p class="mb-3">
            <strong>Kualifikasi Sertifikat:</strong>
            {{ $job->butuh_sertifikat ? 'Wajib memiliki sertifikat' : 'Tidak wajib memiliki sertifikat' }}
        </p>

        <p class="mb-3"><strong>Deskripsi:</strong> {{ $job->deskripsi }}</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">Daftar Pelamar</h3>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($applicants->isEmpty())
            <p>Tidak ada pelamar untuk lowongan ini.</p>
        @else
            <table class="w-full text-sm text-left border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Kelas</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Pesan Interview</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applicants as $app)
                    <tr class="border-t align-top">
                        <td class="px-4 py-2">{{ $app->user->nama_lengkap }}</td>
                        <td class="px-4 py-2">{{ $app->user->kelas }}</td>
                        <td class="px-4 py-2">{{ $app->user->email }}</td>
                        <td class="px-4 py-2">{{ ucfirst($app->status) }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600">
                            {{ $app->interview_message ?? '-' }}
                        </td>
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.job-matching.application.update', $app->id) }}" method="POST">
                                @csrf
                                <select name="status" class="text-sm border rounded px-2 py-1 mb-1 w-full">
                                    <option value="diajukan" {{ $app->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                    <option value="diproses" {{ $app->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="lolos" {{ $app->status == 'lolos' ? 'selected' : '' }}>Lolos</option>
                                    <option value="ditolak" {{ $app->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <textarea name="interview_message" rows="2" class="w-full border rounded p-1 text-sm mb-1" placeholder="Pesan interview (opsional)">{{ $app->interview_message }}</textarea>
                                <button type="submit" class="bg-blue-500 text-white text-sm px-3 py-1 rounded hover:bg-blue-600 w-full">
                                    Simpan
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</main>
@endsection
