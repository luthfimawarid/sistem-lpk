@extends('admin.main.sidebar')

@section('content')
<main class="p-4 sm:p-6 bg-[#F2F8FF] min-h-screen">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-4">
                @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow max-w-6xl mx-auto">
        <!-- Tabs -->
        <div class="flex flex-col sm:flex-row border-b mb-6 space-y-2 sm:space-y-0 sm:space-x-4">
            <button class="tab-btn text-[#0A58CA] font-semibold border-b-2 border-[#0A58CA] px-4 py-2 focus:outline-none" data-tab="tab-data-diri">
                Data Diri
            </button>
            <button class="tab-btn text-gray-600 hover:text-[#0A58CA] px-4 py-2 focus:outline-none" data-tab="tab-password">
                Ubah Password
            </button>
        </div>

        <!-- Tab: Data Diri -->
        <div id="tab-data-diri" class="tab-content">
            <form action="{{ route('admin.update.profil') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Foto -->
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 flex justify-center">
                        <div class="text-center space-y-2">
                            <div class="w-24 h-24 rounded-full bg-gray-300 mx-auto overflow-hidden">
                                @if ($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover">
                                @else
                                    <img src="/default-profile.png" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover">
                                @endif
                            </div>

                            <!-- Teks Ubah Foto -->
                            <label for="photoInput" class="text-blue-600 text-sm cursor-pointer underline hover:text-blue-800 transition">
                                Ubah Foto
                            </label>
                            
                            <!-- Input File (disembunyikan) -->
                            <input type="file" id="photoInput" name="photo" class="hidden">
                        </div>
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="text-gray-500 text-sm">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent">
                    </div>

                    <!-- ID / Username -->
                    <div>
                        <label class="text-gray-500 text-sm">ID (Username)</label>
                        <input type="text" value="{{ $user->id }}" readonly class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="text-gray-500 text-sm">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent">
                    </div>

                    <!-- No HP -->
                    <div>
                        <label class="text-gray-500 text-sm">No HP</label>
                        <input type="text" name="no_hp" value="{{ $user->no_hp ?? '' }}" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="text-gray-500 text-sm">Status</label>
                        <input type="text" name="status" value="{{ $user->status ?? '' }}" class="w-full border-b border-gray-300 p-1 text-sm outline-none bg-transparent">
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-right mt-4">
                        <button type="submit" class="bg-[#0A58CA] text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tab: Password -->
        <div id="tab-password" class="tab-content hidden">
            <form action="{{ route('admin.update.password') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-4">
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

                    <!-- Tombol Simpan -->
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-right mt-4">
                        <button type="submit" class="bg-[#0A58CA] text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            Simpan Password
                        </button>
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
                    b.classList.remove("text-[#0A58CA]", "font-semibold", "border-b-2", "border-[#0A58CA]");
                    b.classList.add("text-gray-600");
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
