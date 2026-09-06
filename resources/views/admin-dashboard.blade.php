<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kalikurmo Offroad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">Selamat Datang, {{ session('nama') }}!</h2>
                <p class="text-base text-gray-600 mt-2">Berikut ringkasan pekerjaan Anda hari ini di Desa Wisata Kalikurmo.</p>
            </div>
            
            <div class="bg-white px-5 py-3 rounded-xl shadow-md border-l-4 border-accent font-bold text-gray-700 hidden md:flex items-center gap-3 text-lg shrink-0">
                <i class="fa-regular fa-clock text-accent text-2xl"></i>
                {{ date('d M Y') }}
            </div>
        </header>

        <h3 class="text-xl font-bold text-gray-700 mb-4"><i class="fa-solid fa-bell text-accent mr-2"></i> Pusat Perhatian Anda</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            
            <div class="bg-white rounded-3xl shadow-md border-l-8 {{ $rsv_pending > 0 ? 'border-red-500' : 'border-green-500' }} p-6 flex flex-col hover:shadow-lg transition">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="text-xl font-black text-gray-800">Pesanan Masuk (Reservasi)</h4>
                        <p class="text-gray-500 text-sm mt-1">Total seluruh pesanan: {{ $total_rsv }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-gray-50 border flex items-center justify-center text-2xl text-gray-400">
                        <i class="fa-solid fa-car-side"></i>
                    </div>
                </div>
                
                @if($rsv_pending > 0)
                    <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-4 font-bold border border-red-100 flex items-center gap-3 text-lg">
                        <i class="fa-solid fa-circle-exclamation text-2xl"></i>
                        Ada {{ $rsv_pending }} pesanan butuh konfirmasi!
                    </div>
                @else
                    <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-4 font-bold border border-green-100 flex items-center gap-3">
                        <i class="fa-solid fa-check-circle text-2xl"></i>
                        Semua pesanan sudah tertangani.
                    </div>
                @endif
                
                <a href="{{ url('/crud-reservasi') }}" class="mt-auto block text-center w-full bg-gray-800 hover:bg-gray-900 text-white font-bold py-3.5 rounded-xl transition text-lg">
                    Cek Halaman Pesanan <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-md border-l-8 {{ $media_pending > 0 ? 'border-orange-500' : 'border-green-500' }} p-6 flex flex-col hover:shadow-lg transition">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="text-xl font-black text-gray-800">Foto & Video Pengunjung</h4>
                        <p class="text-gray-500 text-sm mt-1">Total media tayang: {{ $total_media }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-gray-50 border flex items-center justify-center text-2xl text-gray-400">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                </div>
                
                @if($media_pending > 0)
                    <div class="bg-orange-50 text-orange-700 p-4 rounded-xl mb-4 font-bold border border-orange-100 flex items-center gap-3 text-lg">
                        <i class="fa-solid fa-image text-2xl"></i>
                        Ada {{ $media_pending }} kiriman butuh persetujuan.
                    </div>
                @else
                    <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-4 font-bold border border-green-100 flex items-center gap-3">
                        <i class="fa-solid fa-check-circle text-2xl"></i>
                        Tidak ada kiriman baru.
                    </div>
                @endif
                
                <a href="{{ url('/crud-galeri') }}" class="mt-auto block text-center w-full bg-gray-800 hover:bg-gray-900 text-white font-bold py-3.5 rounded-xl transition text-lg">
                    Tinjau Kiriman Galeri <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
            
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200 flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-primary text-white flex items-center justify-center text-4xl shadow-md">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-gray-500 font-bold uppercase tracking-wider text-sm">Akun Terdaftar</p>
                    <h3 class="text-4xl font-black text-gray-800 mt-1">{{ $total_users }} <span class="text-lg font-medium text-gray-400">Orang</span></h3>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200 flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-secondary text-white flex items-center justify-center text-4xl shadow-md">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <div>
                    <p class="text-gray-500 font-bold uppercase tracking-wider text-sm">Paket Wisata</p>
                    <h3 class="text-4xl font-black text-gray-800 mt-1">{{ $total_paket }} <span class="text-lg font-medium text-gray-400">Aktif</span></h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100 w-full overflow-hidden">
            <h4 class="text-xl md:text-2xl font-black text-gray-800 mb-2"><i class="fa-solid fa-chart-pie mr-2 text-primary"></i> Statistik Paket Wisata</h4>
            <p class="text-gray-500 mb-8 text-sm md:text-base">Grafik paket yang paling banyak dipesan pengunjung.</p>
            <div class="relative h-64 md:h-72 w-full">
                <canvas id="paketStatsChart"></canvas>
            </div>
        </div>
    </main>

    <script>
        // burger menu
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // grafik
        document.addEventListener("DOMContentLoaded", function() {
            const ctxPaket = document.getElementById('paketStatsChart');
            if (ctxPaket) {
                new Chart(ctxPaket.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: @json($label_paket),
                        datasets: [{
                            label: 'Total Pesanan Masuk',
                            data: @json($data_paket),
                            backgroundColor: '#2E5039',
                            hoverBackgroundColor: '#F5A623',
                            borderRadius: 8,
                            barPercentage: 0.6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { display: false },
                            tooltip: { titleFont: { size: 14 }, bodyFont: { size: 13 }, padding: 10 }
                        },
                        scales: { 
                            y: { 
                                beginAtZero: true, 
                                ticks: { precision: 0 } 
                            },
                            x: {
                                ticks: { font: { weight: 'bold' } } 
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>