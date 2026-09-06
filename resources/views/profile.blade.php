<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Kalikurmo Offroad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] }, colors: { primary: '#2E5039', secondary: '#6E4E32', accent: '#F5A623' } } }
        }
    </script>
    <style> 
        html { scroll-behavior: smooth; } 
        .tab-active { border-bottom: 4px solid #F5A623; color: #2E5039; font-weight: bold; background-color: #ffffff; } 
        .tab-inactive { color: #6b7280; border-bottom: 4px solid transparent; } 
        .tab-inactive:hover { background-color: #f3f4f6; color: #374151; }
    </style>
</head>
<body class="bg-[#F8F9FA] text-gray-800 font-sans flex flex-col min-h-screen">

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
                <a href="{{ url('/profile') }}" class="hidden md:inline-block text-accent hover:text-secondary text-2xl transition duration-300">
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
            <a href="{{ url('/profile') }}" class="block py-2 mt-2 text-center bg-accent text-white font-bold rounded">Profil Saya</a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-10 max-w-6xl flex-grow">
        <div class="mb-8"><h1 class="text-3xl md:text-4xl font-extrabold text-primary">Dasbor Wisatawan</h1></div>
        
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 text-center sticky top-28">
                    <div class="w-32 h-32 mx-auto rounded-full border-4 border-gray-100 overflow-hidden mb-4 shadow-sm">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama_lengkap) }}&background=2E5039&color=fff&size=128" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $user->nama_lengkap }}</h2>
                    <p class="text-sm text-gray-500 mb-6">{{ $user->email }}</p>
                    <div class="flex flex-col gap-3">
                        <a href="{{ url('/paket') }}" class="w-full bg-primary hover:bg-secondary text-white font-bold py-3 rounded-xl transition shadow-md"><i class="fa-solid fa-plus mr-2"></i> Reservasi Baru</a>
                        <a href="{{ url('/logout') }}" onclick="return confirm('Apakah Anda yakin ingin keluar?');" class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-bold py-3 rounded-xl transition border border-red-200"><i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar Akun</a>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden">
                    
                    <div class="flex flex-wrap md:flex-nowrap border-b border-gray-200 bg-gray-50">
                        <button onclick="switchTab('reservasi')" id="btn-reservasi" class="w-full md:w-1/3 py-4 text-center text-sm md:text-base transition tab-active focus:outline-none"><i class="fa-solid fa-file-invoice mr-2"></i> Riwayat</button>
                        <button onclick="switchTab('aturan')" id="btn-aturan" class="w-full md:w-1/3 py-4 text-center text-sm md:text-base transition tab-inactive focus:outline-none"><i class="fa-solid fa-clipboard-list mr-2"></i> Aturan & SOP</button>
                        <button onclick="switchTab('galeri')" id="btn-galeri" class="w-full md:w-1/3 py-4 text-center text-sm md:text-base transition tab-inactive focus:outline-none"><i class="fa-solid fa-images mr-2"></i> Galeri Saya</button>
                    </div>
                    
                    <div class="p-6 md:p-8">
                        
                        <div id="tab-reservasi" class="block">
                            <h3 class="text-xl font-bold text-gray-800 mb-6">Riwayat Pemesanan Anda</h3>
                            
                            @if($reservasi->isEmpty())
                                <div class="text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                    <i class="fa-solid fa-box-open text-5xl text-gray-300 mb-3 block"></i>
                                    <p class="text-gray-500 font-medium">Belum ada riwayat reservasi.</p>
                                    <a href="{{ url('/paket') }}" class="text-primary font-bold text-sm hover:underline mt-2 inline-block">Mulai Petualangan Pertamamu!</a>
                                </div>
                            @else
                                @foreach($reservasi as $rsv)
                                    <div class="border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition bg-white mb-6 relative overflow-hidden">
                                        <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $rsv->status == 'Selesai' ? 'bg-green-500' : ($rsv->status == 'Dibatalkan' ? 'bg-red-500' : 'bg-accent') }}"></div>
                                        
                                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 border-b border-gray-100 pb-4">
                                            <div>
                                                <span class="text-xs text-gray-500 font-bold bg-gray-100 px-2 py-1 rounded block mb-2 w-max">ID: {{ $rsv->kode_reservasi }}</span>
                                                <h4 class="font-extrabold text-lg md:text-xl text-primary">{{ $rsv->nama_paket }}</h4>
                                            </div>
                                            <div class="mt-2 md:mt-0 text-right">
                                                @php 
                                                    $bg_color = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                                                    $icon = 'fa-hourglass-half';
                                                    if ($rsv->status == 'Selesai') { $bg_color = 'bg-green-100 text-green-700 border-green-200'; $icon = 'fa-check'; }
                                                    if ($rsv->status == 'Dibatalkan') { $bg_color = 'bg-red-100 text-red-700 border-red-200'; $icon = 'fa-xmark'; }
                                                @endphp
                                                <span class="text-xs font-bold px-3 py-1.5 rounded-full shadow-sm border {{ $bg_color }}">
                                                    <i class="fa-solid {{ $icon }} mr-1"></i> {{ $rsv->status }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-4">
                                            <div>
                                                <p class="text-gray-400 text-xs mb-1">Tanggal Main</p>
                                                <p class="font-semibold text-gray-700"><i class="fa-regular fa-calendar-check text-accent mr-1"></i> {{ date('d M Y', strtotime($rsv->tanggal_kunjungan)) }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-400 text-xs mb-1">Peserta</p>
                                                <p class="font-semibold text-gray-700"><i class="fa-solid fa-users text-accent mr-1"></i> {{ $rsv->jumlah_orang }} Orang</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-400 text-xs mb-1">Harga Satuan</p>
                                                <p class="font-semibold text-gray-700">Rp {{ number_format($rsv->harga_satuan, 0, ',', '.') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-400 text-xs mb-1">Total Biaya</p>
                                                <p class="font-black text-primary text-base">Rp {{ number_format($rsv->total_biaya, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        <div class="bg-gray-50 p-3 rounded-lg text-sm text-gray-600 italic border border-gray-100">
                                            <span class="font-semibold not-italic text-gray-700 text-xs block mb-1">Catatan Tambahan:</span>
                                            "{{ empty($rsv->catatan) ? 'Tidak ada catatan.' : $rsv->catatan }}"
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div id="tab-aturan" class="hidden">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2 border-gray-100">Aturan Wisata Desa Kalikurmo</h3>
                            <p class="text-gray-600 mb-6 text-sm leading-relaxed">
                                Demi menjaga keselamatan, kenyamanan bersama, dan kelestarian alam Desa Kalikurmo, seluruh wisatawan wajib mematuhi aturan komunitas S4X4TIGA berikut:
                            </p>

                            <ul class="space-y-4">
                                <li class="flex items-start gap-4 p-4 bg-red-50 rounded-xl border border-red-100">
                                    <div class="bg-red-500 text-white p-2 rounded-lg mt-1"><i class="fa-solid fa-moon"></i></div>
                                    <div>
                                        <h4 class="font-bold text-red-700 mb-1">Dilarang Berkegiatan di Malam Hari</h4>
                                        <p class="text-sm text-red-600">Aktivitas dilarang keras dilakukan pada malam hari karena alasan jarak pandang dan risiko keselamatan yang tinggi di area hutan.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4 p-4 bg-blue-50 rounded-xl border border-blue-100">
                                    <div class="bg-blue-500 text-white p-2 rounded-lg mt-1"><i class="fa-solid fa-calendar-check"></i></div>
                                    <div>
                                        <h4 class="font-bold text-blue-700 mb-1">Wajib Reservasi Maksimal H-7</h4>
                                        <p class="text-sm text-blue-600">Pemesanan paket wajib diselesaikan minimal 7 hari sebelum jadwal kunjungan untuk persiapan mobil dan akomodasi.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4 p-4 bg-green-50 rounded-xl border border-green-100">
                                    <div class="bg-green-500 text-white p-2 rounded-lg mt-1"><i class="fa-solid fa-hands-holding-circle"></i></div>
                                    <div>
                                        <h4 class="font-bold text-green-700 mb-1">Menjaga Diri Sendiri dan Teman</h4>
                                        <p class="text-sm text-green-600">Patuhi instruksi *driver/guide* dan saling mengingatkan akan keselamatan antar anggota regu selama di perjalanan.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4 p-4 bg-orange-50 rounded-xl border border-orange-100">
                                    <div class="bg-accent text-white p-2 rounded-lg mt-1"><i class="fa-solid fa-mosque"></i></div>
                                    <div>
                                        <h4 class="font-bold text-orange-700 mb-1">Menghormati Adat Setempat</h4>
                                        <p class="text-sm text-orange-600">Jaga sopan santun saat berinteraksi dengan warga sekitar dan dilarang merusak fasilitas desa seperti mushola atau tempat bilas.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div id="tab-galeri" class="hidden">
                             <h3 class="text-xl font-bold text-gray-800 mb-6">Momen yang Anda Bagikan</h3>
                             @if($galeri->isEmpty())
                                <div class="text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                    <i class="fa-solid fa-camera-retro text-4xl text-gray-300 mb-3 block"></i>
                                    <p class="text-gray-500 font-medium">Anda belum pernah mengunggah momen.</p>
                                    <a href="{{ url('/galeri') }}" class="text-primary font-bold text-sm hover:underline mt-2 inline-block">Unggah Sekarang</a>
                                </div>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($galeri as $post)
                                        <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm relative">
                                            <div class="h-40 bg-gray-200">
                                                @if($post->jenis_media == 'foto')
                                                    <img src="{{ $post->media_url }}" class="w-full h-full object-cover">
                                                @else
                                                    <video src="{{ $post->media_url }}" class="w-full h-full object-cover"></video>
                                                @endif
                                            </div>
                                            <div class="p-4">
                                                <p class="text-sm text-gray-600 italic line-clamp-2">"{{ $post->caption }}"</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

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
        btn.addEventListener('click', () => { menu.classList.toggle('hidden'); });

        function switchTab(tabId) {
            ['reservasi', 'aturan', 'galeri'].forEach(id => {
                document.getElementById('tab-' + id).classList.add('hidden');
                document.getElementById('tab-' + id).classList.remove('block');
                document.getElementById('btn-' + id).className = "w-full md:w-1/3 py-4 text-center text-sm md:text-base transition tab-inactive focus:outline-none";
            });
            
            document.getElementById('tab-' + tabId).classList.remove('hidden');
            document.getElementById('tab-' + tabId).classList.add('block');
            document.getElementById('btn-' + tabId).className = "w-full md:w-1/3 py-4 text-center text-sm md:text-base transition tab-active focus:outline-none";
        }
    </script>
</body>
</html>