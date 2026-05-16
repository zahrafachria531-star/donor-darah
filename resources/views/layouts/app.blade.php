<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Darah App</title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        customGray: '#9AA6B2',
                        customPastel: '#BCCCDC',
                        customDark: '#3A424A', // Tambahan warna teks gelap agar kontras dan terbaca
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-customDark min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo / Brand -->
                    <a href="{{ route('landing') }}" class="flex items-center space-x-2 text-xl font-bold tracking-wide">
                        <span class="p-2 rounded-lg bg-[#BCCCDC] text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#3A424A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </span>
                        <span class="text-gray-800">Donor<span class="text-[#9AA6B2]">Darah</span></span>
                    </a>
                </div>

                <!-- Menu Navigation -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('landing') }}" class="text-sm font-medium text-gray-600 hover:text-[#9AA6B2] transition">Beranda</a>
                    
                    @auth
                        <!-- Jika Sudah Login -->
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-[#9AA6B2] transition">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 transition">Keluar</button>
                        </form>
                    @else
                        <!-- Jika Belum Login -->
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-[#9AA6B2] transition">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium bg-[#BCCCDC] text-gray-800 px-4 py-2 rounded-lg hover:bg-[#9AA6B2] hover:text-white transition shadow-sm">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-grow">
        <!-- Notifikasi Flash Message Sukses (Jika ada) -->
        @if(session('success'))
            <div class="max-w-4xl mx-auto mt-4 mx-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Wadah isi konten halaman anak -->
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-100 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-[#9AA6B2] space-y-2">
            <p>&copy; {{ date('Y') }} Proyek Mini Donor Darah. Desain berbasis Estetika Slate & Pastel.</p>
            <p class="font-light">Font Style: Poppins Regular & Bold</p>
        </div>
    </footer>

</body>
</html>