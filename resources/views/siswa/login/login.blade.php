<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>
<body style="background-color: #F2F8FF;">
    <div class="bungkus min-h-screen flex justify-center items-center bg-gray-100">
        <div class="konten flex w-[1000px] max-w-3xl h-[400px] shadow-lg rounded-lg overflow-hidden">
            <!-- Bagian Kiri -->
            <div class="kiri w-1/2 p-6 text-white flex flex-col items-center justify-center" style="background-color: #0A58CA;">
                <img src="/logo.png" alt="Logo" class="w-40 mb-4">
                <p class="font-semibold text-center text-lg">Selamat Datang di Sistem Pembelajaran LPK Karya Muda Indonesia (KAMI)</p>
                <p class="text-sm text-center mt-2">“Tingkatkan Kemampuan Bahasa Jepang Anda”</p>
            </div>

            <!-- Bagian Kanan -->
            <div class="kanan w-1/2 bg-white p-8 flex flex-col justify-center">
                <p class="font-semibold text-center text-xl">Masuk</p>
                <p class="text-sm text-center mb-5 mt-2">“Masuk sekarang untuk mengakses materi, latihan soal, dan prediksi kelulusan berbasis performa”</p>
                
                <!-- Input Username -->
                <div class="mb-3">
                    <input type="text" class="border-b border-gray-300 p-2 w-full text-sm outline-none" placeholder="Username">
                </div>

                <!-- Input Password dengan Icon Mata -->
                <div class="relative mb-3">
                    <input id="password" type="password" class="border-b border-gray-300 p-2 w-full text-sm outline-none pr-10" placeholder="Password">
                    <span class="absolute right-2 top-3 cursor-pointer" onclick="togglePassword()">
                        <svg class="w-6 h-6 text-gray-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </span>
                </div>

                <!-- Lupa Password -->
                <div class="text-right mb-4">
                    <a href="#" class="text-blue-600 text-sm hover:underline">Lupa password?</a>
                </div>

                <!-- Tombol Masuk -->
                <a href="/dashboard" class="w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition">Masuk</a>

                <!-- Garis Pemisah -->
                <div class="flex items-center my-4">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <p class="mx-2 text-sm text-gray-500">Masuk dengan akun lain</p>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <!-- Icon Sosial Media -->
                <div class="flex justify-center space-x-4">
                    <button class="border border-gray-300 rounded-full p-2 hover:bg-gray-100">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook" class="w-6">
                    </button>
                    <button class="border border-gray-300 rounded-full p-2 hover:bg-gray-100">
                        <img src="https://cdn-icons-png.flaticon.com/512/281/281764.png" alt="Google" class="w-6">
                    </button>
                </div>
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
