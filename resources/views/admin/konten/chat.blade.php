@extends('admin.main.sidebar')

@section('content')

<main class="p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg md:text-2xl font-semibold">Chat</h2>
            <button onclick="document.getElementById('modal-grup').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">+ Buat Grup</button>

            <div id="modal-grup" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-xl p-6 relative">
                    <h2 class="text-xl font-semibold mb-4">Buat Grup / Kelas</h2>
                    <form action="{{ route('chat.admin.createGroup') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Nama Grup (Kelas)</label>
                            <input type="text" name="kelas" class="w-full border p-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Pilih Siswa</label>
                            <div class="max-h-48 overflow-y-auto border rounded p-2">
                                @foreach($allStudents as $siswa)
                                    <label class="block mb-1">
                                        <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}" class="mr-2">
                                        {{ $siswa->nama_lengkap }} ({{ $siswa->kelas }})
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="document.getElementById('modal-grup').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Buat</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Input Pencarian -->
        <div class="relative mb-4">
            <input type="text" placeholder="Cari siswa..." class="w-full p-2 pl-10 border rounded-lg text-gray-600" />
            <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
            </svg>
        </div>

        <!-- Tabs -->
        <div class="border rounded-lg">
            <ul class="flex border-b bg-gray-100 overflow-x-auto">
                <li class="p-3 font-semibold"><a href="#tab-all" class="active-tab">All</a></li>
                @foreach ($groupedStudents as $className => $students)
                    <li class="p-3"><a href="#tab-{{ Str::slug($className) }}">{{ $className }}</a></li>
                @endforeach
            </ul>

            <!-- Tab All -->
            <div id="tab-all" class="p-4">
                @forelse($allStudents as $siswa)
                    <div class="flex items-center justify-between py-2 border-b">
                        <a href="{{ route('chat.admin.start', ['userId' => $siswa->id]) }}" class="w-full hover:bg-gray-100 transition rounded px-2">
                            <div class="flex items-center py-3 border-b">
                                <img src="/logo.png" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="font-bold">{{ $siswa->nama_lengkap }}</p>
                                    <p class="text-sm text-gray-500">{{ $siswa->kelas ?? '-' }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada siswa</p>
                @endforelse
                <!-- Daftar Grup -->
                @if($allGroups->isNotEmpty())
                    <h3 class="text-gray-700 font-semibold mt-6 mb-2">Grup / Kelas</h3>
                    @foreach($allGroups as $group)
                        <div class="flex items-center justify-between py-2 border-b">
                        <a href="{{ route('chat.admin.show', $group->id) }}">
                                <div class="flex items-center py-3 border-b">
                                    <img src="/logo.png" class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <p class="font-bold">{{ $group->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $group->users->count() }} anggota</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Tabs Per Kelas -->
            @foreach ($groupedStudents as $className => $students)
                <div id="tab-{{ Str::slug($className) }}" class="hidden p-4">
                    @forelse($students as $siswa)
                        <div class="flex items-center justify-between py-2 border-b">
                            <a href="{{ route('chat.admin.start', ['userId' => $siswa->id]) }}" class="w-full hover:bg-gray-100 transition rounded px-2">
                                <div class="flex items-center py-3 border-b">
                                    <img src="/logo.png" class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <p class="font-bold">{{ $siswa->nama_lengkap }}</p>
                                        <p class="text-sm text-gray-500">{{ $siswa->kelas ?? '-' }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada siswa di kelas ini.</p>
                    @endforelse
                </div>
            @endforeach
        </div>
    </div>
</main>

<style>
    .active-tab {
        color: #0A58CA;
        border-b-2 border-blue-600;
    }
</style>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('a[href^="#tab"]').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();

            // Hide all tab contents
            document.querySelectorAll('[id^="tab-"]').forEach(t => t.classList.add('hidden'));
            // Remove active state
            document.querySelectorAll('a[href^="#tab"]').forEach(t => t.classList.remove('active-tab'));
            // Show selected tab
            document.querySelector(this.getAttribute('href')).classList.remove('hidden');
            this.classList.add('active-tab');
        });
    });
</script>
@endsection