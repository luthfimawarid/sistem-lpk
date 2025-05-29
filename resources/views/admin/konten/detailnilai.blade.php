@extends('admin.main.sidebar')

@section('content')

<div class="p-4 sm:p-10 bg-blue-50 min-h-screen">

    <div class="bg-white p-6 rounded-lg shadow">
        <a href="/rapot-siswa" class="bg-[#0A58CA] py-2 px-4 text-white rounded">Kembali</a>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-6">
            <p class="font-semibold">Nama :</p>
            <p>{{ $user->nama_lengkap }}</p>
            <p class="font-semibold">Kelas :</p>
            <p>{{ $user->kelas ?? '-' }}</p>
            <p class="font-semibold">Prediksi Kelulusan :</p>
            <p class="text-red-600">-</p> {{-- Prediksi masih placeholder --}}
        </div>
    </div>

    <section class="my-6 w-full">
        <div class="bg-white rounded-lg shadow overflow-hidden pb-10">
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="text-white bg-[#0A58CA] text-sm sm:text-base">
                            <th class="py-5 px-3">No</th>
                            <th class="py-5 px-3">Tanggal</th>
                            <th class="py-5 px-3 text-center">Pelajaran</th>
                            <th class="py-5 px-3 text-center">Tipe</th>
                            <th class="py-5 px-3 text-center">Catatan</th>
                            <th class="py-5 px-3 text-center">Status</th>
                            <th class="py-5 px-3 text-center">Nilai</th>
                            <th class="py-5 px-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm sm:text-base">
                    @foreach ($dataTugas as $i => $tugas)
                        <tr class="border-t">
                            <td class="py-3 px-3 text-center">{{ $i + 1 }}</td>
                            <td class="py-3 px-3">{{ $tugas['tanggal'] }}</td>
                            <td class="py-3 px-3 text-center">{{ $tugas['pelajaran'] }}</td>
                            <td class="py-3 px-3 text-center">{{ ucfirst($tugas['tipe']) }}</td>
                            <td class="py-3 px-3 text-center">{{ $tugas['catatan'] }}</td>
                            <td class="py-3 px-3 text-center text-green-600">{{ $tugas['status'] }}</td>
                            <td class="py-3 px-3 text-center">{{ $tugas['nilai'] }}</td>
                            <td class="py-3 px-3 relative">
                                <div class="relative">
                                    <svg class="w-6 h-6 text-gray-800 cursor-pointer" onclick="toggleDropdown(this)" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14a2 2 0 100-4 2 2 0 000 4zm-7 0a2 2 0 100-4 2 2 0 000 4zm14 0a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                    <div class="dropdown hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-50">
                                        <ul class="py-1 text-gray-700">
                                            <li>
                                                <a href="{{ route('edit.rapot.tipe', ['id' => $user->id, 'tipe' => $tugas['tipe']]) }}" class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                                            </li>
                                            <li><a href="#" class="block px-4 py-2 hover:bg-red-100 text-red-600">Hapus</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function toggleDropdown(icon) {
        const dropdown = icon.nextElementSibling;
        dropdown.classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('td')) {
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                dropdown.classList.add('hidden');
            });
        }
    });
</script>
@endsection
