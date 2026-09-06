<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Wisata - Offroad Kalikurmo</title>
    
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
            <a href="{{ url('/tentang-kami') }}" class="block py-2 text-gray-700 hover:text-primary">Tentang Kami</a>
            
            @if(session()->has('login'))
                <a href="{{ url('/profile') }}" class="block py-2 mt-2 text-center bg-accent text-white font-bold rounded">Profil Saya</a>
            @else
                <a href="{{ url('/login') }}" class="block py-2 mt-2 text-center bg-primary text-white font-bold rounded">Login / Akun Saya</a>
            @endif
        </div>
    </header>

    <section class="relative h-[400px] md:h-[550px] w-full overflow-hidden bg-black">
        <div id="slider-container" class="w-full h-full">
            @if(isset($slider_images))
                @foreach($slider_images as $index => $img)
                    <img src="{{ asset($img) }}" 
                        class="slide absolute inset-0 w-full h-full object-cover {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" 
                        alt="Slide {{ $index }}">
                @endforeach
            @endif
        </div>
        
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>

        <div class="absolute inset-0 flex flex-col justify-center items-center text-center text-white px-4 mt-8">
            <h1 class="text-3xl md:text-5xl font-extrabold mb-3 md:mb-4 tracking-wide drop-shadow-lg">
                PAKET WISATA <span class="text-accent">OFF ROAD</span>
            </h1>
            <p class="text-sm md:text-lg mb-6 max-w-2xl drop-shadow-md text-gray-200">
                Sesuaikan nyali dan keahlianmu. Pilih rute penjelajahan hutan Gunung Gapuk atau susur sungai ekstrem bersama <i>crew</i> S4X4TIGA.
            </p>

            <div class="inline-block mb-8 transform transition hover:scale-105">
                <span class="text-sm md:text-lg font-medium text-gray-100 drop-shadow-md">Mulai dari</span> 
                <span class="text-3xl md:text-5xl font-black text-accent ml-2 tracking-widest drop-shadow-xl">Rp 400.000</span>
            </div>

            <a href="#paket" class="bg-accent hover:bg-orange-600 text-white font-bold text-lg py-3 md:py-4 px-8 md:px-10 rounded-full transition-all duration-300 shadow-[0_4px_20px_rgba(245,166,35,0.4)] transform hover:-translate-y-1 flex items-center gap-3">
                Pesan Sekarang <i class="fa-solid fa-arrow-down animate-bounce mt-1"></i>
            </a>
        </div>
    </section>

    <section id="paket" class="py-12 md:py-20 bg-gray-50 flex-grow">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10 md:mb-14">
                <h2 class="text-3xl md:text-4xl font-bold text-primary">Pilihan Paket Petualangan</h2>
                <div class="w-24 h-1.5 bg-accent mx-auto mt-4 rounded-full"></div>
                <p class="text-gray-500 mt-4 max-w-2xl mx-auto text-sm md:text-base">Berbagai pilihan rute menantang di Gunung Gapuk maupun aktivitas air yang siap memacu adrenalin Anda bersama tim.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @if(isset($paket_wisata) && count($paket_wisata) > 0)
                    @foreach ($paket_wisata as $paket)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-2xl transition-all duration-300 group overflow-hidden flex flex-col h-full">
                            
                            <div class="relative h-56 overflow-hidden">
                                <img src="{{ asset($paket['gambar']) }}" alt="{{ $paket['nama_paket'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur text-secondary text-xs font-bold px-3 py-1.5 rounded-full shadow flex items-center gap-1">
                                    <i class="fa-regular fa-clock"></i> {{ $paket['durasi'] }}
                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="font-extrabold text-xl text-primary mb-2">
                                    {{ $paket['nama_paket'] }}
                                </h3>
                                <p class="text-sm text-gray-600 mb-4 flex-grow">{{ $paket['deskripsi'] }}</p>
                                
                                <div class="flex items-center gap-2 text-xs text-gray-500 font-semibold mb-4 bg-gray-50 p-2 rounded">
                                    <i class="fa-solid fa-car-side text-secondary"></i> {{ $paket['kapasitas'] }}
                                </div>
                                
                                <div class="mt-auto pt-4 border-t border-gray-100">
                                    <div class="text-accent font-bold text-xl mb-4">
                                        {{ $paket['harga'] > 0 ? 'Rp ' . number_format($paket['harga'], 0, ',', '.') : 'Hubungi Admin' }}
                                    </div>
                                    
                                    <a href="{{ url('/detail-paket?id=' . $paket['id']) }}" class="block w-full text-center bg-primary hover:bg-secondary text-white font-bold py-3 rounded-xl transition duration-300 shadow-md">
                                        Pesan Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-1 md:col-span-2 lg:col-span-4 text-center py-10 bg-white rounded-xl border border-dashed border-gray-300">
                        <p class="text-gray-500">Belum ada paket wisata yang tersedia saat ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

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
                        <li class="flex items-center justify-center md:justify-start gap-3">
                            <i class="fa-brands fa-tiktok text-lg"></i>
                            <a href="https://tiktok.com/@jiptrips4x4tiga" target="_blank" class="hover:text-white hover:underline">@jiptrips4x4tiga</a>
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

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

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

        setInterval(nextSlide, 5000);
    </script>
</body>
</html>