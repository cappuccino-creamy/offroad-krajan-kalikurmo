<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Wisata Offroad Kalikurmo</title>
    
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
                <a href="{{ url('/') }}" class="text-primary border-b-2 border-primary">Beranda</a>
                <a href="{{ url('/paket') }}" class="hover:text-primary transition duration-300">Paket Wisata</a>
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
            <a href="{{ url('/') }}" class="block py-2 text-primary font-bold">Beranda</a>
            <a href="{{ url('/paket') }}" class="block py-2 text-gray-700 hover:text-primary">Paket Wisata</a>
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
            @foreach($slider_images as $index => $img)
                <img src="{{ $img }}" 
                     class="slide absolute inset-0 w-full h-full object-cover {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" 
                     alt="Slide {{ $index }}">
            @endforeach
        </div>
        
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        
        <div class="absolute inset-0 flex flex-col justify-center items-center text-center text-white px-4">
            <h1 class="text-3xl md:text-5xl font-extrabold mb-3 md:mb-5 tracking-wide drop-shadow-lg">DESA KALIKURMO YANG <span class="text-accent">MAJU & BERSATU</span></h1>
            <p class="text-sm md:text-xl mb-6 md:mb-10 max-w-2xl drop-shadow-md">Menjelajahi hutan dan menikmati tantangan alam bersama komunitas S4X4TIGA Salatiga di Dusun Krajan.</p>
            <a href="{{ url('/paket') }}" class="bg-accent hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-full transition duration-300 shadow-xl transform hover:-translate-y-1">
                Pesan Sekarang <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>

    <section class="py-12 md:py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10 md:mb-14">
                <h2 class="text-2xl md:text-4xl font-bold text-primary">Daya Tarik Desa Kalikurmo</h2>
                <div class="w-24 h-1.5 bg-accent mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-4 md:p-6 rounded-xl hover:shadow-lg transition">
                    <div class="text-4xl md:text-5xl text-secondary mb-4"><i class="fa-solid fa-users"></i></div>
                    <h3 class="text-lg font-bold mb-2">Komunitas Terlatih</h3>
                    <p class="text-xs md:text-sm text-gray-500">Dipandu langsung oleh grup off road S4X4TIGA Salatiga yang paham medan perjalanan.</p>
                </div>
                <div class="p-4 md:p-6 rounded-xl hover:shadow-lg transition">
                    <div class="text-4xl md:text-5xl text-secondary mb-4"><i class="fa-solid fa-campground"></i></div>
                    <h3 class="text-lg font-bold mb-2">Fasilitas Menginap</h3>
                    <p class="text-xs md:text-sm text-gray-500">Tersedia opsi mendirikan tenda camp atau menginap dan berbaur di rumah-rumah warga.</p>
                </div>
                <div class="p-4 md:p-6 rounded-xl hover:shadow-lg transition">
                    <div class="text-4xl md:text-5xl text-secondary mb-4"><i class="fa-solid fa-utensils"></i></div>
                    <h3 class="text-lg font-bold mb-2">Kuliner Desa</h3>
                    <p class="text-xs md:text-sm text-gray-500">Sajian Pisang Godog, Nasi Jagung, Singkong Sambal, dan Utri siap menemani tamu.</p>
                </div>
                <div class="p-4 md:p-6 rounded-xl hover:shadow-lg transition">
                    <div class="text-4xl md:text-5xl text-secondary mb-4"><i class="fa-solid fa-clock"></i></div>
                    <h3 class="text-lg font-bold mb-2">Waktu Fleksibel</h3>
                    <p class="text-xs md:text-sm text-gray-500">Operasional 24 jam menyesuaikan jadwal tamu.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="galeri" class="py-12 md:py-20 bg-white border-t">
        <div class="container mx-auto px-4">
            
            <div class="flex justify-between items-end mb-8 md:mb-12 border-b-2 border-gray-100 pb-4">
                <div>
                    <h2 class="text-2xl md:text-4xl font-bold text-gray-800">Galeri Keseruan</h2>
                    <p class="text-sm md:text-base text-gray-500 mt-2">Momen petualangan seru tak terlupakan di Kalikurmo.</p>
                </div>
                <a href="{{ url('/galeri') }}" class="hidden md:inline-flex items-center gap-2 text-primary font-bold hover:text-accent transition duration-300">
                    Lihat Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"> 
                @if(isset($galeri_beranda) && count($galeri_beranda) > 0)
                    @foreach($galeri_beranda as $post)
                        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col overflow-hidden border-b-4 border-secondary group relative">
                            
                            <div class="w-full h-64 bg-black relative overflow-hidden">
                                @if($post->jenis_media == 'foto') 
                                    <img src="{{ asset($post->media_url) }}" alt="Wisata" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-700 cursor-pointer" onclick="openFullscreen(this.src)">
                                @else
                                    <video src="{{ asset($post->media_url) }}" class="w-full h-full object-cover" controls preload="none"></video>
                                @endif
                                
                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-primary text-xs font-bold px-3 py-1 rounded shadow-sm z-10">
                                    <i class="fa-regular fa-calendar-days mr-1"></i> {{ date('d M Y', strtotime($post->waktu_upload)) }}
                                </div>
                            </div>

                            <div class="p-6 flex flex-col grow relative">
                                
                                @if($post->jenis_media == 'foto')
                                    <button onclick="openFullscreen('{{ asset($post->media_url) }}')" class="absolute -top-5 right-6 bg-accent hover:brightness-110 text-white w-10 h-10 flex items-center justify-center rounded-xl shadow-lg transition-transform duration-300 transform hover:scale-110 z-20 cursor-pointer" title="Perbesar Gambar">
                                        <i class="fa-solid fa-expand text-lg"></i>
                                    </button>
                                @endif

                                <p class="text-gray-600 text-sm md:text-base leading-relaxed mb-4 grow">
                                    {{ $post->caption }}
                                </p>
                                
                                <div class="mt-auto border-t border-gray-100 pt-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($post->nama_user) }}&background=2E5039&color=fff&bold=true" alt="User" loading="lazy" class="w-10 h-10 rounded-full border border-gray-200">
                                        <div>
                                            <h4 class="font-bold text-primary text-sm">{{ $post->nama_user }}</h4>
                                            <p class="text-[10px] text-gray-400 uppercase">Pengunjung</p>
                                        </div>
                                    </div>
                                    
                                    @php 
                                        $is_owner = (session()->has('user_id') && session('user_id') == $post->user_id);
                                        $is_admin = (session()->has('role') && session('role') == 'admin');
                                    @endphp
                                    
                                    @if($is_owner || $is_admin)
                                        <form action="{{ url('/galeri/delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus cerita ini? Data akan hilang selamanya.');">
                                            @csrf
                                            <input type="hidden" name="delete_id" value="{{ $post->id }}">
                                            <button type="submit" name="delete_post" class="text-red-400 hover:text-red-600 transition" title="Hapus Postingan">
                                                <i class="fa-solid fa-trash-can text-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-1 md:col-span-2 lg:col-span-4 text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                        <p class="text-gray-500">
                            Belum ada momen yang diunggah. Jadilah yang pertama di halaman <a href="{{ url('/galeri') }}" class="text-primary font-bold hover:underline">Galeri</a>!
                        </p>
                    </div>
                @endif
            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="{{ url('/galeri') }}" class="inline-flex items-center justify-center w-full bg-gray-100 hover:bg-gray-200 text-primary font-bold py-3 rounded-xl transition duration-300">
                    Lihat Selengkapnya <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
            
        </div>
    </section>

    <div id="fullscreenModal" class="fixed inset-0 z-[100] hidden bg-black bg-opacity-95 flex items-center justify-center p-4 transition-opacity duration-300" style="backdrop-filter: blur(5px);">
        <button onclick="closeFullscreen()" class="absolute top-6 right-6 text-white text-5xl hover:text-accent focus:outline-none transition-colors z-[110]">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <img id="modalImg" src="" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl border-4 border-gray-800 transition-transform duration-300 scale-95">
    </div>

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

    if (btn && menu) {
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }

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

    function openFullscreen(imgSrc) {
        const modal = document.getElementById('fullscreenModal');
        const modalImg = document.getElementById('modalImg');
        
        if (modal && modalImg) {
            modalImg.src = imgSrc;
            modal.classList.remove('hidden');
            
            setTimeout(() => { 
                modalImg.classList.remove('scale-95'); 
                modalImg.classList.add('scale-100'); 
            }, 10);
            
            document.body.style.overflow = 'hidden'; 
        }
    }

    function closeFullscreen() {
        const modal = document.getElementById('fullscreenModal');
        const modalImg = document.getElementById('modalImg');
        
        if (modal && modalImg) {
            modalImg.classList.remove('scale-100');
            modalImg.classList.add('scale-95');
            
            setTimeout(() => { 
                modal.classList.add('hidden'); 
                document.body.style.overflow = 'auto'; 
            }, 250);
        }
    }

    const modalBg = document.getElementById('fullscreenModal');
    if (modalBg) {
        modalBg.addEventListener('click', function(e) {
            if (e.target === this) closeFullscreen();
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            closeFullscreen();
        }
    });
</script>
</body>
</html>