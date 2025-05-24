@extends('admin.main.sidebar')

@section('content')

<div class="p-10 bg-blue-50 min-h-screen">

    <section class="my-6 w-full">
        <div class="bg-white rounded-lg shadow h-auto overflow-hidden overflow-visible">
            <div class="flex justify-between mx-6 mt-5 pt-10 pb-2">
                <p class="text-xl font-semibold">Data Siswa</p>
                <div class="kanan flex">
                <a href="/" class="mx-2 pl-4 pr-2  text-sm text-[#0A58CA] rounded-full font-semibold mb-4 border border-[#0A58CA] flex items-center">
                    Sort By 
                        <svg class="w-8 h-8 text-[#0A58CA] dark:text-white ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10l4 4 4-4" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.siswa.create') }}" class="mx-2 pl-4 pr-2 py-2 text-sm text-[#0A58CA] rounded-full font-semibold mb-4 border border-[#0A58CA] flex items-center">
                        Tambah Siswa
                        <svg class="w-6 h-6 text-[#0A58CA] mx-1 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                        </svg>
                    </a>
                </div>
            </div>
            <table class="w-full">
                <thead>
                    <tr class="text-gray-600 bg-blue-50 text-left">
                        <th class="py-3 px-6">No</th>
                        <th class="py-3 px-6">Nama</th>
                        <th class="py-3 px-6">Password</th>
                        <th class="py-3 px-6">email</th>
                        <th class="py-3 px-6">Tanggal Lahir</th>
                        <th class="py-3 px-6">Kelas</th>
                        <th class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswas as $index => $siswa)
                        <tr class="border-t">
                            <td class="py-3 px-6">{{ $index + 1 }}</td>
                            <td class="py-3 px-6">{{ $siswa->nama_lengkap }}</td>
                            <td class="py-3 px-6">********</td> {{-- Password tidak ditampilkan --}}
                            <td class="py-3 px-6">{{ $siswa->email }}</td>
                            <td class="py-3 px-6">{{ $siswa->tanggal_lahir ?? '-' }}</td>
                            <td class="py-3 px-6">{{ $siswa->kelas }}</td>
                            <td class="py-3 px-6 relative">
                                <div class="relative ml-1">
                                    <!-- Icon Ellipsis -->
                                    <svg class="w-6 h-6 text-gray-800 cursor-pointer" onclick="toggleDropdown(this)" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14a2 2 0 100-4 2 2 0 000 4zm-7 0a2 2 0 100-4 2 2 0 000 4zm14 0a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                    
                                    <!-- Dropdown Menu -->
                                    <div class="dropdown hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-50">
                                        <ul class="py-1 text-gray-700">
                                            <li><a href="{{ route('admin.siswa.detail', $siswa->id) }}" class="block px-4 py-2 hover:bg-gray-100">Lihat Detail Siswa</a></li>
                                            <li><a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="block px-4 py-2 hover:bg-gray-100">Edit</a></li>
                                            <li>
                                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-100">Hapus</button>
                                                </form>
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
