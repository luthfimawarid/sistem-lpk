@extends('admin.main.sidebar')

@section('content')

<div class="p-4 sm:p-6 md:p-10 bg-blue-50 min-h-screen">
    <section class="my-6 w-full">
        <div class="bg-white rounded-lg shadow h-auto overflow-hidden">
            <!-- Header -->
            <div class="flex flex-row justify-between items-center mx-4 md:mx-6 my-5 py-3 pb-2 space-y-0">
                <p class="text-lg md:text-xl font-semibold">Data Siswa</p>
                <a href="{{ route('admin.siswa.create') }}" class="flex items-center text-sm bg-[#0A58CA] text-white rounded-full px-4 py-2 font-medium">
                    Tambah Siswa
                    <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                    </svg>
                </a>
            </div>

            <!-- Table Wrapper -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-sm md:text-base">
                    <thead>
                        <tr class="text-gray-600 bg-blue-50 text-left">
                            <th class="py-3 px-4 md:px-6">No</th>
                            <th class="py-3 px-4 md:px-6">Nama</th>
                            <th class="py-3 px-4 md:px-6">Password</th>
                            <th class="py-3 px-4 md:px-6">Email</th>
                            <th class="py-3 px-4 md:px-6">Tanggal Lahir</th>
                            <th class="py-3 px-4 md:px-6">Kelas</th>
                            <th class="py-3 px-4 md:px-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswas as $index => $siswa)
                            <tr class="border-t">
                                <td class="py-3 px-4 md:px-6">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 md:px-6">{{ $siswa->nama_lengkap }}</td>
                                <td class="py-3 px-4 md:px-6">{{ $siswa->password }}</td>
                                <td class="py-3 px-4 md:px-6">{{ $siswa->email }}</td>
                                <td class="py-3 px-4 md:px-6">{{ $siswa->tanggal_lahir ?? '-' }}</td>
                                <td class="py-3 px-4 md:px-6">{{ $siswa->kelas }}</td>
                                <td class="py-3 px-4 md:px-6 relative">
                                    <div class="relative inline-block text-left">
                                        <svg class="w-6 h-6 text-gray-800 cursor-pointer" onclick="toggleDropdown(this)" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 14a2 2 0 100-4 2 2 0 000 4zm-7 0a2 2 0 100-4 2 2 0 000 4zm14 0a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>

                                        <!-- Dropdown Menu -->
                                        <div class="dropdown hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-50">
                                            <ul class="py-1 text-gray-700">
                                                <li><a href="{{ route('admin.siswa.detail', $siswa->id) }}" class="block px-4 py-2 hover:bg-gray-100">Lihat Detail</a></li>
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
