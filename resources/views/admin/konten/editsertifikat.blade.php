@extends('admin.main.sidebar')

@section('content')
<div class="p-10 bg-blue-50">
    <div class="header flex justify-between items-center mb-10">
        <h1 class="text-xl font-semibold">Edit Sertifikat</h1>
        <a href="{{ route('sertifikat.index') }}" class="bg-[#0A58CA] py-2 px-4 text-white rounded-lg">Kembali</a>
    </div>
    <main>
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-200 text-red-800 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sertifikat.update', $sertifikat->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-1">Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $sertifikat->judul) }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Deskripsi</label>
                <textarea name="deskripsi" class="w-full border p-2 rounded" rows="4">{{ old('deskripsi', $sertifikat->deskripsi) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Tipe Sertifikat</label>
                <select name="tipe" id="tipe" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="bahasa" {{ old('tipe', $sertifikat->tipe) == 'bahasa' ? 'selected' : '' }}>Bahasa</option>
                    <option value="skill" {{ old('tipe', $sertifikat->tipe) == 'skill' ? 'selected' : '' }}>Skill</option>
                </select>
            </div>

            <div class="mb-4" id="bidang-wrapper" style="{{ old('tipe', $sertifikat->tipe) == 'skill' ? '' : 'display:none;' }}">
                <label class="block font-semibold mb-1">Bidang</label>
                <select name="bidang" id="bidang" class="w-full border p-2 rounded">
                    <option value="">-- Pilih Bidang --</option>
                    <option value="IT" {{ old('bidang', $sertifikat->bidang) == 'IT' ? 'selected' : '' }}>IT</option>
                    <option value="Marketing" {{ old('bidang', $sertifikat->bidang) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="Design" {{ old('bidang', $sertifikat->bidang) == 'Design' ? 'selected' : '' }}>Design</option>
                    <option value="Finance" {{ old('bidang', $sertifikat->bidang) == 'Finance' ? 'selected' : '' }}>Finance</option>
                    <option value="HR" {{ old('bidang', $sertifikat->bidang) == 'HR' ? 'selected' : '' }}>HR</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Gambar Saat Ini</label>
                @if ($sertifikat->gambar || $sertifikat->file)
                    <img src="{{ asset('storage/sertifikat/' . ($sertifikat->gambar ?? $sertifikat->file)) }}" class="w-40 mb-2" alt="Gambar Sertifikat">
                @else
                    <p>Tidak ada gambar</p>
                @endif
                <input type="file" name="gambar" class="w-full">
                <small class="text-gray-600">Biarkan kosong jika tidak ingin mengganti gambar.</small>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </main>
</div>

<script>
    // Toggle bidang dropdown muncul jika tipe = skill
    const tipeSelect = document.getElementById('tipe');
    const bidangWrapper = document.getElementById('bidang-wrapper');

    tipeSelect.addEventListener('change', function() {
        if (this.value === 'skill') {
            bidangWrapper.style.display = '';
        } else {
            bidangWrapper.style.display = 'none';
            // Optional: reset bidang pilihan saat sembunyi
            document.getElementById('bidang').value = '';
        }
    });
</script>
@endsection
