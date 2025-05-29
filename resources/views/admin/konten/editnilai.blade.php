@extends('admin.main.sidebar')

@section('content')
<div class="p-10 bg-blue-50">
    <div class="header flex justify-between items-center pb-6">
        <h1 class="text-xl font-semibold">Edit Nilai {{ ucfirst($tipe) }} - {{ $user->name }}</h1>
        <a href="{{ route('admin.nilai') }}" class="bg-[#0A58CA] text-white py-2 px-4 rounded-lg">Kembali</a>
    </div>

    <main class="min-h-screen bg-gray-100">
        <form action="{{ route('rapot.update.tipe', ['id' => $user->id, 'tipe' => $tipe]) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nilai_{{ $tipe }}" class="block text-sm font-medium text-gray-700">Nilai {{ ucfirst($tipe) }}</label>
                <input type="number" id="nilai" name="nilai" value="{{ old('nilai', $nilai?->nilai ?? '') }}" class="mt-1 p-2 w-full border rounded-md" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </main>
</div>
@endsection
