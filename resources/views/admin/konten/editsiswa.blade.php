@extends('admin.main.sidebar')

@section('content')
<div class="p-4 md:p-8 lg:p-10 bg-blue-50 min-h-screen">
    <h1 class="text-xl md:text-2xl font-semibold mb-6 text-center md:text-left">Edit Siswa: {{ $siswa->nama_lengkap }}</h1>

    <div class="bg-white p-4 md:p-6 rounded-lg shadow-md w-full max-w-full md:w-full lg:w-full mx-auto">
        <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="nama_lengkap" class="block font-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label for="tanggal_lahir" class="block font-medium mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" class="w-full border rounded p-2">
                </div>

                <div>
                    <label for="email" class="block font-medium mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $siswa->email) }}" class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label for="password" class="block font-medium mb-1">Password Baru (opsional)</label>
                    <input type="password" name="password" id="password" class="w-full border rounded p-2" placeholder="Biarkan kosong jika tidak diganti">
                </div>

                <div>
                    <label for="kelas" class="block font-medium mb-1">Kelas</label>
                    <input type="text" name="kelas" id="kelas" value="{{ old('kelas', $siswa->kelas) }}" class="w-full border rounded p-2" required>
                </div>

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
                            <option value="{{ $bidang }}" {{ old('bidang', $siswa->bidang) == $bidang ? 'selected' : '' }}>{{ $bidang }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="foto" class="block font-medium mb-1">Ganti Foto (opsional)</label>
                    <input type="file" name="foto" id="foto" class="w-full">
                    @if($siswa->foto)
                        <p class="mt-2 text-sm">Foto saat ini: <a href="{{ asset('storage/' . $siswa->foto) }}" target="_blank" class="text-blue-600 underline">Lihat</a></p>
                    @endif
                </div>

                @php
                    $dokumenList = ['Paspor', 'Visa', 'MCU', 'TTD Kontrak', 'Izin Tinggal', 'E-KTLN', 'Tiket Pesawat'];
                @endphp

                <div>
                    <label class="block font-medium mb-2">Dokumen Pendukung</label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($dokumenList as $dokumen)
                            <div>
                                <label class="block font-medium mb-1">{{ $dokumen }}</label>
                                <input type="file" name="dokumen[{{ $dokumen }}]" class="w-full border rounded p-2">
                                @php
                                    $dokumenKey = Str::slug($dokumen, '_'); // contoh: "Paspor" → "paspor"
                                @endphp
                                @if(isset($siswa->dokumen[$dokumenKey]))
                                    <p class="text-sm mt-1">
                                        File saat ini: 
                                        <a href="{{ asset('storage/' . $siswa->dokumen[$dokumenKey]) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-300">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
