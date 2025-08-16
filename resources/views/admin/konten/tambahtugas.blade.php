@extends('admin.main.sidebar')

@section('content')

<div class="p-10 bg-blue-50">
    <div class="header flex justify-between items-center pb-6">
        <h1 class="md:text-xl font-semibold">Tambah Tugas / Kuis / Ujian Akhir</h1>
        <a href="{{ route('tugas.index') }}" class="bg-[#0A58CA] text-white py-2 px-4 rounded-lg">Kembali</a>
    </div>

    <main class="min-h-screen bg-gray-100">
        <!-- Tampilkan error validasi -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tugas.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" id="judul" name="judul" class="mt-1 p-2 w-full border rounded-md" placeholder="Masukkan judul" required>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 p-2 w-full border rounded-md" placeholder="Masukkan deskripsi" required></textarea>
            </div>

            <!-- Input Deadline/Tanggal -->
            <div id="deadline-group" class="mb-4">
                <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                <input type="date" id="deadline" name="deadline" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Input Durasi Ujian (Muncul saat pilih Ujian Akhir) -->
            <div id="durasi-group" class="mb-4 hidden">
                <label for="durasi" class="block text-sm font-medium text-gray-700">Durasi Ujian (menit)</label>
                <input type="number" id="durasi" name="durasi" min="1" class="mt-1 p-2 w-full border rounded-md" placeholder="Masukkan durasi dalam menit">
            </div>

            <div class="mb-4">
                <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe</label>
                <select id="tipe" name="tipe" class="mt-1 p-2 w-full border rounded-md" onchange="toggleTipe()" required>
                    <option value="tugas">Tugas</option>
                    <option value="kuis">Kuis</option>
                    <option value="ujian_akhir">Ujian Akhir</option>
                    <option value="evaluasi_mingguan">Evaluasi Mingguan</option>
                    <option value="tryout">Tryout</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="bidang" class="block text-sm font-medium text-gray-700">Bidang</label>
                <select id="bidang" name="bidang" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="" disabled selected>Pilih Bidang</option>
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
                    @foreach($listBidang as $bidang)
                        <option value="{{ $bidang }}">{{ $bidang }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                <select id="kelas" name="kelas" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="" disabled selected>Pilih Kelas</option>
                    @php
                        $kelasList = \App\Models\User::where('role', 'siswa')
                                    ->select('kelas')
                                    ->distinct()
                                    ->orderBy('kelas')
                                    ->pluck('kelas');
                    @endphp
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas }}">{{ $kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div id="siswa-group" class="mb-4 hidden">
                <label for="siswa" class="block text-sm font-medium text-gray-700">Pilih Siswa</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 max-h-[400px] overflow-y-auto border p-3 rounded-md">
                    @php
                        $siswaList = \App\Models\User::where('role', 'siswa')->orderBy('nama_lengkap')->get();
                    @endphp
                    @foreach($siswaList as $siswa)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="siswa_id[]" value="{{ $siswa->id }}" class="form-checkbox">
                            <span>{{ $siswa->nama_lengkap }} ({{ $siswa->kelas }} - {{ $siswa->bidang }})</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Pilihan Jenis Ujian Akhir -->
            <div id="jenis-ujian-akhir-group" class="mb-4 hidden">
                <label for="jenis_ujian_akhir" class="block text-sm font-medium text-gray-700">Jenis Ujian Akhir</label>
                <select id="jenis_ujian_akhir" name="jenis_ujian_akhir" class="mt-1 p-2 w-full border rounded-md">
                    <option value="" disabled selected>Pilih Jenis Ujian</option>
                    <option value="bahasa">Ujian Bahasa</option>
                    <option value="ssw">Ujian SSW</option>
                </select>
            </div>



            <!-- Upload File Tugas -->
            <div id="file-upload" class="mb-4">
                <label for="cover" class="block text-sm font-medium text-gray-700">Unggah File (PDF/Gambar)</label>
                <input type="file" id="cover" name="cover" class="mt-1 p-2 w-full border rounded-md" accept=".pdf,.doc,.docx,.ppt,.pptx,image/*">
            </div>

            <div id="soal-group" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Soal Pilihan Ganda</label>

            <div id="navigator-soal" class="flex flex-wrap gap-2 mb-4">
                <!-- Tombol navigator soal akan dimasukkan oleh JS -->
            </div>

            <div id="soal-wrapper">
                <div class="soal-item border p-4 rounded mb-4 bg-gray-50" id="soal-0">
                    <label class="block text-sm mb-1 font-semibold">Pertanyaan</label>
                    <input type="text" name="soal[0][pertanyaan]" class="w-full p-2 border rounded mb-2" placeholder="Masukkan pertanyaan">

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-sm">Pilihan A</label>
                            <input type="text" name="soal[0][opsi_a]" class="w-full p-2 border rounded" placeholder="Jawaban A">
                        </div>
                        <div>
                            <label class="text-sm">Pilihan B</label>
                            <input type="text" name="soal[0][opsi_b]" class="w-full p-2 border rounded" placeholder="Jawaban B">
                        </div>
                        <div>
                            <label class="text-sm">Pilihan C</label>
                            <input type="text" name="soal[0][opsi_c]" class="w-full p-2 border rounded" placeholder="Jawaban C">
                        </div>
                        <div>
                            <label class="text-sm">Pilihan D</label>
                            <input type="text" name="soal[0][opsi_d]" class="w-full p-2 border rounded" placeholder="Jawaban D">
                        </div>
                    </div>

                    <label class="block text-sm mt-3">Jawaban Benar</label>
                    <select name="soal[0][jawaban]" class="w-full p-2 border rounded">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
            </div>

                <button type="button" onclick="tambahSoal()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    + Tambah Soal
                </button>
            </div>

            <!-- Status -->
            <!-- <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="belum_selesai" selected>Belum Selesai</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div> -->

            <div class="flex justify-end">
                <a href="{{ route('tugas.index') }}"
                class="inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-gray-400 transition mx-2">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </main>
