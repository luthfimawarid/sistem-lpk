<!DOCTYPE html>
<html lang="en" class="font-[Poppins]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Button to open sidebar (mobile view) -->
    <div class="flex justify-between items-center bg-white p-3 md:p-5 shadow">
            <!-- Tombol Hamburger -->
            <button id="sidebar-toggle" type="button"
                class="p-2 text-gray-500 rounded-lg sm:hidden hover:bg-[#A6CDC6] focus:ring-2 focus:ring-gray-300">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zM2 10a.75.75 0 012.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10zM2 15.25a.75.75 0 012.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 012 15.25z"></path>
                </svg>
            </button>

            <!-- Teks Welcome Back -->
            <h1 class="text-sm md:text-xl md:ml-64 font-semibold">
                Welcome Back, {{ Auth::user()->nama_lengkap }}!
            </h1>
            <!-- Ikon Profil & Search -->
            <div class="flex items-center space-x-3 md:space-x-3">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                </svg>
                <div class="relative">
                    <button id="profileBtn" class="focus:outline-none">
                        <svg class="w-8 h-8 mt-1.5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="profileDropdown"
                        class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border z-50">
                        <a href="/profil-admin" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lihat Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 text-white h-full shadow-md transform -translate-x-full transition-transform sm:translate-x-0" style="background-color: #0A58CA;">
        <div class="p-4">
            <div class="p-4 flex justify-center">
                <img src="/logo.png" alt="Logo" class="w-40 h-40">
            </div>
            <ul class="space-y-2">
                <li>
                    <a href="/admin/dashboard" class="flex items-center p-2 rounded-lg hover:bg-[#A6CDC6]">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M4.857 3A1.857 1.857 0 0 0 3 4.857v4.286C3 10.169 3.831 11 4.857 11h4.286A1.857 1.857 0 0 0 11 9.143V4.857A1.857 1.857 0 0 0 9.143 3H4.857Zm10 0A1.857 1.857 0 0 0 13 4.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 9.143V4.857A1.857 1.857 0 0 0 19.143 3h-4.286Zm-10 10A1.857 1.857 0 0 0 3 14.857v4.286C3 20.169 3.831 21 4.857 21h4.286A1.857 1.857 0 0 0 11 19.143v-4.286A1.857 1.857 0 0 0 9.143 13H4.857Zm10 0A1.857 1.857 0 0 0 13 14.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 19.143v-4.286A1.857 1.857 0 0 0 19.143 13h-4.286Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-3">Dashboard</span>
                        <span class="w-2 h-2 rounded-full bg-white opacity-0 group-[.active-link]:opacity-100"></span>
                    </a>
                </li>
                <li>
                    <button id="dropdown-btn" class="flex justify-between items-center w-full p-2 rounded-lg hover:bg-[#A6CDC6]">
                        <span class="flex items-center">
                            <svg class="w-6 h-6 text-white dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 14h-2.722L11 20.278a5.511 5.511 0 0 1-.9.722H20a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1ZM9 3H4a1 1 0 0 0-1 1v13.5a3.5 3.5 0 1 0 7 0V4a1 1 0 0 0-1-1ZM6.5 18.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM19.132 7.9 15.6 4.368a1 1 0 0 0-1.414 0L12 6.55v9.9l7.132-7.132a1 1 0 0 0 0-1.418Z"/>
                            </svg>
                            <span class="ml-3">Materi</span>
                        </span>
                        <svg id="chevron" class="w-4 h-4 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <div id="dropdown-menu" class="hidden pl-8 mt-2 space-y-2">
                        <a href="/ebook-admin" class="flex items-center p-2 rounded-lg hover:bg-[#A6CDC6] text-white">
                            <svg class="w-6 h-6 text-white dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd"/>
                            </svg>
                            <span>E-book</span>
                        </a>

                        <a href="/listening-admin" class="flex items-center p-2 rounded-lg hover:bg-[#A6CDC6] text-white">
                            <svg class="w-6 h-6 text-white dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 5a7 7 0 0 0-7 7v1.17c.313-.11.65-.17 1-.17h2a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H6a3 3 0 0 1-3-3v-6a9 9 0 0 1 18 0v6a3 3 0 0 1-3 3h-2a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1h2c.35 0 .687.06 1 .17V12a7 7 0 0 0-7-7Z" clip-rule="evenodd"/>
                            </svg>
                            <span>Listening</span>
                        </a>

                        <a href="/video-admin" class="flex items-center p-2 rounded-lg hover:bg-[#A6CDC6] text-white">
                            <svg class="w-6 h-6 text-white dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M19.003 3A2 2 0 0 1 21 5v2h-2V5.414L17.414 7h-2.828l2-2h-2.172l-2 2H9.586l2-2H9.414l-2 2H3V5a2 2 0 0 1 2-2h14.003ZM3 9v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Zm2-2.414L6.586 5H5v1.586Zm4.553 4.52a1 1 0 0 1 1.047.094l4 3a1 1 0 0 1 0 1.6l-4 3A1 1 0 0 1 9 18v-6a1 1 0 0 1 .553-.894Z" clip-rule="evenodd"/>
                            </svg>
                            <span>Video</span>
                        </a>
                    </div>

                </li>
                <li>
                    <a href="/chat-admin" class="flex items-center p-2 rounded-lg hover:bg-[#A6CDC6]">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd" d="M12 4a8 8 0 0 0-6.895 12.06l.569.718-.697 2.359 2.32-.648.379.243A8 8 0 1 0 12 4ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.96 9.96 0 0 1-5.016-1.347l-4.948 1.382 1.426-4.829-.006-.007-.033-.055A9.958 9.958 0 0 1 2 12Z" clip-rule="evenodd"/>
                            <path fill="currentColor" d="M16.735 13.492c-.038-.018-1.497-.736-1.756-.83a1.008 1.008 0 0 0-.34-.075c-.196 0-.362.098-.49.291-.146.217-.587.732-.723.886-.018.02-.042.045-.057.045-.013 0-.239-.093-.307-.123-1.564-.68-2.751-2.313-2.914-2.589-.023-.04-.024-.057-.024-.057.005-.021.058-.074.085-.101.08-.079.166-.182.249-.283l.117-.14c.121-.14.175-.25.237-.375l.033-.066a.68.68 0 0 0-.02-.64c-.034-.069-.65-1.555-.715-1.711-.158-.377-.366-.552-.655-.552-.027 0 0 0-.112.005-.137.005-.883.104-1.213.311-.35.22-.94.924-.94 2.16 0 1.112.705 2.162 1.008 2.561l.041.06c1.161 1.695 2.608 2.951 4.074 3.537 1.412.564 2.081.63 2.461.63.16 0 .288-.013.4-.024l.072-.007c.488-.043 1.56-.599 1.804-1.276.192-.534.243-1.117.115-1.329-.088-.144-.239-.216-.43-.308Z"/>
                        </svg>
                        <span class="ml-3">Chat</span>
                        <span class="w-2 h-2 rounded-full bg-white opacity-0 group-[.active-link]:opacity-100"></span>
                    </a>
                </li>
                <li>
                    <a href="/tugas-admin" class="flex items-center p-2 rounded-lg hover:bg-[#A6CDC6]">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-3">Tugas</span>
                        <span class="w-2 h-2 rounded-full bg-white opacity-0 group-[.active-link]:opacity-100"></span>
                    </a>
                </li>
                <li>
                    <a href="/rapot-siswa" class="flex items-center p-2 rounded-lg hover:bg-[#A6CDC6]">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 0 0-1 1H6a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-2a1 1 0 0 0-1-1H9Zm1 2h4v2h1a1 1 0 1 1 0 2H9a1 1 0 0 1 0-2h1V4Zm5.707 8.707a1 1 0 0 0-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-3">Nilai & Rapot</span>
                        <span class="w-2 h-2 rounded-full bg-white opacity-0 group-[.active-link]:opacity-100"></span>
                    </a>
                </li>
                <li>
                    <a href="/sertifikat-admin" class="flex items-center p-2 rounded-lg hover:bg-[#A6CDC6]">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.4472 4.10557c-.2815-.14076-.6129-.14076-.8944 0L2.76981 8.49706l9.21949 4.39024L21 8.38195l-8.5528-4.27638Z"/>
                            <path d="M5 17.2222v-5.448l6.5701 3.1286c.278.1325.6016.1293.8771-.0084L19 11.618v5.6042c0 .2857-.1229.5583-.3364.7481l-.0025.0022-.0041.0036-.0103.009-.0119.0101-.0181.0152c-.024.02-.0562.0462-.0965.0776-.0807.0627-.1942.1465-.3405.2441-.2926.195-.7171.4455-1.2736.6928C15.7905 19.5208 14.1527 20 12 20c-2.15265 0-3.79045-.4792-4.90614-.9751-.5565-.2473-.98098-.4978-1.27356-.6928-.14631-.0976-.2598-.1814-.34049-.2441-.04036-.0314-.07254-.0576-.09656-.0776-.01201-.01-.02198-.0185-.02991-.0253l-.01038-.009-.00404-.0036-.00174-.0015-.0008-.0007s-.00004 0 .00978-.0112l-.00009-.0012-.01043.0117C5.12215 17.7799 5 17.5079 5 17.2222Zm-3-6.8765 2 .9523V17c0 .5523-.44772 1-1 1s-1-.4477-1-1v-6.6543Z"/>
                        </svg>
                        <span class="ml-3">Sertifikat</span>
                        <span class="w-2 h-2 rounded-full bg-white opacity-0 group-[.active-link]:opacity-100"></span>
                    </a>
                </li>
                <li>
                    <a href="/siswa" class="flex items-center p-2 rounded-lg hover:bg-[#A6CDC6]">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-3">Siswa</span>
                        <span class="w-2 h-2 rounded-full bg-white opacity-0 group-[.active-link]:opacity-100"></span>
                    </a>
                </li>
                <li>
                    <a href="/job-matching" class="flex items-center p-2 rounded-lg hover:bg-[#A6CDC6]">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-3">Job Matching</span>
                        <span class="w-2 h-2 rounded-full bg-white opacity-0 group-[.active-link]:opacity-100"></span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="min-h-screen lg:ml-64" style="background-color:rgb(223, 238, 255);">
        @yield('content')
    </div>
    @yield('scripts')

    <!-- JavaScript -->
    <script>
        const profileBtn = document.getElementById('profileBtn');
            const profileDropdown = document.getElementById('profileDropdown');

            profileBtn.addEventListener('click', function () {
                profileDropdown.classList.toggle('hidden');
            });

            // Tutup dropdown saat klik di luar area
            window.addEventListener('click', function (e) {
                if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
       document.addEventListener("DOMContentLoaded", function () {
        // Menandai link aktif berdasarkan URL saat ini
        const links = document.querySelectorAll('a[href]');
        const currentURL = window.location.pathname;

        links.forEach(link => {
            if (link.getAttribute('href') === currentURL) {
                link.classList.add('active-link');
            }
        });

        // Dropdown menu toggle
        const dropdownBtn = document.getElementById('dropdown-btn');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const chevron = document.getElementById('chevron');

        if (dropdownBtn && dropdownMenu && chevron) {
            dropdownBtn.addEventListener('click', () => {
                dropdownMenu.classList.toggle('hidden');
                chevron.classList.toggle('rotate-90'); // Animasi rotasi ikon
            });
        }

        // Sidebar toggle untuk tampilan mobile
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        // Menutup sidebar jika klik di luar sidebar (untuk UX yang lebih baik)
        document.addEventListener('click', function (event) {
            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    });
    </script>

</body>
</html>
