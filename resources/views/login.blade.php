<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kalikurmo Offroad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] }, colors: { primary: '#2E5039', secondary: '#6E4E32', accent: '#F5A623' } } }
        }
    </script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen font-sans text-gray-800">
    
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <img src="{{ asset('gambar/logo.png') }}" alt="Logo S4X4TIGA" class="h-10 w-auto object-contain drop-shadow-sm">
                    
                    <span class="font-bold text-xl text-secondary tracking-tight">S4X4TIGA<span class="text-primary"> OFFROAD</span></span>
                </a>
            </div>
            <nav class="hidden md:flex space-x-8 font-semibold text-gray-700">
                <a href="{{ url('/') }}" class="hover:text-primary transition duration-300">Beranda</a>
                <a href="{{ url('/paket') }}" class="hover:text-primary transition duration-300">Paket Wisata</a>
                <a href="{{ url('/galeri') }}" class="hover:text-primary transition duration-300">Galeri</a>
                <a href="{{ url('/tentang-kami') }}" class="hover:text-primary transition duration-300">Tentang Kami</a>
            </nav>
            <div class="flex items-center space-x-4 text-base">
                <a href="{{ session()->has('login') ? url('/profile') : url('/login') }}" class="hidden md:inline-block {{ session()->has('login') ? 'text-accent' : 'text-primary' }} hover:text-secondary text-2xl transition duration-300">
                    <i class="fa-solid fa-circle-user"></i>
                </a>
                <button id="mobile-menu-btn" class="md:hidden text-3xl text-primary focus:outline-none"><i class="fa-solid fa-bars"></i></button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t p-4 absolute w-full shadow-xl">
            <a href="{{ url('/') }}" class="block py-2 text-gray-700 hover:text-primary">Beranda</a>
            <a href="{{ url('/paket') }}" class="block py-2 text-gray-700 hover:text-primary">Paket Wisata</a>
            <a href="{{ url('/galeri') }}" class="block py-2 text-gray-700 hover:text-primary">Galeri</a>
            <a href="{{ url('/tentang-kami') }}" class="block py-2 text-gray-700 hover:text-primary">Tentang Kami</a>
            <a href="{{ session()->has('login') ? url('/profile') : url('/login') }}" class="block py-2 mt-2 text-center {{ session()->has('login') ? 'bg-accent' : 'bg-primary' }} text-white font-bold rounded">
                {{ session()->has('login') ? 'Profil Saya' : 'Login / Akun Saya' }}
            </a>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md border-t-8 border-accent">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Masuk ke Akun</h2>
            
            @if(session('error'))
                <p class="text-red-500 text-sm italic mb-4 text-center bg-red-50 p-2 rounded">{{ session('error') }}</p>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full bg-gray-50 border rounded-xl px-4 py-3 outline-none focus:border-primary transition" placeholder="email@contoh.com">
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-bold text-gray-700">Password</label>
                        <a href="{{ url('/lupa-password') }}" class="text-xs text-primary font-bold hover:underline">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="login-password" required class="w-full bg-gray-50 border rounded-xl px-4 py-3 outline-none focus:border-primary transition pr-12" placeholder="********">
                        <button type="button" onclick="togglePassword('login-password', 'eye-login')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-primary transition focus:outline-none">
                            <i id="eye-login" class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full bg-primary text-white font-bold py-3 rounded-xl hover:bg-secondary transition duration-300 shadow-md">
                    Masuk <i class="fa-solid fa-right-to-bracket ml-2"></i>
                </button>
            </form>
            <p class="text-center mt-6 text-sm text-gray-600">
                Belum punya akun? <a href="{{ url('/register') }}" class="text-primary font-bold hover:underline">Daftar di sini</a>
            </p>
        </div>
    </main>

    <footer class="bg-secondary text-white py-6 text-center text-sm mt-auto border-t-4 border-primary">
        &copy; {{ date('Y') }} Desa Wisata Kalikurmo. All Rights Reserved.
    </footer>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => { menu.classList.toggle('hidden'); });

        function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
    </script>
</body>
</html>