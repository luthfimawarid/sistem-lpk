@extends('admin.main.sidebar')

@section('content')
<main class="p-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="flex space-x-2 md:order-2">
                <a href="/tambah-ebook" class="border-2 border-blue-600 text-blue-600 font-semibold text-xs md:textlg px-4 py-2 flex items-center rounded-lg">
                    Tambah E-book
                    <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7 7V5"/>
                    </svg>
                </a>
                <button class="border-2 border-blue-600 text-blue-600 font-semibold text-xs md:textlg px-4 py-2 flex items-center rounded-lg">
                    Sort By
                    <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8 10 4 4 4-4"/>
                    </svg>
                </button>
            </div>
        </div>

        
        <h2 id="ebook-count" class="md:text-lg font-semibold my-2 md:my-0 md:order-1">E-book (0)</h2>
        <!-- Grid of E-books -->
        <div id="ebook-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"></div>


    </main>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data e-book (contoh tanpa backend)
    const ebooks = [
        { title: "Belajar Hiragana", author: "Nakamura", file: "belajar-hiragana.pdf" },
        { title: "Kanji Dasar", author: "Yamada", file: "kanji-dasar.pdf" },
        { title: "Bahasa Jepang Pemula", author: "Tanaka", file: "jepang-pemula.pdf" },
        { title: "Kosakata N5", author: "Fujimoto", file: "kosakata-n5.pdf" },
    ];

    // Update jumlah e-book di judul
    document.getElementById("ebook-count").textContent = `E-book (${ebooks.length})`;

    // Generate kartu e-book
    const ebookList = document.getElementById("ebook-list");

    ebooks.forEach(ebook => {
        const ebookCard = `
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="/logo.png" alt="Cover E-book" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">${ebook.title}</h3>
                    <p class="text-xs md:textlg text-gray-600 mt-2">By ${ebook.author}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <div class="flex space-x-2">
                            <a href="/edit-ebook" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-xs md:textlg">Edit</a>
                            <a href="/ebooks/${ebook.file}" download class="bg-red-500 text-white px-4 py-2 rounded-lg text-xs md:textlg">Hapus</a>
                        </div>
                        <p class="text-xs md:textlg italic">Aktif</p>
                    </div>
                </div>
            </div>
        `;
        ebookList.innerHTML += ebookCard;
    });
</script>

@endsection
