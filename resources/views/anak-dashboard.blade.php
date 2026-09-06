<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Anak Admin - Kalikurmo Offroad</title>
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
        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end mb-8 border-b border-gray-300 pb-5 gap-4">
            <div class="w-full flex items-center gap-3 md:hidden bg-white p-4 rounded-2xl shadow-sm border border-gray-200">
                <button onclick="toggleSidebar()" class="text-3xl text-primary focus:outline-none hover:text-secondary transition p-2 bg-gray-50 rounded-lg active:bg-gray-200">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 class="text-xl font-black tracking-tighter text-primary">ADMIN <span class="text-accent">PANEL</span></h1>
            </div>

            <div class="mt-2 md:mt-0">
                <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight uppercase">Dasbor Sub-Admin</h2>
                <p class="text-base md:text-lg text-gray-600 mt-2">Selamat datang kembali, <b>{{ session('nama_lengkap') }}</b>. Anda login sebagai Anak Admin.</p>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10 w-full">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-lg transition">
                <div>
                    <p class="text-gray-500 text-sm font-bold mb-1 uppercase tracking-wider">Akses Terbuka</p>
                    <h3 class="text-3xl font-black text-primary">Data Wisatawan</h3>
                </div>
                <div class="bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center text-primary text-2xl shadow-inner border border-blue-100">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-lg transition">
                <div>
                    <p class="text-gray-500 text-sm font-bold mb-1 uppercase tracking-wider">Akses Terbuka</p>
                    <h3 class="text-3xl font-black text-primary">Manajemen Paket</h3>
                </div>
                <div class="bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center text-primary text-2xl shadow-inner border border-blue-100">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-lg transition">
                <div>
                    <p class="text-gray-500 text-sm font-bold mb-1 uppercase tracking-wider">Akses Terbuka</p>
                    <h3 class="text-3xl font-black text-primary">Pesanan Masuk</h3>
                </div>
                <div class="bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center text-primary text-2xl shadow-inner border border-blue-100">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-blue-50 rounded-3xl p-6 border border-blue-200">
            <h3 class="font-bold text-xl text-primary mb-2"><i class="fa-solid fa-circle-info"></i> Informasi Penting</h3>
            <p class="text-primary">Segala aktivitas penambahan, pengubahan, dan penghapusan data yang Anda lakukan akan dicatat oleh sistem dan dapat ditinjau oleh Super Admin.</p>
        </div>
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
