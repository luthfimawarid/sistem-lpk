@extends('admin.main.sidebar')

@section('content')

<div class="p-4 bg-blue-50 min-h-screen">

    <section class="my-6 w-full">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center px-4 pt-6 pb-2">
                <!-- Judul -->
                <p class="text-lg md:text-xl font-semibold mb-2 md:mb-0">Data Siswa</p>
            </div>

            <!-- Scroll wrapper for responsiveness -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm md:text-base">
                    <thead>
                        <tr class="text-gray-600 bg-blue-50">
                            <th class="py-3 px-4 text-left whitespace-nowrap">Nama</th>
                            <th class="py-3 px-4 text-left whitespace-nowrap">Kelas</th>
                            <th class="py-3 px-4 text-left whitespace-nowrap">Nilai Tugas</th>
                            <th class="py-3 px-4 text-left whitespace-nowrap">Nilai Evaluasi</th>
                            <th class="py-3 px-4 text-left whitespace-nowrap">Nilai Tryout</th>
                            <th class="py-3 px-4 text-left whitespace-nowrap">Prediksi</th>
                            <th class="py-3 px-4 text-left whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $item)
                        <tr class="border-t">
                            <td class="py-3 px-4 whitespace-nowrap">{{ $item['nama'] }}</td>
                            <td class="py-3 px-4 whitespace-nowrap">{{ $item['kelas'] }}</td>
                            <td class="py-3 px-4 whitespace-nowrap">{{ $item['nilai_tugas'] }}</td>
                            <td class="py-3 px-4 whitespace-nowrap">{{ $item['nilai_evaluasi'] }}</td>
                            <td class="py-3 px-4 whitespace-nowrap">{{ $item['nilai_tryout'] }}</td>
                            <td class="py-3 px-4 whitespace-nowrap">{{ $item['prediksi'] }}</td>
                            <td class="py-3 px-4 relative whitespace-nowrap">
                                <div class="relative">
                                    <!-- Ellipsis Icon -->
                                    <svg class="w-6 h-6 text-gray-800 cursor-pointer" onclick="toggleDropdown(this)" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14a2 2 0 100-4 2 2 0 000 4zm-7 0a2 2 0 100-4 2 2 0 000 4zm14 0a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>

                                    <!-- Dropdown Menu -->
                                    <div class="dropdown hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-50">
                                        <ul class="py-1 text-gray-700">
                                            <li>
                                                <a href="{{ route('detail.nilai', ['id' => $item['id']]) }}" class="block px-4 py-2 hover:bg-gray-100">
                                                    Lihat Detail Nilai
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="block px-4 py-2 hover:bg-red-100 text-red-600">
                                                    Hapus
                                                </a>
                                            </li>
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
