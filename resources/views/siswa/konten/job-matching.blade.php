@extends('siswa.main.sidebar')

@section('content')
<main class="p-4 sm:p-6">
    <div class="bg-white p-4 sm:p-6 rounded shadow">
        <h2 class="text-base sm:text-lg font-semibold mb-4">Daftar Lowongan Job Matching</h2>

        @if ($sertifikatLulus < 2)
            <p class="text-center text-gray-500 text-sm sm:text-base">
                Job Matching akan tersedia setelah kamu mendapatkan minimal 2 sertifikat lulus.
            </p>
        @else
            @if ($jobMatchings->isEmpty())
                <p class="text-center text-gray-500 text-sm sm:text-base">
                    Tidak ada lowongan tersedia saat ini.
                </p>
            @else
                <!-- Scrollable table wrapper on small screens -->
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm sm:text-base text-left">
                        <thead class="bg-blue-100 text-gray-800">
                            <tr>
                                <th class="py-2 px-4">Posisi</th>
                                <th class="py-2 px-4">Perusahaan</th>
                                <th class="py-2 px-4">Status Lamaran</th>
                                <th class="py-2 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobMatchings as $job)
                                <tr class="border-t">
                                    <td class="py-2 px-4">{{ $job->posisi }}</td>
                                    <td class="py-2 px-4">{{ $job->nama_perusahaan }}</td>
                                    <td class="py-2 px-4">
                                        @if (isset($jobApplications[$job->id]))
                                            <span class="px-2 py-1 text-white rounded
                                                {{ $jobApplications[$job->id]->status == 'lolos' ? 'bg-green-500' :
                                                   ($jobApplications[$job->id]->status == 'diproses' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                                {{ ucfirst($jobApplications[$job->id]->status) }}
                                            </span>
                                        @else
                                            <span class="text-gray-500">Belum Melamar</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4">
                                        @if (!isset($jobApplications[$job->id]))
                                            <form action="{{ route('siswa.job-matching.apply', $job->id) }}" method="POST">
                                                @csrf
                                                <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                                    Lamar
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="bg-gray-300 text-gray-600 px-3 py-1 rounded">
                                                Sudah Melamar
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
    </div>
</main>
@endsection