</div>

<script>

function toggleTipe() {
    const tipe = document.getElementById('tipe').value;
    const fileUpload = document.getElementById('file-upload');
    const soalGroup = document.getElementById('soal-group');
    const deadlineGroup = document.getElementById('deadline-group');
    const durasiGroup = document.getElementById('durasi-group');
    const siswaGroup = document.getElementById('siswa-group');
    const jenisUjianAkhirGroup = document.getElementById('jenis-ujian-akhir-group');

    if (tipe === 'tugas' || tipe === 'evaluasi_mingguan') {
        fileUpload.classList.remove('hidden');
        soalGroup.classList.add('hidden');
        deadlineGroup.classList.remove('hidden');
        durasiGroup.classList.add('hidden');
        jenisUjianAkhirGroup.classList.add('hidden');
        siswaGroup.classList.toggle('hidden', tipe !== 'evaluasi_mingguan');
        document.getElementById('deadline').required = true;
        document.getElementById('durasi').required = false;
        document.getElementById('jenis_ujian_akhir').required = false;
    } else if (tipe === 'ujian_akhir') {
        fileUpload.classList.add('hidden');
        soalGroup.classList.remove('hidden');
        deadlineGroup.classList.add('hidden');
        durasiGroup.classList.remove('hidden');
        jenisUjianAkhirGroup.classList.remove('hidden');
        siswaGroup.classList.remove('hidden');
        document.getElementById('deadline').required = false;
        document.getElementById('durasi').required = true;
        document.getElementById('jenis_ujian_akhir').required = true;
    } else { // Kuis atau Tryout
        fileUpload.classList.add('hidden');
        soalGroup.classList.remove('hidden');
        deadlineGroup.classList.remove('hidden');
        durasiGroup.classList.add('hidden');
        jenisUjianAkhirGroup.classList.add('hidden');
        siswaGroup.classList.add('hidden');
        document.getElementById('deadline').required = true;
        document.getElementById('durasi').required = false;
        document.getElementById('jenis_ujian_akhir').required = false;
    }
}

    let soalIndex = 1;

    function tambahSoal() {
        const wrapper = document.getElementById('soal-wrapper');
        const nav = document.getElementById('navigator-soal');

        const html = `
        <div class="soal-item border p-4 rounded mb-4 bg-gray-50" id="soal-${soalIndex}">
            <label class="block text-sm mb-1 font-semibold">Pertanyaan</label>
            <input type="text" name="soal[${soalIndex}][pertanyaan]" class="w-full p-2 border rounded mb-2" placeholder="Masukkan pertanyaan">

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="text-sm">Pilihan A</label>
                    <input type="text" name="soal[${soalIndex}][opsi_a]" class="w-full p-2 border rounded" placeholder="Jawaban A">
                </div>
                <div>
                    <label class="text-sm">Pilihan B</label>
                    <input type="text" name="soal[${soalIndex}][opsi_b]" class="w-full p-2 border rounded" placeholder="Jawaban B">
                </div>
                <div>
                    <label class="text-sm">Pilihan C</label>
                    <input type="text" name="soal[${soalIndex}][opsi_c]" class="w-full p-2 border rounded" placeholder="Jawaban C">
                </div>
                <div>
                    <label class="text-sm">Pilihan D</label>
                    <input type="text" name="soal[${soalIndex}][opsi_d]" class="w-full p-2 border rounded" placeholder="Jawaban D">
                </div>
            </div>

            <label class="block text-sm mt-3">Jawaban Benar</label>
            <select name="soal[${soalIndex}][jawaban]" class="w-full p-2 border rounded">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);

        // Tambahkan tombol navigasi
        const navBtn = document.createElement('button');
        navBtn.textContent = `Soal ${soalIndex + 1}`;
        navBtn.type = 'button';
        navBtn.className = 'px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 transition';
        navBtn.setAttribute('onclick', `scrollToSoal(${soalIndex})`);
        nav.appendChild(navBtn);

        // Scroll otomatis ke soal
        setTimeout(() => {
            scrollToSoal(soalIndex);
        }, 100);

        soalIndex++;
    }

    function scrollToSoal(index) {
        const soal = document.getElementById(`soal-${index}`);
        if (soal) {
            soal.scrollIntoView({ behavior: 'smooth', block: 'start' });
            soal.classList.add('ring', 'ring-blue-400');
            setTimeout(() => soal.classList.remove('ring', 'ring-blue-400'), 1000);
        }
    }

    window.onload = toggleTipe;
</script>


@endsection