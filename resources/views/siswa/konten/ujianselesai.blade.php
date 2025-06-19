@extends('siswa.main.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <svg class="mx-auto h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <h1 class="text-2xl font-bold mt-4 mb-2">Ujian Selesai!</h1>
        <p class="text-gray-600 mb-6">Anda telah menyelesaikan ujian "{{ $tugas->judul }}"</p>
        
        @if(isset($tugasUser->nilai))
            <div class="mb-6 p-4 bg-gray-100 rounded-lg">
                <h2 class="text-lg font-semibold mb-2">Nilai Anda</h2>
                <div class="text-5xl font-bold {{ $tugasUser->nilai >= 65 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $tugasUser->nilai }}
                </div>
                <p class="mt-2 font-medium {{ $tugasUser->nilai >= 65 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $tugasUser->nilai >= 65 ? 'LULUS' : 'TIDAK LULUS' }}
                </p>
            </div>
        @else
            <div class="mb-6 p-4 bg-yellow-50 rounded-lg">
                <p class="text-yellow-600">Nilai Anda sedang diproses</p>
            </div>
        @endif
        
        <a href="{{ route('siswa.dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection