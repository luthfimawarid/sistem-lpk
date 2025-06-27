@extends('siswa.main.sidebar')

@section('content')
<main class="px-4 py-6 md:px-8 lg:px-16 bg-[#F2F8FF] min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow">
        <!-- Tabs -->
        <div class="flex flex-wrap gap-2 border-b mb-6 text-sm md:text-base">
            <button class="tab-btn text-blue-600 font-semibold border-b-2 border-blue-600 px-2 md:px-4 py-1 md:py-2 focus:outline-none" data-tab="tab-data-diri">Data Diri</button>
            <button class="tab-btn text-gray-600 hover:text-blue-600 px-2 md:px-4 py-1 md:py-2 focus:outline-none" data-tab="tab-nilai">Nilai</button>
            <button class="tab-btn text-gray-600 hover:text-blue-600 px-2 md:px-4 py-1 md:py-2 focus:outline-none" data-tab="tab-password">Ubah Password</button>
        </div>

        <!-- Tab Content -->
        <div id="tab-data-diri" class="tab-content">
            <form action="{{ route('siswa.update.profil') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="max-w-screen-lg mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Foto Profil -->
                    <div class="col-span-1 md:col-span-2 flex justify-center">
                        <div class="text-center">
                            <div class="w-24 h-24 rounded-full bg-gray-300 mx-auto mb-2 overflow-hidden">
                                @if ($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="w-24 h-24 object-cover rounded-full max-w-full">
                                @endif
                            </div>
                            <label class="font-semibold cursor-pointer">
                                <span class="text-blue-600 hover:underline">Ubah Foto</span>
                                <input type="file" name="photo" class="hidden" accept="image/*">
                            </label>
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="text-gray-500 text-xs sm:text-sm">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="w-full border-b border-gray-300 p-2 text-sm bg-transparent" value="{{ $user->nama_lengkap }}" required>
                    </div>

                    <!-- NISN -->
                    <div>
                        <label class="text-gray-500 text-xs sm:text-sm">NISN</label>
                        <input type="text" class="w-full border-b border-gray-300 p-2 text-sm bg-transparent" value="{{ $user->id }}" readonly>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="text-gray-500 text-xs sm:text-sm">Email</label>
                        <input type="email" name="email" class="w-full border-b border-gray-300 p-2 text-sm bg-transparent" value="{{ $user->email }}" required>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="text-gray-500 text-xs sm:text-sm">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="w-full border-b border-gray-300 p-2 text-sm bg-transparent" value="{{ $user->tanggal_lahir }}">
                    </div>

                    <!-- No HP -->
                    <div>
                        <label class="text-gray-500 text-xs sm:text-sm">No HP</label>
                        <input type="text" name="no_hp" class="w-full border-b border-gray-300 p-2 text-sm bg-transparent" value="{{ $user->no_hp ?? '' }}">
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label class="text-gray-500 text-xs sm:text-sm">Kelas</label>
                        <input type="text" name="kelas" class="w-full border-b border-gray-300 p-2 text-sm bg-transparent" value="{{ $user->kelas ?? '' }}">
                    </div>

                    <!-- Angkatan -->
                    <div>
                        <label class="text-gray-500 text-xs sm:text-sm">Angkatan</label>
                        <input type="text" name="angkatan" class="w-full border-b border-gray-300 p-2 text-sm bg-transparent" value="{{ $user->angkatan ?? $user->created_at->format('Y') }}">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="text-gray-500 text-xs sm:text-sm">Status</label>
                        <input type="text" name="status" class="w-full border-b border-gray-300 p-2 text-sm bg-transparent" value="{{ $user->status ?? 'Aktif' }}">
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="col-span-1 md:col-span-2 text-center mt-6">
                        <button class="w-full md:w-auto bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Simpan Perubahan</button>
                    </div>

                    <!-- Dokumen Siswa -->
                    <div class="col-span-1 md:col-span-2">
                        <h3 class="font-semibold text-base mb-2">Dokumen</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @php
                                $daftarDokumen = ['ijazah', 'kartu_keluarga', 'akte_kelahiran', 'rapor', 'ktp_orang_tua'];
                            @endphp

                            @foreach($daftarDokumen as $dokumen)
                                <div class="border p-3 rounded-lg bg-gray-50">
                                    <p class="text-sm font-medium capitalize">{{ str_replace('_', ' ', $dokumen) }}</p>
                                    @if($dokumenSiswa->has($dokumen))
                                        <a href="{{ asset('storage/' . $dokumenSiswa[$dokumen]->file) }}" target="_blank" class="text-blue-600 text-sm underline">
                                            Lihat Dokumen
                                        </a>
                                    @else
                                        <p class="text-red-500 text-sm">Belum diunggah</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </form>
        </div>



        <!-- Nilai -->
        <div id="tab-nilai" class="tab-content hidden">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="text-gray-500 text-xs sm:text-sm">Rata-rata Nilai Tugas</label>
                    <input type="text" class="w-full border-b border-gray-300 p-1 text-sm bg-transparent" value="{{ $nilaiTugas ?? '-' }}" readonly>
                </div>

                <div>
                    <label class="text-gray-500 text-xs sm:text-sm">Rata-rata Nilai Evaluasi</label>
                    <input type="text" class="w-full border-b border-gray-300 p-1 text-sm bg-transparent" value="{{ $nilaiEvaluasi ?? '-' }}" readonly>
                </div>

                <div>
                    <label class="text-gray-500 text-xs sm:text-sm">Rata-rata Nilai Kuis</label>
                    <input type="text" class="w-full border-b border-gray-300 p-1 text-sm bg-transparent" value="{{ $nilaiKuis ?? '-' }}" readonly>
                </div>

                <div>
                    <label class="text-gray-500 text-xs sm:text-sm">Rata-rata Nilai Tryout</label>
                    <input type="text" class="w-full border-b border-gray-300 p-1 text-sm bg-transparent" value="{{ $nilaiTryout ?? '-' }}" readonly>
                </div>

                <div>
                    <label class="text-gray-500 text-xs sm:text-sm">Prediksi Kelulusan</label>
                    <input type="text" class="w-full border-b border-gray-300 p-1 text-sm bg-transparent text-green-600" value="Lulus" readonly>
                </div>
            </div>
        </div>

        <!-- Ubah Password -->
        <div id="tab-password" class="tab-content hidden">
            <form action="{{ route('siswa.update.password') }}" method="POST">
                @csrf
                <div class="max-w-screen-md mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Password Lama -->
                    <div>
                        <label class="text-gray-500 text-sm">Password Lama</label>
                        <input type="password" name="old_password" class="w-full border-b border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label class="text-gray-500 text-sm">Password Baru</label>
                        <input type="password" name="new_password" class="w-full border-b border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div class="md:col-span-2">
                        <label class="text-gray-500 text-sm">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="w-full border-b border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="md:col-span-2 text-center mt-6">
                        <button class="w-full md:w-auto bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</main>

<!-- Script Tab -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabButtons = document.querySelectorAll(".tab-btn");
        const tabContents = document.querySelectorAll(".tab-content");

        tabButtons.forEach((btn) => {
            btn.addEventListener("click", function () {
                const target = this.getAttribute("data-tab");

                tabButtons.forEach((b) => {
                    b.classList.remove("text-blue-600", "font-semibold", "border-blue-600", "border-b-2");
                    b.classList.add("text-gray-600");
                });

                tabContents.forEach((content) => {
                    content.classList.add("hidden");
                });

                this.classList.remove("text-gray-600");
                this.classList.add("text-blue-600", "font-semibold", "border-b-2", "border-blue-600");

                document.getElementById(target).classList.remove("hidden");
            });
        });
    });
</script>
@endsection
