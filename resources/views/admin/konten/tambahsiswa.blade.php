@extends('admin.main.sidebar')

@section('content')
<div class="p-4 md:p-8 lg:p-10 bg-blue-50 min-h-screen">
    <h1 class="text-xl md:text-2xl font-semibold mb-6 text-center md:text-left">Tambah Siswa Baru</h1>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error global --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-4 md:p-6 rounded-lg shadow-md w-full max-w-full md:w-full lg:w-full mx-auto">
        <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-4">
                {{-- Nama Lengkap --}}
                <div>
                    <label for="nama_lengkap" class="block font-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="w-full border rounded p-2" required value="{{ old('nama_lengkap') }}">
                    @error('nama_lengkap')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label for="tanggal_lahir" class="block font-medium mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="w-full border rounded p-2" value="{{ old('tanggal_lahir') }}">
                    @error('tanggal_lahir')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block font-medium mb-1">Email</label>
                    <input type="email" name="email" id="email" class="w-full border rounded p-2" required value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block font-medium mb-1">Password</label>
                    <input type="password" name="password" id="password" class="w-full border rounded p-2" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div>
                    <label for="kelas" class="block font-medium mb-1">Kelas</label>
                    <input type="text" name="kelas" id="kelas" class="w-full border rounded p-2" required value="{{ old('kelas') }}">
                    @error('kelas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bidang --}}
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

                <div>
                    <label for="bidang" class="block font-medium mb-1">Bidang</label>
                    <select name="bidang" id="bidang" class="w-full border rounded p-2" required>
                        <option value="">-- Pilih Bidang --</option>
                        @foreach($listBidang as $bidang)
                            <option value="{{ $bidang }}" {{ old('bidang') == $bidang ? 'selected' : '' }}>{{ $bidang }}</option>
                        @endforeach
                    </select>
                    @error('bidang')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Foto --}}
                <div>
                    <label for="foto" class="block font-medium mb-1">Foto (Opsional)</label>
                    <input type="file" name="foto" id="foto" class="w-full">
                    @error('foto')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dokumen --}}
                <div>
                    <label class="block font-medium mb-2">Dokumen Pendukung</label>

                    @php
                        $dokumenList = ['Paspor', 'Visa', 'MCU', 'TTD Kontrak', 'Izin Tinggal', 'E-KTLN', 'Tiket Pesawat'];
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($dokumenList as $dokumen)
                            <div>
                                <label class="block font-medium mb-1">{{ $dokumen }}</label>
                                <input type="file" name="dokumen[{{ $dokumen }}]" class="w-full border rounded p-2">
                                @error("dokumen.$dokumen")
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="pt-4 flex">
                    <a href="{{ route('admin.siswa.index') }}"
                    class="inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-gray-400 transition">
                        Batal
                    </a>
                    <button type="submit" class="mx-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-300">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
