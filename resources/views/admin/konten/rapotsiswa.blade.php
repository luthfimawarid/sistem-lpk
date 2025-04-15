@extends('admin.main.sidebar')

@section('content')

<div class="p-4 bg-blue-50 min-h-screen">

    <section class="my-6 w-full">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="flex md:flex-row justify-between items-start md:items-center mx-4 mt-5 pt-6 pb-2">
                <!-- Teks Data Siswa di kiri -->
                <p class="text-xl font-semibold">Data Siswa</p>

                <!-- Bagian kanan dengan tombol atas-bawah di mobile, sejajar di desktop -->
                <div class="flex flex-col md:flex-row items-end md:items-center gap-2 md:gap-4">
                    <a href="/" class="flex items-center px-2 py-1 text-sm text-[#0A58CA] rounded-full font-semibold border border-[#0A58CA] w-fit">
                        Sort By 
                        <svg class="w-4 h-4 text-[#0A58CA] ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10l4 4 4-4" />
                        </svg>
                    </a>
                    <a href="/" class="px-2 py-1 text-sm text-[#0A58CA] rounded-full font-semibold border border-[#0A58CA] w-fit">
                        Terbitkan Rapot
                    </a>
                </div>
            </div>




            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="text-gray-600 bg-blue-50">
                            <th class="py-3 px-4 text-left">Nama</th>
                            <th class="py-3 px-4 text-center">Kelas</th>
                            <th class="py-3 px-4 text-center">Bahasa</th>
                            <th class="py-3 px-4 text-center">Budaya</th>
                            <th class="py-3 px-4 text-center">Prediksi</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t">
                            <td class="py-3 px-4">Luthfi</td>
                            <td class="py-3 px-4 text-center">Kelas NIRUMA</td>
                            <td class="py-3 px-4 text-center">64</td>
                            <td class="py-3 px-4 text-center">88</td>
                            <td class="py-3 px-4 text-center">Beresiko</td>
                            <td class="py-3 px-4 relative">
                                <div class="relative ml-4">
                                    <!-- Icon Ellipsis -->
                                    <svg class="w-6 h-6 text-gray-800 cursor-pointer" onclick="toggleDropdown(this)" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14a2 2 0 100-4 2 2 0 000 4zm-7 0a2 2 0 100-4 2 2 0 000 4zm14 0a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                    
                                    <!-- Dropdown Menu -->
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
                        <tr class="border-t">
                            <td class="py-3 px-4">Putra</td>
                            <td class="py-3 px-4 text-center">Kelas SANJIRO</td>
                            <td class="py-3 px-4 text-center">64</td>
                            <td class="py-3 px-4 text-center">88</td>
                            <td class="py-3 px-4 text-center">Beresiko</td>
                            <td class="py-3 px-4 relative">
                                <div class="relative ml-4">
                                    <!-- Icon Ellipsis -->
                                    <svg class="w-6 h-6 text-gray-800 cursor-pointer" onclick="toggleDropdown(this)" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14a2 2 0 100-4 2 2 0 000 4zm-7 0a2 2 0 100-4 2 2 0 000 4zm14 0a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                    
                                    <!-- Dropdown Menu -->
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
