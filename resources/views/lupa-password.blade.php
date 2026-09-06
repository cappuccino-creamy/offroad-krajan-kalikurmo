<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Kalikurmo Offroad</title>
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
                <a href="{{ url('/login') }}" class="hidden md:inline-block text-primary hover:text-secondary text-2xl transition duration-300">
                    <i class="fa-solid fa-circle-user"></i>
                </a>
                <button id="mobile-menu-btn" class="md:hidden text-3xl text-primary focus:outline-none"><i class="fa-solid fa-bars"></i></button>
            </div>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md border-t-8 border-secondary">
            <div class="text-center mb-8">
                <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-secondary text-2xl border border-gray-100 shadow-sm">
                    <i class="fa-solid fa-key"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Lupa Password?</h2>
                <p class="text-sm text-gray-500 mt-1">Jangan khawatir, mari atur ulang sandi Anda.</p>
            </div>
            
            @if(session('error'))
                <div class="mb-6 p-3 rounded text-sm text-center font-bold bg-red-50 text-red-500">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-3 rounded text-sm text-center font-bold bg-green-50 text-green-600">
                    {{ session('success') }}
                    <br><a href="{{ url('/login') }}" class="underline mt-2 inline-block">Klik di sini untuk Login</a>
                </div>
            @endif

            @if(!session('step') || session('step') == 1)
                @if(!session('success'))
                    <form action="{{ url('/lupa-password') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="action" value="cek_email">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email yang Terdaftar</label>
                            <input type="email" name="email" required class="w-full bg-gray-50 border rounded-xl px-4 py-3 outline-none focus:border-secondary transition" placeholder="Masukkan email Anda">
                        </div>
                        <button type="submit" class="w-full bg-secondary text-white font-bold py-3 rounded-xl hover:bg-primary transition duration-300 shadow-md">
                            Cek Email <i class="fa-solid fa-arrow-right ml-2"></i>
                        </button>
                    </form>
                @endif
            @elseif(session('step') == 2)
                <form action="{{ url('/lupa-password') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="action" value="ganti_password">
                    <input type="hidden" name="email" value="{{ session('email_verified') }}">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="pass1" id="new-password" minlength="6" required class="w-full bg-gray-50 border rounded-xl px-4 py-3 outline-none focus:border-secondary transition pr-12" placeholder="Minimal 6 karakter">
                            <button type="button" onclick="togglePassword('new-password', 'eye-new')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-secondary transition focus:outline-none">
                                <i id="eye-new" class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" name="pass2" id="confirm-password" minlength="6" required class="w-full bg-gray-50 border rounded-xl px-4 py-3 outline-none focus:border-secondary transition pr-12" placeholder="Ketik ulang password">
                            <button type="button" onclick="togglePassword('confirm-password', 'eye-confirm')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-secondary transition focus:outline-none">
                                <i id="eye-confirm" class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-primary text-white font-bold py-3 rounded-xl hover:bg-secondary transition duration-300 shadow-md">
                        Simpan Password <i class="fa-solid fa-floppy-disk ml-2"></i>
                    </button>
                </form>
            @endif

            <p class="text-center mt-6 text-sm text-gray-600">
                Ingat password Anda? <a href="{{ url('/login') }}" class="text-secondary font-bold hover:underline">Kembali ke Login</a>
            </p>
        </div>
    </main>

    <footer class="bg-secondary text-white py-6 text-center text-sm mt-auto border-t-4 border-primary">
        &copy; {{ date('Y') }} Desa Wisata Kalikurmo. All Rights Reserved.
    </footer>

    <script>
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