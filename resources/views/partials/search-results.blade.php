<div class="space-y-4 ml-6">
    <h2 class="text-lg font-semibold pt-4">Hasil Pencarian</h2>

    {{-- Siswa --}}
    @if($students->isNotEmpty() || $chats->isNotEmpty())
        <div>
        <h3 class="text-lg font-semibold">Chat / Siswa</h3>
        <div class="border rounded-xl py-3 mr-6">
            @forelse($chats as $room)
            @php
                $other = $room->users->where('id','!=', auth()->id())->first();
                $name = $other->nama_lengkap;
                $last = $room->messages->first()?->message ?? 'Belum ada pesan';
                $time = optional($room->messages->first()?->created_at)->format('H:i');
                $route = $other
                ? route('chat.admin.start', ['userId' => $other->id])
                : '#';
            @endphp
            <a href="{{ $route }}" class="chat-item bg-white block hover:bg-gray-100 transition duration-200" data-type="siswa">
                <div class="flex items-center justify-between px-3 py-3">
                <div class="flex items-center gap-3">
                    <img src="/logo.png" class="w-10 h-10 border-2 rounded-full object-cover" alt="foto"/>
                    <div>
                    <h3 class="room-name font-bold truncate">{{ $name }}</h3>
                    <p class="message-preview text-gray-600 truncate">{{ $last }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-gray-400">{{ $time }}</span>
                </div>
                </div>
            </a>
            @empty
            @foreach($students as $s)
                <a href="{{ route('chat.admin.start',['userId'=>$s->id]) }}"
                class="chat-item block hover:bg-gray-100 transition duration-200" data-type="siswa">
                <div class="flex items-center justify-between px-3 py-3">
                    <div class="flex items-center gap-3">
                    <img src="/logo.png" class="w-10 h-10 border-2 rounded-full object-cover" alt="foto"/>
                    <div>
                        <h3 class="room-name font-bold truncate">{{ $s->nama_lengkap }}</h3>
                        <p class="message-preview text-gray-600 truncate">Mulai chat</p>
                    </div>
                    </div>
                    <div class="text-right"><span class="text-gray-400">--:--</span></div>
                </div>
                </a>
            @endforeach
            @endforelse
        </div>
        </div>
    @endif

    {{-- Tugas --}}
    @if($ujianAkhir->isNotEmpty() || $tugasList->isNotEmpty() || $kuisList->isNotEmpty() || $evaluasiList->isNotEmpty() || $tryoutList->isNotEmpty())
        <h3 class="text-lg font-semibold">Tugas</h3>

        {{-- Ujian Akhir --}}
        @if($ujianAkhir->isNotEmpty())
            <section class="mb-4">
                <h4 class="text-md font-semibold mb-2">Ujian Akhir ({{ $ujianAkhir->count() }})</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($ujianAkhir as $item)
                        <div class="bg-white rounded-lg shadow p-4 text-center hover:shadow-md transition h-full flex flex-col">
                            <a href="{{ route('admin.ujian.detail', $item->id) }}" class="flex-grow">
                                <img src="{{ asset('/logo.png') }}" alt="Evaluasi" class="mx-auto rounded-md h-40 object-cover">
                                <p class="mt-2 font-medium text-blue-600">{{ $item->judul }}</p>
                                <p class="text-sm text-gray-600">Deadline: {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Tugas --}}
        @if($tugasList->isNotEmpty())
            <section class="mb-4">
                <h4 class="text-md font-semibold mb-2">Tugas</h4>
                <div class="flex flex-col gap-4 lg:flex-row lg:overflow-x-auto lg:space-x-4">
                    @foreach($tugasList as $item)
                        <div class="flex-shrink-0 w-full lg:w-64">
                            <div class="bg-white rounded-lg shadow p-4 text-center hover:shadow-md transition">
                                <a href="{{ route('tugas.pengumpulan', $item->id) }}">
                                    <img src="{{ asset('/logo.png') }}" alt="Tugas" class="mx-auto rounded-md h-40 object-cover">
                                    <p class="mt-2 font-medium">{{ $item->judul }}</p>
                                    <p class="text-sm text-gray-600">Deadline: {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Kuis --}}
        @if($kuisList->isNotEmpty())
            <section class="mb-4">
                <h4 class="text-md font-semibold mb-2">Kuis Harian</h4>
                <div class="flex flex-col gap-4 lg:flex-row lg:overflow-x-auto lg:space-x-4">
                    @foreach($kuisList as $item)
                        <div class="flex-shrink-0 w-full lg:w-64">
                            <div class="bg-white rounded-lg shadow p-4 text-center hover:shadow-md transition">
                                <a href="{{ route('admin.kuis.detail', $item->id) }}">
                                    <img src="{{ asset('/logo.png') }}" alt="Kuis" class="mx-auto rounded-md h-40 object-cover">
                                    <p class="mt-2 font-medium">{{ $item->judul }}</p>
                                    <p class="text-sm text-gray-600">Deadline: {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Evaluasi Mingguan --}}
        @if($evaluasiList->isNotEmpty())
            <section class="mb-4">
                <h4 class="text-md font-semibold mb-2">Evaluasi Mingguan</h4>
                <div class="flex flex-col gap-4 lg:flex-row lg:overflow-x-auto lg:space-x-4">
                    @foreach($evaluasiList as $item)
                        <div class="flex-shrink-0 w-full lg:w-64">
                            <div class="bg-white rounded-lg shadow p-4 text-center hover:shadow-md transition">
                                <a href="{{ route('tugas.pengumpulan', $item->id) }}">
                                    <img src="{{ asset('/logo.png') }}" alt="Evaluasi" class="mx-auto rounded-md h-40 object-cover">
                                    <p class="mt-2 font-medium">{{ $item->judul }}</p>
                                    <p class="text-sm text-gray-600">Deadline: {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Tryout --}}
        @if($tryoutList->isNotEmpty())
            <section class="mb-4">
                <h4 class="text-md font-semibold mb-2">Tryout</h4>
                <div class="flex flex-col gap-4 lg:flex-row lg:overflow-x-auto lg:space-x-4">
                    @foreach($tryoutList as $item)
                        <div class="flex-shrink-0 w-full lg:w-64">
                            <div class="bg-white rounded-lg shadow p-4 text-center hover:shadow-md transition">
                                <a href="{{ route('admin.tryout.detail', $item->id) }}">
                                    <img src="{{ asset('/logo.png') }}" alt="Tryout" class="mx-auto rounded-md h-40 object-cover">
                                    <p class="mt-2 font-medium">{{ $item->judul }}</p>
                                    <p class="text-sm text-gray-600">Deadline: {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    @endif

    {{-- EBOOK --}}
    @if($materiEbook->isNotEmpty())
        <div>
            <h3 class="text-lg font-semibold">Materi - Ebook</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($materiEbook as $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('/logo.png') }}" alt="Cover" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $item->judul }}</h3>
                            <p class="text-gray-600 mt-2">By {{ $item->author }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- LISTENING --}}
    @if($materiListening->isNotEmpty())
        <div>
            <h3 class="text-lg font-semibold">Materi - Listening</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($materiListening as $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('/logo.png') }}" alt="Cover" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $item->judul }}</h3>
                            <p class="text-xs text-gray-600 mt-2">By {{ $item->author }}</p>
                            <audio controls class="w-full mt-4">
                                <source src="{{ asset('storage/materi/'.$item->file) }}" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- VIDEO --}}
    @if($materiVideo->isNotEmpty())
        <div>
            <h3 class="text-lg font-semibold">Materi - Video</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($materiVideo as $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="aspect-video bg-black">
                            <video controls class="w-full h-full object-cover">
                                <source src="{{ asset('storage/materi/'.$item->file) }}" type="video/mp4">
                            </video>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $item->judul }}</h3>
                            <p class="text-xs text-gray-600 mt-2">By {{ $item->author }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    switchTab('siswa'); // default filter
  });
  function switchTab(type) {
    const chats = document.querySelectorAll('.chat-item');
    chats.forEach(c => c.style.display = (type==='semua' || c.dataset.type===type) ? 'block':'none');
    // highlight tab button jika ada UI tab
  }
</script>
