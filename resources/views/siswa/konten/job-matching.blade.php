@extends('siswa.main.sidebar')

@section('content')
<main class="p-4 sm:p-6">
    <div class="bg-white p-4 sm:p-6 rounded shadow">
        <h2 class="text-base sm:text-lg font-semibold mb-4">Daftar Lowongan Job Matching</h2>

        {{-- ✅ Bagian 1: Lowongan tanpa butuh sertifikat --}}
        <h3 class="text-sm sm:text-base font-semibold mb-2 text-green-600">Lowongan Terbuka (Tanpa Sertifikat)</h3>

        @if ($jobTanpaSertifikat->isEmpty())
            <p class="text-gray-500 text-sm mb-4">Tidak ada lowongan yang tersedia tanpa sertifikat.</p>
        @else
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full text-sm sm:text-base text-left">
                    <thead class="bg-[#0A58CA] text-white">
                        <tr>
                            <th class="py-2 px-4">Posisi</th>
                            <th class="py-2 px-4">Perusahaan</th>
                            <th class="py-2 px-4">Status Lamaran</th>
                            <th class="py-2 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobTanpaSertifikat as $job)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $job->posisi }}</td>
                            <td class="py-2 px-4">{{ $job->nama_perusahaan }}</td>
                            <td class="py-2 px-4">
                                @if (isset($jobApplications[$job->id]))
                                    <span class="px-2 py-1 text-white rounded
                                        {{ $jobApplications[$job->id]->status == 'lolos' ? 'bg-green-500' :
                                        ($jobApplications[$job->id]->status == 'diproses' ? 'bg-yellow-500' : 'bg-yellow-500') }}">
                                        {{ ucfirst($jobApplications[$job->id]->status) }}
                                    </span>

                                    @if ($jobApplications[$job->id]->interview_message)
                                        <div class="mt-1 text-sm text-blue-600">
                                            <p>{{ $jobApplications[$job->id]->interview_message }}</p>
                                        </div>
                                    @endif
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

        {{-- ✅ Bagian 2: Lowongan yang butuh sertifikat --}}
        <h3 class="text-sm sm:text-base font-semibold mb-2 text-indigo-600">Lowongan Khusus (Butuh 2 Sertifikat)</h3>

        @if ($sertifikatLulus < 2)
            <p class="text-gray-500 text-sm">Kamu belum memiliki 2 sertifikat lulus. Dapatkan minimal 2 sertifikat untuk melihat lowongan ini.</p>
        @elseif ($jobButuhSertifikat->isEmpty())
            <p class="text-gray-500 text-sm">Tidak ada lowongan khusus saat ini.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm sm:text-base text-left">
                    <thead class="bg-[#0A58CA] text-white">
                        <tr>
                            <th class="py-2 px-4">Posisi</th>
                            <th class="py-2 px-4">Perusahaan</th>
                            <th class="py-2 px-4">Status Lamaran</th>
                            <th class="py-2 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobButuhSertifikat as $job)
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

                                    @if ($jobApplications[$job->id]->interview_message)
                                        <div class="mt-1 text-sm text-blue-600">
                                            <p>{{ $jobApplications[$job->id]->interview_message }}</p>
                                        </div>
                                    @endif
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
    </div>
</main>
@endsection
