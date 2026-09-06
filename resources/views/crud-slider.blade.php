<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Slider - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = { 
            theme: { extend: { colors: { primary: '#2E5039', secondary: '#6E4E32', accent: '#F5A623' } } } 
        }
    </script>
</head>
<body class="bg-gray-100 flex min-h-screen font-sans overflow-x-hidden">

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/60 z-40 hidden transition-opacity duration-300" onclick="toggleSidebar()"></div>

    @include('layouts.sidebar')

    <main class="flex-grow p-5 md:p-10 overflow-y-auto min-w-0 w-full relative">
        
        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 border-b border-gray-300 pb-5 gap-4">
            
            <div class="w-full flex items-center gap-3 md:hidden bg-white p-4 rounded-2xl shadow-sm border border-gray-200">
                <button onclick="toggleSidebar()" class="text-3xl text-primary focus:outline-none hover:text-secondary transition p-2 bg-gray-50 rounded-lg active:bg-gray-200">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 class="text-xl font-black tracking-tighter text-primary">ADMIN <span class="text-accent">PANEL</span></h1>
            </div>

            <div class="mt-2 md:mt-0">
                <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">Kelola Slider Gambar</h2>
                <p class="text-base md:text-lg text-gray-600 mt-2">Atur gambar banner (slide) pada setiap halaman website.</p>
            </div>
            
            <div class="bg-white px-5 py-3 rounded-xl shadow-md border-l-4 border-accent font-bold text-gray-700 hidden md:flex items-center gap-3 text-lg shrink-0">
                <i class="fa-solid fa-image text-accent text-2xl"></i> Total: {{ count($slide_foto) }} Slide
            </div>
        </header>

        @if(session('success'))
            <div class="bg-green-50 border-l-8 border-green-500 text-green-800 p-5 mb-8 rounded-xl shadow-sm flex items-center gap-4 text-lg font-bold">
                <i class="fa-solid fa-circle-check text-3xl"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-8 border-red-500 text-red-800 p-5 mb-8 rounded-xl shadow-sm flex items-center gap-4 text-lg font-bold">
                <i class="fa-solid fa-circle-exclamation text-3xl"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 mb-8">
            <h3 class="text-xl font-bold mb-4">Tambah Gambar Slide Baru</h3>
            <form action="{{ url('/crud-slider') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-4">
                @csrf
                <div class="flex-grow">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Halaman</label>
                    <select name="halaman" required class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                        <option value="beranda">Beranda</option>
                        <option value="paket">Paket</option>
                        <option value="galeri">Galeri</option>
                        <option value="tentang-kami">Tentang Kami</option>
                    </select>
                </div>
                <div class="flex-grow">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Pilih File Foto (Max: 2MB)</label>
                    <input type="file" name="gambar" accept="image/*" required class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-lg transition h-[46px] w-full md:w-auto">
                        <i class="fa-solid fa-upload mr-2"></i> Upload
                    </button>
                </div>
            </form>
        </div>

        @if (count($slide_foto) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6 w-full">
                @foreach($slide_foto as $row)
                    @php
                        $badge_color = 'bg-gray-500';
                        $border_color = 'border-gray-100';
                        $bg_footer = 'bg-white';
                        if ($row->halaman == 'beranda') {
                            $badge_color = 'bg-blue-500';
                            $border_color = 'border-blue-300';
                            $bg_footer = 'bg-blue-50';
                        } elseif ($row->halaman == 'paket') {
                            $badge_color = 'bg-green-500';
                            $border_color = 'border-green-300';
                            $bg_footer = 'bg-green-50';
                        } elseif ($row->halaman == 'galeri') {
                            $badge_color = 'bg-red-500';
                            $border_color = 'border-red-300';
                            $bg_footer = 'bg-red-50';
                        } elseif ($row->halaman == 'tentang-kami') {
                            $badge_color = 'bg-orange-500';
                            $border_color = 'border-orange-300';
                            $bg_footer = 'bg-orange-50';
                        }
                        
                        $halaman_title = ucwords(str_replace('-', ' ', $row->halaman));
                    @endphp
                    <div class="{{ $bg_footer }} rounded-3xl shadow-sm hover:shadow-lg transition duration-300 border-2 {{ $border_color }} overflow-hidden flex flex-col group relative">
                        <div class="relative h-48 bg-gray-200 overflow-hidden border-b {{ $border_color }}">
                            <img src="{{ asset($row->gambar_url) }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <span class="absolute top-3 left-3 text-white text-xs font-bold px-3 py-1.5 rounded shadow-md {{ $badge_color }}">
                                {{ $halaman_title }}
                            </span>
                        </div>

                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div class="flex justify-between items-center">
                                <p class="text-sm font-bold text-gray-700 truncate mr-2" title="{{ $row->gambar_url }}">
                                    {{ basename($row->gambar_url) }}
                                </p>
                                <a href="{{ url('/crud-slider/hapus/' . $row->id) }}" onclick="return confirm('Hapus gambar ini?')" class="text-red-500 hover:text-white hover:bg-red-600 bg-white p-2.5 rounded-xl border border-red-200 transition shadow-sm flex-shrink-0" title="Hapus Gambar Ini">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-20 flex flex-col items-center justify-center text-center mt-6">
                <i class="fa-solid fa-images text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-600 mb-2">Slider Belum Ada</h3>
                <p class="text-gray-400 text-lg">Silakan upload gambar untuk slider di atas.</p>
            </div>
        @endif

    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>
