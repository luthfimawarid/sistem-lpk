@extends('admin.main.sidebar')

@section('content')

<div class="p-6 bg-blue-50 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-semibold">Edit Tugas</h1>
        <a href="{{ route('tugas.index') }}" class="bg-[#0A58CA] text-white py-2 px-4 rounded-lg">Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('tugas.update', $tugas->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="judul" class="mt-1 p-2 w-full border rounded-md" value="{{ old('judul', $tugas->judul) }}" required>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="mt-1 p-2 w-full border rounded-md" required>{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
            </div>

            {{-- Deadline --}}
            <div id="deadline-group" class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Deadline</label>
                <input type="date" name="deadline" id="deadline" class="mt-1 p-2 w-full border rounded-md" value="{{ old('deadline', $tugas->deadline) }}">
            </div>

            {{-- Durasi Ujian --}}
            <div id="durasi-group" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700">Durasi Ujian (menit)</label>
                <input type="number" name="durasi" id="durasi" min="1" class="mt-1 p-2 w-full border rounded-md" value="{{ old('durasi', $tugas->durasi) }}">
            </div>

            {{-- Tipe --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tipe</label>
                <select name="tipe" id="tipe" class="mt-1 p-2 w-full border rounded-md" onchange="toggleTipe()" required>
                    <option value="tugas" {{ $tugas->tipe == 'tugas' ? 'selected' : '' }}>Tugas</option>
                    <option value="kuis" {{ $tugas->tipe == 'kuis' ? 'selected' : '' }}>Kuis</option>
                    <option value="ujian_akhir" {{ $tugas->tipe == 'ujian_akhir' ? 'selected' : '' }}>Ujian Akhir</option>
                    <option value="evaluasi_mingguan" {{ $tugas->tipe == 'evaluasi_mingguan' ? 'selected' : '' }}>Evaluasi Mingguan</option>
                    <option value="tryout" {{ $tugas->tipe == 'tryout' ? 'selected' : '' }}>Tryout</option>
                </select>
            </div>

            {{-- Bidang --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Bidang</label>
                <select name="bidang" class="mt-1 p-2 w-full border rounded-md" required>
                    @php
                        $listBidang = [
                            'Perawatan (Kaigo/Caregiver)',
                            'Pembersihan Gedung',
                            'Konstruksi',
                            'Manufaktur Mesin Industri',
                            'Elektronik dan Listrik',
                            'Perhotelan',
                            'Pertanian',
                            'Perikanan',
                            'Pengolahan Makanan dan Minuman',
                            'Restoran/Cafe'
                        ];
                    @endphp
                    <option value="" disabled {{ !$tugas->bidang ? 'selected' : '' }}>Pilih Bidang</option>
                    @foreach($listBidang as $bidang)
                        <option value="{{ $bidang }}" {{ $tugas->bidang == $bidang ? 'selected' : '' }}>{{ $bidang }}</option>
                    @endforeach
                </select>
            </div>

            {{-- File (Opsional) --}}
            <div id="file-upload" class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Unggah File (opsional)</label>
                <input type="file" name="file" class="mt-1 p-2 w-full border rounded-md" accept=".pdf,.doc,.docx,.ppt,.pptx,image/*">
                @if($tugas->file)
                    <p class="mt-2 text-sm text-gray-600">File sebelumnya:</p>
                    <a href="{{ asset('storage/file_tugas/'.$tugas->file) }}" target="_blank" class="text-blue-600 hover:underline">{{ $tugas->file }}</a>
                @endif
            </div>

            {{-- Soal --}}
            <div id="soal-group" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Soal Pilihan Ganda</label>
                <div id="soal-wrapper">
                    @php $index = 0; @endphp
                    @if(old('soal') || $tugas->soal_json)
                        @foreach(old('soal', json_decode($tugas->soal_json, true) ?? []) as $soal)
                            <div class="soal-item border p-4 rounded mb-4 bg-gray-50">
                                <label class="block text-sm font-semibold mb-1">Pertanyaan</label>
                                <input type="text" name="soal[{{ $index }}][pertanyaan]" value="{{ $soal['pertanyaan'] ?? '' }}" class="w-full p-2 border rounded mb-2" placeholder="Masukkan pertanyaan">

                                <div class="grid grid-cols-2 gap-2">
                                    @foreach(['a', 'b', 'c', 'd'] as $opsi)
                                        <div>
                                            <label class="text-sm">Pilihan {{ strtoupper($opsi) }}</label>
                                            <input type="text" name="soal[{{ $index }}][opsi_{{ $opsi }}]" value="{{ $soal['opsi_'.$opsi] ?? '' }}" class="w-full p-2 border rounded" placeholder="Jawaban {{ strtoupper($opsi) }}">
                                        </div>
                                    @endforeach
                                </div>

                                <label class="block text-sm mt-3">Jawaban Benar</label>
                                <select name="soal[{{ $index }}][jawaban]" class="w-full p-2 border rounded">
                                    @foreach(['A','B','C','D'] as $jwb)
                                        <option value="{{ $jwb }}" {{ (isset($soal['jawaban']) && $soal['jawaban'] == $jwb) ? 'selected' : '' }}>{{ $jwb }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @php $index++; @endphp
                        @endforeach
                    @endif
                </div>

                <button type="button" onclick="tambahSoal()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Tambah Soal</button>
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="belum_selesai" {{ $tugas->status == 'belum_selesai' ? 'selected' : '' }}>Belum Selesai</option>
                    <option value="selesai" {{ $tugas->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-[#0A58CA] text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function toggleTipe() {
        const tipe = document.getElementById('tipe').value;
        const fileUpload = document.getElementById('file-upload');
        const soalGroup = document.getElementById('soal-group');
        const deadlineGroup = document.getElementById('deadline-group');
        const durasiGroup = document.getElementById('durasi-group');

        if (tipe === 'tugas' || tipe === 'evaluasi_mingguan') {
            fileUpload.classList.remove('hidden');
            soalGroup.classList.add('hidden');
            deadlineGroup.classList.remove('hidden');
            durasiGroup.classList.add('hidden');
            document.getElementById('deadline').required = true;
            document.getElementById('durasi').required = false;
        } else if (tipe === 'ujian_akhir') {
            fileUpload.classList.add('hidden');
            soalGroup.classList.remove('hidden');
            deadlineGroup.classList.add('hidden');
            durasiGroup.classList.remove('hidden');
            document.getElementById('deadline').required = false;
            document.getElementById('durasi').required = true;
        } else { // Kuis atau Tryout
            fileUpload.classList.add('hidden');
            soalGroup.classList.remove('hidden');
            deadlineGroup.classList.remove('hidden');
            durasiGroup.classList.add('hidden');
            document.getElementById('deadline').required = true;
            document.getElementById('durasi').required = false;
        }
    }

    let soalIndex = {{ $index ?? 1 }};
    function tambahSoal() {
        const wrapper = document.getElementById('soal-wrapper');
        const html = `
        <div class="soal-item border p-4 rounded mb-4 bg-gray-50">
            <label class="block text-sm font-semibold mb-1">Pertanyaan</label>
            <input type="text" name="soal[${soalIndex}][pertanyaan]" class="w-full p-2 border rounded mb-2" placeholder="Masukkan pertanyaan">

            <div class="grid grid-cols-2 gap-2">
                <div><label class="text-sm">Pilihan A</label><input type="text" name="soal[${soalIndex}][opsi_a]" class="w-full p-2 border rounded" placeholder="Jawaban A"></div>
                <div><label class="text-sm">Pilihan B</label><input type="text" name="soal[${soalIndex}][opsi_b]" class="w-full p-2 border rounded" placeholder="Jawaban B"></div>
                <div><label class="text-sm">Pilihan C</label><input type="text" name="soal[${soalIndex}][opsi_c]" class="w-full p-2 border rounded" placeholder="Jawaban C"></div>
                <div><label class="text-sm">Pilihan D</label><input type="text" name="soal[${soalIndex}][opsi_d]" class="w-full p-2 border rounded" placeholder="Jawaban D"></div>
            </div>

            <label class="block text-sm mt-3">Jawaban Benar</label>
            <select name="soal[${soalIndex}][jawaban]" class="w-full p-2 border rounded">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>`;
        wrapper.insertAdjacentHTML('beforeend', html);
        soalIndex++;
    }

    document.addEventListener('DOMContentLoaded', toggleTipe);
</script>
@endsection
