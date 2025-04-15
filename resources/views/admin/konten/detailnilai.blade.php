@extends('admin.main.sidebar')

@section('content')

<div class="p-4 sm:p-10 bg-blue-50 min-h-screen">

    <div class="bg-white p-6 rounded-lg shadow">
        <a href="/rapot-siswa" class="bg-[#0A58CA] py-2 px-4 text-white rounded">Kembali</a>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-6">
            <p class="font-semibold">Nama :</p>
            <p>Alamsyah</p>
            <p class="font-semibold">Kelas :</p>
            <p>YOZORA</p>
            <p class="font-semibold">Nilai Bahasa :</p>
            <p>68</p>
            <p class="font-semibold">Nilai Budaya :</p>
            <p>88</p>
            <p class="font-semibold">Prediksi Kelulusan :</p>
            <p class="text-red-600">Beresiko</p>
        </div>
    </div>

    <section class="my-6 w-full">
        <div class="bg-white rounded-lg shadow overflow-hidden pb-10">
            <div class="flex flex-wrap justify-between mx-6 mt-5 pt-10 pb-2 gap-2">
                <p class="text-xl font-semibold">Daftar Nilai</p>
                <div class="kanan flex gap-2">
                    <a href="/" class="flex items-center px-3 py-1 text-sm text-[#0A58CA] rounded-full font-semibold border border-[#0A58CA]">
                        Sort By 
                        <svg class="w-5 h-5 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10l4 4 4-4" />
                        </svg>
                    </a>
                    <a href="/" class="px-3 py-1 text-sm text-[#0A58CA] rounded-full font-semibold border border-[#0A58CA]">Terbitkan Rapot</a>
                </div>
            </div>

            <!-- Membuat tabel responsif -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="text-gray-600 bg-blue-50 text-sm sm:text-base">
                            <th class="py-3 px-3">No</th>
                            <th class="py-3 px-3">Tanggal</th>
                            <th class="py-3 px-3 text-center">Pelajaran</th>
                            <th class="py-3 px-3 text-center">Tipe</th>
                            <th class="py-3 px-3 text-center">Catatan</th>
                            <th class="py-3 px-3 text-center">Status</th>
                            <th class="py-3 px-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm sm:text-base">
                        @for ($i = 1; $i <= 3; $i++)
                        <tr class="border-t">
                            <td class="py-3 px-3 text-center">{{ $i }}</td>
                            <td class="py-3 px-3">0{{ $i }} Maret 2025</td>
                            <td class="py-3 px-3 text-center">64</td>
                            <td class="py-3 px-3 text-center">88</td>
                            <td class="py-3 px-3 text-center">Beresiko, Belajar lagi</td>
                            <td class="py-3 px-3 text-center text-green-600">Sudah dikoreksi</td>
                            <td class="py-3 px-3 relative">
                                <div class="relative">
                                    <svg class="w-6 h-6 text-gray-800 cursor-pointer" onclick="toggleDropdown(this)" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14a2 2 0 100-4 2 2 0 000 4zm-7 0a2 2 0 100-4 2 2 0 000 4zm14 0a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                    <div class="dropdown hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-50">
                                        <ul class="py-1 text-gray-700">
                                            <li><a href="/detail-nilai" class="block px-4 py-2 hover:bg-gray-100">Lihat Detail Nilai</a></li>
                                            <li><a href="/edit-rapot" class="block px-4 py-2 hover:bg-gray-100">Edit</a></li>
                                            <li><a href="#" class="block px-4 py-2 hover:bg-red-100 text-red-600">Hapus</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endfor
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
