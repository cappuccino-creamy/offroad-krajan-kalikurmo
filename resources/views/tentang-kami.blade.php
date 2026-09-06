<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Offroad Kalikurmo</title>
    
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
                <a href="{{ url('/paket') }}" class="hover:text-primary transition duration-300">Paket Wisata</a>
                <a href="{{ url('/galeri') }}" class="hover:text-primary transition duration-300">Galeri</a>
                <a href="{{ url('/tentang-kami') }}" class="text-primary border-b-2 border-primary">Tentang Kami</a>
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
            <a href="{{ url('/paket') }}" class="block py-2 text-gray-700 hover:text-primary">Paket Wisata</a>
            <a href="{{ url('/galeri') }}" class="block py-2 text-gray-700 hover:text-primary">Galeri</a>
            <a href="{{ url('/tentang-kami') }}" class="block py-2 text-primary font-bold">Tentang Kami</a>
            
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
        
        <div class="absolute inset-0 flex flex-col justify-center items-center text-center text-white px-4">
            <h1 class="text-3xl md:text-5xl font-extrabold mb-3 md:mb-5 tracking-wide drop-shadow-lg">TENTANG <span class="text-accent">KALIKURMO</span></h1>
            <p class="text-sm md:text-xl mb-6 md:mb-10 max-w-2xl drop-shadow-md">Mengenal lebih dekat sejarah, visi, dan dedikasi komunitas di balik keseruan wisata alam Desa Kalikurmo.</p>
        </div>
    </section>

    <section class="py-12 md:py-20 bg-white">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="flex flex-col lg:flex-row gap-10 items-center">
                <div class="w-full lg:w-1/2 relative">
                    <img src="{{ asset('gambar/kalikurmo30.jpg') }}" alt="Sejarah Kalikurmo" class="rounded-2xl shadow-xl w-full object-cover h-[400px]">
                    <div class="absolute -bottom-6 -right-6 bg-accent text-white p-6 rounded-xl shadow-lg hidden md:block">
                        <h3 class="text-3xl font-extrabold">2015</h3>
                        <p class="text-sm font-semibold">Tahun Berdiri</p>
                    </div>
                </div>
                
                <div class="w-full lg:w-1/2">
                    <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Profil Wisata Offroad Dusun Krajan</h2>
                    <div class="w-20 h-1.5 bg-accent rounded-full mb-6"></div>
                    <p class="text-gray-600 mb-4 leading-relaxed text-justify">
                        Berawal dari hobi menjelajahi hutan, aktivitas komunitas Jeep Salatiga di Desa Kalikurmo yang dimulai sejak tahun 2015 perlahan berevolusi menjadi destinasi wisata petualangan yang terstruktur. Setelah mendapatkan izin resmi dari pihak perhutani, wisata offroad ini terus berkembang.
                    </p>
                    <p class="text-gray-600 mb-6 leading-relaxed text-justify">
                        Kegiatan ini tidak sekadar mengejar adrenalin, tetapi juga mewujudkan kepedulian sosial. Bersama komunitas penggerak utama, <span class="font-bold text-secondary">S4X4TIGA</span>, kami telah membangun berbagai fasilitas desa seperti mushola, tempat bilas, hingga memberikan edukasi berkendara yang aman bagi warga lokal.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
                <div class="bg-gray-50 border border-gray-100 p-8 rounded-2xl text-center hover:shadow-lg transition duration-300">
                    <i class="fa-solid fa-users text-5xl text-accent mb-4"></i>
                    <h3 class="text-4xl font-black text-primary mb-2">5,000+</h3>
                    <p class="text-gray-500 font-semibold">Total Pengunjung</p>
                </div>
                <div class="bg-gray-50 border border-gray-100 p-8 rounded-2xl text-center hover:shadow-lg transition duration-300">
                    <i class="fa-solid fa-star text-5xl text-accent mb-4"></i>
                    <h3 class="text-4xl font-black text-primary mb-2">4.8/5</h3>
                    <p class="text-gray-500 font-semibold">Rating Kepuasan</p>
                </div>
                <div class="bg-gray-50 border border-gray-100 p-8 rounded-2xl text-center hover:shadow-lg transition duration-300">
                    <i class="fa-solid fa-headset text-5xl text-accent mb-4"></i>
                    <h3 class="text-4xl font-black text-primary mb-2">24/7</h3>
                    <p class="text-gray-500 font-semibold">Layanan Reservasi Website</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-20 bg-secondary text-white relative">
        <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        
        <div class="container mx-auto px-4 max-w-5xl relative z-10 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Visi & Misi Kami</h2>
            <div class="w-24 h-1 bg-accent mx-auto mb-10"></div>
            
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 md:p-10 rounded-2xl mb-8">
                <i class="fa-solid fa-eye text-4xl text-accent mb-4"></i>
                <h3 class="text-2xl font-bold mb-3">Visi</h3>
                <p class="text-gray-200 text-lg">"Menjadi pelopor desa wisata petualangan berbasis pemberdayaan masyarakat dan pelestarian alam terdepan di Jawa Tengah."</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl text-left">
                    <h4 class="text-xl font-bold mb-3 flex items-center gap-2"><i class="fa-solid fa-bullseye text-accent"></i> Misi 1</h4>
                    <p class="text-gray-300 text-sm leading-relaxed">Memberikan pengalaman wisata offroad yang menantang namun tetap mengutamakan standar keselamatan dan keamanan pengunjung.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl text-left">
                    <h4 class="text-xl font-bold mb-3 flex items-center gap-2"><i class="fa-solid fa-bullseye text-accent"></i> Misi 2</h4>
                    <p class="text-gray-300 text-sm leading-relaxed">Meningkatkan kesejahteraan ekonomi warga lokal Desa Kalikurmo melalui integrasi kuliner, penginapan, dan jasa pemandu.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-primary">Lokasi & Operasional</h2>
                <div class="w-24 h-1.5 bg-accent mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-md overflow-hidden flex flex-col md:flex-row border border-gray-200">
                <div class="w-full md:w-1/3 p-8 bg-primary text-white flex flex-col justify-center">
                    <h3 class="text-2xl font-bold mb-6 border-b border-white/30 pb-4">Waktu Kunjungan</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-calendar-check text-accent mt-1"></i>
                            <div>
                                <span class="font-bold block">Hari Buka</span>
                                <span class="text-gray-300 text-sm">Senin - Minggu (Setiap Hari)</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-clock text-accent mt-1"></i>
                            <div>
                                <span class="font-bold block">Jam Operasional</span>
                                <span class="text-gray-300 text-sm">Menyesuaikan Jadwal Tamu (Disarankan Pagi-Sore)</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-triangle-exclamation text-accent mt-1"></i>
                            <div>
                                <span class="font-bold block">Perhatian</span>
                                <span class="text-gray-300 text-sm">Dilarang keras berkegiatan pada malam hari. Wajib reservasi maksimal H-7.</span>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div class="w-full md:w-2/3 h-64 md:h-auto">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.825102554705!2d110.5181741!3d-7.2144346!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a8123456789%3A0x123456789abcdef!2sKalikurmo%2C%20Bringin%2C%20Kabupaten%20Semarang%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1715500000000!5m2!1sid!2sid" 
                            class="w-full h-full border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-20 bg-white border-t border-gray-100">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="bg-gray-50 border border-gray-200 rounded-3xl p-8 md:p-12 text-center relative overflow-hidden">
                <i class="fa-solid fa-laptop-code text-8xl text-gray-100 absolute top-[-20px] left-[-20px] z-0"></i>
                
                <div class="relative z-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Di Balik Layar <span class="text-primary">Website Kami</span></h2>
                    <div class="w-16 h-1 bg-accent mx-auto mb-6"></div>
                    
                    <p class="text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed">
                        Sistem informasi dan pemesanan digital ini lahir dari sebuah observasi lapangan yang mendalam. Website ini dikembangkan dan dirancang oleh Mahasiswa Fakultas Teknologi Informasi, Universitas Kristen Satya Wacana (UKSW), sebagai wujud pengabdian dan implementasi nyata mata kuliah Rekayasa Perangkat Lunak.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                        <div class="flex flex-col items-center">
                            <div class="w-32 h-32 rounded-full border-4 border-white shadow-md overflow-hidden mb-4 transform hover:scale-105 transition duration-300">
                                <img src="https://ui-avatars.com/api/?name=Imam+Adi+W&background=2E5039&color=fff&size=128" alt="Imam Adi W" class="w-full h-full object-cover">
                            </div>
                            <h4 class="font-bold text-gray-800">Imam Adi W.</h4>
                            <p class="text-xs text-primary font-semibold tracking-widest uppercase">672024123</p>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="w-32 h-32 rounded-full border-4 border-white shadow-md overflow-hidden mb-4 transform hover:scale-105 transition duration-300">
                                <img src="https://ui-avatars.com/api/?name=Driandiska+Purba+H&background=6E4E32&color=fff&size=128" alt="Driandiska Purba H" class="w-full h-full object-cover">
                            </div>
                            <h4 class="font-bold text-gray-800">Driandiska Purba H.</h4>
                            <p class="text-xs text-primary font-semibold tracking-widest uppercase">672024088</p>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="w-32 h-32 rounded-full border-4 border-white shadow-md overflow-hidden mb-4 transform hover:scale-105 transition duration-300">
                                <img src="https://ui-avatars.com/api/?name=Jonathan+Krisna+P&background=F5A623&color=fff&size=128" alt="Jonathan Krisna P" class="w-full h-full object-cover">
                            </div>
                            <h4 class="font-bold text-gray-800">Jonathan Krisna P.</h4>
                            <p class="text-xs text-primary font-semibold tracking-widest uppercase">672024093</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-16 bg-primary text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Tentang Desa Kalikurmo</h2>
            <p class="text-base md:text-lg mb-8 max-w-2xl mx-auto text-gray-200">
                Kenali lebih dekat berbagai potensi, program pemerintahan, dan pesona lain dari Desa Kalikurmo di luar kawasan wisata <i>offroad</i> melalui portal resmi desa kami.
            </p>
            <a href="https://desakalikurmo.com/" target="_blank" rel="noopener noreferrer" class="inline-block bg-white text-primary font-bold py-3 px-10 rounded-full hover:bg-gray-100 hover:shadow-xl transition duration-300 shadow-lg transform hover:-translate-y-1">
                Kunjungi Website Desa <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i>
            </a>
        </div>
    </section>

    <footer id="kontak" class="bg-secondary text-white pt-12 pb-6 mt-auto border-t-4 border-primary">
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
            if(slides.length > 0) {
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