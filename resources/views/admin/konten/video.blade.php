@extends('admin.main.sidebar')

@section('content')

<main class="p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        
        <div class="flex space-x-2 md:order-2">
            <a href="/tambah-eVideo" class="border-2 border-blue-600 text-blue-600 font-semibold text-xs md:text-lg px-4 py-2 flex items-center rounded-lg">
                Tambah Video
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

    <h2 id="Video-count" class="md:text-lg font-semibold my-2 md:my-0 md:order-1">Video (0)</h2>
    <div id="Video-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"></div>

</main>

@endsection

@section('scripts')
<script>
    // Data Video (contoh tanpa backend)
    const Video = [
        { title: "Belajar Hiragana", author: "Nakamura", cover: "/logo.png", video: "/video/hiragana.mp3" },
        { title: "Kanji Dasar", author: "Yamada", cover: "/logo.png", video: "/video/kanji.mp3" },
        { title: "Bahasa Jepang Pemula", author: "Tanaka", cover: "/logo.png", video: "/video/jepang-pemula.mp3" },
        { title: "Kosakata N5", author: "Fujimoto", cover: "/logo.png", video: "/video/kosakata-n5.mp3" },
    ];

    // Update jumlah Video di judul
    document.getElementById("Video-count").textContent = `Video (${Video.length})`;

    // Generate kartu Video
    const VideoList = document.getElementById("Video-list");

    Video.forEach(video => {
        const VideoCard = `
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="">
                
                <!-- Pemutar video -->
                <video controls class="w-full">
                    <source src="${video.video}" type="video/mpeg">
                    Browser Anda tidak mendukung pemutar video.
                </video>
                
                    <h3 class="text-lg font-semibold mx-4 mt-4">${video.title}</h3>
                    <p class="text-xs md:text-lg text-gray-600 mx-4 mt">By ${video.author}</p>
                
                    <!-- Tombol Edit & Hapus -->
                    <div class="mx-4 my-4 flex justify-between items-center">
                        <div class="flex space-x-2">
                            <a href="/edit-Video" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-xs md:text-lg">Edit</a>
                            <button onclick="deleteVideo('${video.title}')" class="bg-red-500 text-white px-4 py-2 rounded-lg text-xs md:text-lg">Hapus</button>
                        </div>
                        <p class="text-xs md:text-lg italic">Aktif</p>
                    </div>
                </div>
            </div>
        `;
        VideoList.innerHTML += VideoCard;
    });

    function deleteVideo(title) {
        alert(`Menghapus Video: ${title}`);
        // Di sini bisa ditambahkan fungsi untuk menghapus dari backend
    }
</script>
@endsection
