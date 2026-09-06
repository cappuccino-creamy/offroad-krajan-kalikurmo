<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi - {{ $detail_paket['nama_paket'] ?? 'Paket' }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2E5039', 
                        secondary: '#6E4E32', 
                        accent: '#F5A623', 
                    }
                }
            }
        }
    </script>
    
    <style>
        html { scroll-behavior: smooth; }
        .slide { transition: opacity 1s ease-in-out; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans flex flex-col min-h-screen">

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
                <a href="{{ url('/paket') }}" class="text-primary border-b-2 border-primary">Paket Wisata</a>
                <a href="{{ url('/galeri') }}" class="hover:text-primary transition duration-300">Galeri</a>
                <a href="{{ url('/tentang-kami') }}" class="hover:text-primary transition duration-300">Tentang Kami</a>
            </nav>

            <div class="flex items-center space-x-4 text-base">
                <a href="{{ session()->has('login') ? url('/profile') : url('/login') }}" class="hidden md:inline-block {{ session()->has('login') ? 'text-accent' : 'text-primary' }} hover:text-secondary text-2xl transition duration-300" title="Akun Saya">
                    <i class="fa-solid fa-circle-user"></i>
                </a>
                <button id="mobile-menu-btn" class="md:hidden text-3xl text-primary focus:outline-none">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t p-4 absolute w-full shadow-xl">
            <a href="{{ url('/') }}" class="block py-2 text-gray-700 hover:text-primary">Beranda</a>
            <a href="{{ url('/paket') }}" class="block py-2 text-primary font-bold">Paket Wisata</a>
            <a href="{{ url('/galeri') }}" class="block py-2 text-gray-700 hover:text-primary">Galeri</a>
            <a href="{{ url('/tentang-kami') }}" class="block py-2 text-gray-700 hover:text-primary">Kontak</a>
            
            @if(session()->has('login'))
                <a href="{{ url('/profile') }}" class="block py-2 mt-2 text-center bg-accent text-white font-bold rounded">Profil Saya</a>
            @else
                <a href="{{ url('/login') }}" class="block py-2 mt-2 text-center bg-primary text-white font-bold rounded">Login / Akun Saya</a>
            @endif
        </div>
    </header>

    <main class="container mx-auto px-4 py-10 max-w-6xl flex-grow">
        <div class="flex flex-col lg:flex-row gap-10">
            
            <div class="w-full lg:w-1/2">
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100">
                    <img src="{{ asset($detail_paket['gambar']) }}" alt="Paket" class="w-full h-72 object-cover">
                    <div class="p-8">
                        <span class="bg-accent/10 text-accent font-bold text-xs uppercase tracking-widest px-3 py-1 rounded-full mb-4 inline-block">Review Pilihan</span>
                        <h1 class="text-3xl font-extrabold text-primary mb-4">{{ $detail_paket['nama_paket'] }}</h1>
                        <p class="text-gray-600 leading-relaxed mb-6">{{ $detail_paket['deskripsi'] }}</p>
                        
                        <div class="grid grid-cols-2 gap-4 border-t border-gray-100 pt-6">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-clock text-secondary text-xl"></i>
                                <div>
                                    <p class="text-xs text-gray-400">Durasi</p>
                                    <p class="font-bold text-sm">{{ $detail_paket['durasi'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-car-side text-secondary text-xl"></i>
                                <div>
                                    <p class="text-xs text-gray-400">Kapasitas</p>
                                    <p class="font-bold text-sm">{{ $detail_paket['kapasitas'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                        <i class="fa-solid fa-file-signature text-accent"></i> Formulir Reservasi
                    </h3>
                    
                    @if(session()->has('login'))
                        <form action="{{ url('/proses-pesanan') }}" method="POST" class="space-y-5">
                            @csrf
                            <input type="hidden" name="id_paket" value="{{ $detail_paket['id'] }}">
                            <input type="hidden" name="nama_paket" value="{{ $detail_paket['nama_paket'] }}">
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap Pemesan</label>
                                <input type="text" name="nama" value="{{ session('nama') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition" placeholder="Masukkan nama Anda">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">No. WhatsApp Aktif</label>
                                    <input type="tel" name="whatsapp" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition" placeholder="0812...">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Kunjungan</label>
                                    <input type="date" name="tanggal" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Orang / Pax</label>
                                <input type="number" name="jumlah_orang" min="1" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition" placeholder="Berapa orang yang ikut?">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Khusus (Opsional)</label>
                                <textarea name="catatan" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition" placeholder="Contoh: Titik kumpul di gapura desa..."></textarea>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-4 rounded-2xl shadow-lg transition duration-300 flex items-center justify-center gap-3">
                                    Pesan Sekarang & Lanjut ke WA <i class="fa-brands fa-whatsapp text-xl"></i>
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-2xl border border-gray-200">
                            <i class="fa-solid fa-lock text-4xl text-gray-300 mb-3"></i>
                            <h4 class="font-bold text-lg text-gray-700 mb-2">Login Diperlukan</h4>
                            <p class="text-gray-500 text-sm mb-6 px-4">Silakan masuk ke akun Anda terlebih dahulu agar bisa melakukan reservasi paket ini.</p>
                            <a href="{{ url('/login') }}" class="inline-block bg-primary hover:bg-secondary text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-md">
                                Menuju Halaman Login <i class="fa-solid fa-right-to-bracket ml-2"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <footer id="kontak" class="bg-secondary text-white pt-12 pb-6 mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8 text-center md:text-left">
                
                <div>
                    <a href="#" class="flex justify-center md:justify-start items-center gap-2 mb-4">
                        <img src="{{ asset('gambar/logo.png') }}" alt="Logo Kalikurmo" class="h-10 w-auto object-contain drop-shadow-sm">
                        
                        <span class="font-bold text-2xl tracking-tight">S4X4TIGA OFFROAD</span>
                    </a>
                    <p class="text-gray-300 text-sm leading-relaxed max-w-xs mx-auto md:mx-0">
                        Kegiatan off road sejak 2015, kini tidak hanya hobi melainkan wujud kepedulian sosial, ekonomi, dan bakti sosial masyarakat Desa.
                    </p>
                </div>

                <div>
                    <h3 class="font-bold text-lg mb-4 text-accent">Aturan Pengunjung</h3>
                    <ul class="space-y-2 text-gray-300 text-sm">
                        <li><i class="fa-solid fa-check mr-2"></i>Menjaga diri sendiri & teman</li>
                        <li><i class="fa-solid fa-check mr-2"></i>Hormati adat setempat</li>
                        <li><i class="fa-solid fa-xmark mr-2 text-red-400"></i>Dilarang berkegiatan malam hari</li>
                        <li><i class="fa-solid fa-clock mr-2"></i>Wajib reservasi max H-7</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-lg mb-4 text-accent">Informasi Kontak</h3>
                    <ul class="space-y-3 text-gray-300 text-sm">
                        <li class="flex items-start justify-center md:justify-start gap-3">
                            <i class="fa-solid fa-location-dot mt-1"></i>
                            <span>Dusun Krajan, Desa Kalikurmo,<br>Kec. Bringin, Kab. Semarang</span>
                        </li>
                        <li class="flex items-center justify-center md:justify-start gap-3">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                            <span>+62 813-2532-3203 (Info & Reservasi)</span>
                        </li>
                        <li class="flex items-center justify-center md:justify-start gap-3">
                            <i class="fa-brands fa-instagram text-lg"></i>
                            <a href="https://instagram.com/s4x4tiga_adventure_offroad4x4" target="_blank" class="hover:text-white hover:underline">@s4x4tiga_adventure_offroad4x4</a>
                        </li>
                    </ul>
                </div>

            </div>

            <hr class="border-gray-500 mb-6">

            <div class="text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} Desa Wisata Kalikurmo. All Rights Reserved.
            </div>
        </div>
    </footer>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => { menu.classList.toggle('hidden'); });

        const slides = document.querySelectorAll('.slide');
        let currentSlide = 0;
        function nextSlide() {
            if (slides.length > 0) {
                slides[currentSlide].classList.remove('opacity-100');
                slides[currentSlide].classList.add('opacity-0');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.remove('opacity-0');
                slides[currentSlide].classList.add('opacity-100');
            }
        }
        setInterval(nextSlide, 10000);
    </script>
</body>
</html>