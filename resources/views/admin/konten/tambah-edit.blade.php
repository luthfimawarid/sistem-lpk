@extends('admin.main.sidebar')

@section('content')
<main class="p-6">
    <div class="p-6 bg-white shadow rounded mx-auto">
        <h2 class="text-xl font-semibold mb-4">
            {{ $job->exists ? 'Edit Lowongan' : 'Tambah Lowongan' }}
        </h2>

        <form method="POST" action="{{ $job->exists ? route('admin.job-matching.update', $job->id) : route('admin.job-matching.store') }}">
            @csrf
            @if($job->exists)
                @method('PUT')
            @endif

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Posisi</label>
                <input type="text" name="posisi" value="{{ old('posisi', $job->posisi) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nama Perusahaan</label>
                <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $job->nama_perusahaan) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $job->lokasi) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Deskripsi Pekerjaan</label>
                <textarea name="deskripsi" class="w-full border rounded px-3 py-2" required>{{ old('deskripsi', $job->deskripsi) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="terbuka" {{ old('status', $job->status) == 'terbuka' ? 'selected' : '' }}>Terbuka</option>
                    <option value="tertutup" {{ old('status', $job->status) == 'tertutup' ? 'selected' : '' }}>Tertutup</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ $job->exists ? 'Update' : 'Simpan' }}
            </button>
        </form>
    </div>
</main>
@endsection
