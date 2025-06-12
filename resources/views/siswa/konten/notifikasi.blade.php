@extends('siswa.main.sidebar')

@section('content')
<div class="p-6">
    <div class="mx-auto mt-4 p-4 bg-white rounded shadow">
        <h1 class="text-xl font-bold mb-4">Daftar Notifikasi</h1>

        @if ($notifikasi->isEmpty())
            <p class="text-gray-500">Tidak ada notifikasi.</p>
        @else
            <ul class="space-y-4">
                @foreach ($notifikasi as $notif)
                    <li class="p-4 border rounded hover:bg-gray-50">
                        <h2 class="font-semibold">{{ $notif->judul }}</h2>
                        <p class="text-sm text-gray-600">{{ $notif->pesan }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
