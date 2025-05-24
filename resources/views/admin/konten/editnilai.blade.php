@extends('admin.main.sidebar')

@section('content')

<div class="p-10 bg-blue-50">
    <div class="header flex justify-between items-center pb-6">
        <h1 class="text-xl font-semibold">Edit Nilai Rapot: {{ $user->name }}</h1>
        <a href="{{ route('rapot.list') }}" class="bg-[#0A58CA] text-white py-2 px-4 rounded-lg">Kembali</a>
    </div>

    <main class="min-h-screen bg-gray-100">
        <form action="{{ route('rapot.update', ['id' => $user->id]) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nilai_tugas" class="block text-sm font-medium text-gray-700">Nilai Tugas</label>
                <input type="number" id="nilai_tugas" name="nilai_tugas" min="0" max="100" value="{{ old('nilai_tugas', $nilai->nilai_tugas ?? '') }}" class="mt-1 p-2 w-full border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="nilai_evaluasi" class="block text-sm font-medium text-gray-700">Nilai Evaluasi</label>
                <input type="number" id="nilai_evaluasi" name="nilai_evaluasi" min="0" max="100" value="{{ old('nilai_evaluasi', $nilai->nilai_evaluasi ?? '') }}" class="mt-1 p-2 w-full border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="nilai_tryout" class="block text-sm font-medium text-gray-700">Nilai Tryout</label>
                <input type="number" id="nilai_tryout" name="nilai_tryout" min="0" max="100" value="{{ old('nilai_tryout', $nilai->nilai_tryout ?? '') }}" class="mt-1 p-2 w-full border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="prediksi" class="block text-sm font-medium text-gray-700">Prediksi Kelulusan</label>
                <select id="prediksi" name="prediksi" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="Lulus" {{ (old('prediksi', $nilai->prediksi ?? '') == 'Lulus') ? 'selected' : '' }}>Lulus</option>
                    <option value="Beresiko" {{ (old('prediksi', $nilai->prediksi ?? '') == 'Beresiko') ? 'selected' : '' }}>Beresiko</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </main>
</div>

@endsection
