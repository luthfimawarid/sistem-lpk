@extends('admin.main.sidebar')

@section('content')

<div class="p-10 bg-blue-50">
    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="atas flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Input Nilai Siswa</h2>
            <a href="/tugas-admin" class="rounded text-white py-2 px-4 bg-[#0A58CA]">Kembali</a>
        </div>

        <form action="{{ route('nilai.simpan') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="tugas_user_id" value="{{ $tugasUser->id }}">

            <div>
                <label class="block font-medium text-gray-700">Nama Siswa</label>
                <p class="font-semibold text-blue-600">{{ $tugasUser->user->nama_lengkap }}</p>
            </div>

            <div>
                <label for="nilai" class="block font-medium text-gray-700">Nilai</label>
                <input type="number" id="nilai" name="nilai" class="w-full p-2 border rounded-lg" min="0" max="100" required>
            </div>

            <div>
                <label for="catatan" class="block font-medium text-gray-700">Catatan</label>
                <textarea id="catatan" name="catatan" rows="4" class="w-full p-2 border rounded-lg" placeholder="Tambahkan catatan (opsional)"></textarea>
            </div>

            <button type="submit" class="bg-[#0A58CA] text-white px-4 py-2 rounded-lg w-full">Simpan Nilai</button>
        </form>

    </div>
</div>
@endsection
