@extends('admin.main.sidebar')

@section('content')

<div class="p-4 bg-blue-50 min-h-screen">

    <section class="my-6 w-full">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden overflow-visible">
            <div class="flex md:flex-row justify-between items-start md:items-left mx-4 my-5 pt-6 pb-2">
                <!-- Teks Data Siswa di kiri -->
                <p class="text-xl font-semibold">Data Siswa</p>

            </div>

                <table class="min-w-full">
                    <thead>
                        <tr class="text-gray-600 bg-blue-50">
                            <th class="py-3 px-4 text-left">Nama</th>
                            <th class="py-3 px-4 text-left">Kelas</th>
                            <th class="py-3 px-4 text-left">Nilai Tugas</th>
                            <th class="py-3 px-4 text-left">Nilai Evaluasi</th>
                            <th class="py-3 px-4 text-left">Nilai Tryout</th>
                            <th class="py-3 px-4 text-left">Prediksi</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $item)
                        <tr class="border-t">
                            <td class="py-3 px-4">{{ $item['nama'] }}</td>
                            <td class="py-3 px-4">{{ $item['kelas'] }}</td>
                            <td class="py-3 px-4 text-left">{{ $item['nilai_tugas'] }}</td>
                            <td class="py-3 px-4 text-left">{{ $item['nilai_evaluasi'] }}</td>
                            <td class="py-3 px-4 text-left">{{ $item['nilai_tryout'] }}</td>
                            <td class="py-3 px-4 text-left">{{ $item['prediksi'] }}</td>
                            <td class="py-3 px-4 relative">
                                <div class="relative">
                                    <svg class="w-6 h-6 text-gray-800 cursor-pointer" onclick="toggleDropdown(this)" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14a2 2 0 100-4 2 2 0 000 4zm-7 0a2 2 0 100-4 2 2 0 000 4zm14 0a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>

                                    <div class="dropdown hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-50">
                                        <ul class="py-1 text-gray-700">
                                            <li><a href="{{ route('detail.nilai', ['id' => $item['id']]) }}" class="block px-4 py-2 hover:bg-gray-100">Lihat Detail Nilai</a></li>
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
