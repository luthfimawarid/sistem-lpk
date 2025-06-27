<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>
<body class="bg-[#F2F8FF]">
    <div class="min-h-screen flex items-center justify-center px-4 py-6">
        <div class="w-full max-w-screen-md shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row bg-white h-auto md:h-[450px]">
            <!-- Bagian Kiri -->
            <div class="md:w-1/2 w-full p-6 bg-[#0A58CA] text-white flex flex-col items-center justify-center">
                <img src="/logo.png" alt="Logo" class="w-32 md:w-40 mb-4">
                <p class="text-center text-base md:text-lg font-semibold">Selamat Datang di Sistem Pembelajaran LPK Karya Muda Indonesia (KAMI)</p>
                <p class="text-sm text-center mt-2">“Tingkatkan Kemampuan Bahasa Jepang Anda”</p>
            </div>

            <!-- Bagian Kanan -->
            <div class="md:w-1/2 w-full p-6 md:p-8 justify-center bg-white">
                <p class="font-semibold text-lg text-center mt-4">Masuk</p>
                <p class="text-xs md:text-sm text-center mt-1 mb-14">“Masuk sekarang untuk mengakses materi, latihan soal, dan prediksi kelulusan berbasis performa”</p>

                @if ($errors->has('login'))
                    <div class="bg-red-100 text-red-700 text-sm p-2 rounded mb-3">
                        {{ $errors->first('login') }}
                    </div>
                @endif

                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="email" class="border-b border-gray-300 p-2 w-full text-sm outline-none" placeholder="Email" required>
                    </div>

                    <div class="relative mb-3">
                        <input id="password" name="password" type="password" class="border-b border-gray-300 p-2 w-full text-sm outline-none pr-10 mb-5" placeholder="Password" required>
                        <span class="absolute right-2 top-3 cursor-pointer" onclick="togglePassword()">
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </span>
                    </div>

                    <div class="text-right mb-4">
                        <a href="#" class="text-blue-600 text-sm hover:underline">Lupa password?</a>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Masuk</button>
                </form>

                <!-- <div class="flex items-center my-4">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <p class="mx-2 text-sm text-gray-500">Masuk dengan akun lain</p>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <div class="flex justify-center space-x-4">
                    <button class="border border-gray-300 rounded-full p-2 hover:bg-gray-100">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook" class="w-5 md:w-6">
                    </button>
                    <button class="border border-gray-300 rounded-full p-2 hover:bg-gray-100">
                        <img src="https://cdn-icons-png.flaticon.com/512/281/281764.png" alt="Google" class="w-5 md:w-6">
                    </button>
                </div> -->
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            password.type = password.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
