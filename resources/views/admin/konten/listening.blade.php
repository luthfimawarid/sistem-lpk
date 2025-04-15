@extends('admin.main.sidebar')

@section('content')

<main class="p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        
        <div class="flex space-x-2 md:order-2">
            <a href="/tambah-elistening" class="border-2 border-blue-600 text-blue-600 font-semibold text-xs md:text-lg px-4 py-2 flex items-center rounded-lg">
                Tambah Listening
                <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7 7V5"/>
                </svg>
            </a>
            <button class="border-2 border-blue-600 text-blue-600 font-semibold text-xs md:text-lg px-4 py-2 flex items-center rounded-lg">
                Sort By
                <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8 10 4 4 4-4"/>
                </svg>
            </button>
        </div>
    </div>

    <h2 id="listening-count" class="md:text-lg font-semibold my-2 md:my-0 md:order-1">Listening (0)</h2>
    <div id="listening-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"></div>

</main>

@endsection

@section('scripts')
<script>
    // Data listening (contoh tanpa backend)
    const listening = [
        { title: "Belajar Hiragana", author: "Nakamura", cover: "/logo.png", audio: "/audio/hiragana.mp3" },
        { title: "Kanji Dasar", author: "Yamada", cover: "/logo.png", audio: "/audio/kanji.mp3" },
        { title: "Bahasa Jepang Pemula", author: "Tanaka", cover: "/logo.png", audio: "/audio/jepang-pemula.mp3" },
        { title: "Kosakata N5", author: "Fujimoto", cover: "/logo.png", audio: "/audio/kosakata-n5.mp3" },
    ];

    // Update jumlah listening di judul
    document.getElementById("listening-count").textContent = `Listening (${listening.length})`;

    // Generate kartu listening
    const listeningList = document.getElementById("listening-list");

    listening.forEach(listen => {
        const listeningCard = `
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="${listen.cover}" alt="Cover ${listen.title}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">${listen.title}</h3>
                    <p class="text-xs md:text-lg text-gray-600 mt-2">By ${listen.author}</p>

                    <!-- Pemutar audio -->
                    <audio controls class="w-full mt-4">
                        <source src="${listen.audio}" type="audio/mpeg">
                        Browser Anda tidak mendukung pemutar audio.
                    </audio>
                    
                    <!-- Tombol Edit & Hapus -->
                    <div class="mt-4 flex justify-between items-center">
                        <div class="flex space-x-2">
                            <a href="/edit-listening" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-xs md:text-lg">Edit</a>
                            <button onclick="deleteListening('${listen.title}')" class="bg-red-500 text-white px-4 py-2 rounded-lg text-xs md:text-lg">Hapus</button>
                        </div>
                        <p class="text-xs md:text-lg italic">Aktif</p>
                    </div>
                </div>
            </div>
        `;
        listeningList.innerHTML += listeningCard;
    });

    function deleteListening(title) {
        alert(`Menghapus listening: ${title}`);
        // Di sini bisa ditambahkan fungsi untuk menghapus dari backend
    }
</script>
@endsection
