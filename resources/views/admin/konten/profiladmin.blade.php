@extends('admin.main.sidebar')

@section('content')
<main class="p-6 bg-[#F2F8FF] min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow">
        <!-- Tabs -->
        <div class="flex border-b mb-6">
            <button class="tab-btn text-[#0A58CA] font-semibold border-b-2 border-[#0A58CA] px-4 py-2 focus:outline-none" data-tab="tab-data-diri">Data Diri</button>
            <button class="tab-btn text-gray-600 hover:text-[#0A58CA] px-4 py-2 ml-4 focus:outline-none" data-tab="tab-password">Ubah Password</button>
        </div>

        <!-- Tab Content -->
        <div id="tab-data-diri" class="tab-content">
            <!-- ISI DATA DIRI -->
            <form action="{{ route('admin.update.profil') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Foto -->
                    <div class="col-span-2 flex justify-center">
                        <div class="text-center">
                            <div class="w-24 h-24 rounded-full bg-gray-300 mx-auto mb-2">
                                <!-- tampilkan foto jika ada -->
                                @if ($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover">
                                @endif
                            </div>
                            <input type="file" name="photo" class="text-sm text-gray-500">
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="text-gray-500 text-sm">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent">
                    </div>

                    <!-- ID / Username (readonly) -->
                    <div>
                        <label class="text-gray-500 text-sm">ID (Username)</label>
                        <input type="text" value="{{ $user->id }}" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent" readonly>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="text-gray-500 text-sm">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent">
                    </div>

                    <!-- No HP -->
                    <div>
                        <label class="text-gray-500 text-sm">No HP</label>
                        <input type="text" name="phone" value="{{ $user->phone ?? '' }}" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="text-gray-500 text-sm">Status</label>
                        <input type="text" name="status" value="{{ $user->status ?? '' }}" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent">
                    </div>

                    <!-- Tombol -->
                    <div class="col-span-2 text-right mt-4">
                        <button class="bg-[#0A58CA] text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="tab-password" class="tab-content hidden">
            <!-- Form Ubah Password -->
            <form action="{{ route('admin.update.password') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-gray-500 text-sm">Password Lama</label>
                        <input type="password" name="current_password" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent">
                    </div>

                    <div>
                        <label class="text-gray-500 text-sm">Password Baru</label>
                        <input type="password" name="new_password" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent">
                    </div>

                    <div>
                        <label class="text-gray-500 text-sm">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent">
                    </div>

                    <div class="col-span-2 text-right mt-4">
                        <button class="bg-[#0A58CA] text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Simpan Password</button>
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

                tabButtons.forEach((b) => {
                    b.classList.remove("text-[#0A58CA]", "font-semibold", "border-[#0A58CA]");
                    b.classList.add("text-gray-600");
                    b.classList.remove("border-b-2");
                });

                tabContents.forEach((content) => {
                    content.classList.add("hidden");
                });

                this.classList.remove("text-gray-600");
                this.classList.add("text-[#0A58CA]", "font-semibold", "border-b-2", "border-[#0A58CA]");
                document.getElementById(target).classList.remove("hidden");
            });
        });
    });
</script>
@endsection
