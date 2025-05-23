@extends('siswa.main.sidebar')

@section('content')
<main class="p-6 bg-[#F2F8FF] min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow">
        <!-- Tabs -->
        <div class="flex border-b mb-6">
            <button class="tab-btn text-blue-600 font-semibold border-b-2 border-blue-600 px-4 py-2 focus:outline-none" data-tab="tab-data-diri">Data Diri</button>
            <button class="tab-btn text-gray-600 hover:text-blue-600 px-4 py-2 ml-4 focus:outline-none" data-tab="tab-nilai">Nilai</button>
            <button class="tab-btn text-gray-600 hover:text-blue-600 px-4 py-2 ml-4 focus:outline-none" data-tab="tab-password">Ubah Password</button>
        </div>

        <!-- Tab Content -->
        <div id="tab-data-diri" class="tab-content">
            <!-- ISI DATA DIRI -->
            <form action="{{ route('siswa.update.profil') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2 flex justify-center">
                        <div class="text-center">
                            <div class="w-24 h-24 rounded-full bg-gray-300 mx-auto mb-2 overflow-hidden">
                                @if ($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="w-24 h-24 object-cover rounded-full">
                                @endif
                            </div>
                            <label class="font-semibold cursor-pointer">
                                <span class="text-blue-600 hover:underline">Ubah Foto</span>
                                <input type="file" name="photo" class="hidden" accept="image/*">
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-500 text-sm">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent" value="{{ $user->nama_lengkap }}">
                    </div>

                    <div>
                        <label class="text-gray-500 text-sm">NISN</label>
                        <input type="text" class="w-full border-b border-gray-300 p-1 text-sm bg-transparent" value="{{ $user->id }}" readonly>
                    </div>

                    <div>
                        <label class="text-gray-500 text-sm">Email</label>
                        <input type="email" name="email" class="w-full border-b border-gray-300 p-1 text-sm bg-transparent" value="{{ $user->email }}">
                    </div>

                    <div>
                        <label class="text-gray-500 text-sm">No HP</label>
                        <input type="text" name="no_hp" class="w-full border-b border-gray-300 p-1 text-sm bg-transparent" value="{{ $user->no_hp ?? '' }}">
                    </div>

                    <div>
                        <label class="text-gray-500 text-sm">Kelas</label>
                        <input type="text" name="kelas" class="w-full border-b border-gray-300 p-1 text-sm bg-transparent" value="{{ $user->kelas ?? '' }}">
                    </div>

                    <div>
                        <label class="text-gray-500 text-sm">Status</label>
                        <input type="text" name="status" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent" value="{{ $user->status ?? 'Aktif' }}">
                    </div>

                    <div>
                        <label class="text-gray-500 text-sm">Angkatan</label>
                        <input type="text" name="angkatan" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent" value="{{ $user->angkatan ?? $user->created_at->format('Y') }}">
                    </div>

                    <div class="col-span-2 text-right mt-4">
                        <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="tab-nilai" class="tab-content hidden">
            <!-- ISI NILAI -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-gray-500 text-sm">Rata-rata Nilai Tugas</label>
                    <input type="text" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent" value="{{ $nilaiTugas ?? '-' }}" readonly>
                </div>

                <div>
                    <label class="text-gray-500 text-sm">Rata-rata Nilai Evaluasi</label>
                    <input type="text" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent" value="{{ $nilaiEvaluasi ?? '-' }}" readonly>
                </div>

                <div>
                    <label class="text-gray-500 text-sm">Rata-rata Nilai Kuis</label>
                    <input type="text" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent" value="{{ $nilaiKuis ?? '-' }}" readonly>
                </div>

                <div>
                    <label class="text-gray-500 text-sm">Rata-rata Nilai Tryout</label>
                    <input type="text" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent" value="{{ $nilaiTryout ?? '-' }}" readonly>
                </div>

                <div>
                    <label class="text-gray-500 text-sm">Prediksi Kelulusan</label>
                    <input type="text" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent text-green-600" value="Lulus" readonly>
                </div>
            </div>
        </div>

        <div id="tab-password" class="tab-content hidden">
            <!-- UBAH PASSWORD -->
            <form action="{{ route('siswa.update.password') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-gray-500 text-sm">Password Lama</label>
                        <input type="password" name="old_password" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent" required>
                    </div>

                    <div>
                        <label class="text-gray-500 text-sm">Password Baru</label>
                        <input type="password" name="new_password" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent" required>
                    </div>

                    <div>
                        <label class="text-gray-500 text-sm">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent" required>
                    </div>

                    <div class="col-span-2 text-right mt-4">
                        <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- SCRIPT TAB -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabButtons = document.querySelectorAll(".tab-btn");
        const tabContents = document.querySelectorAll(".tab-content");

        tabButtons.forEach((btn) => {
            btn.addEventListener("click", function () {
                const target = this.getAttribute("data-tab");

                // Reset semua tab
                tabButtons.forEach((b) => {
                    b.classList.remove("text-blue-600", "font-semibold", "border-blue-600");
                    b.classList.add("text-gray-600");
                    b.classList.remove("border-b-2");
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
