<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Paket Wisata - Admin</title>
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
                <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">Kelola Paket Wisata</h2>
                <p class="text-base md:text-lg text-gray-600 mt-2">Atur harga, rute, dan detail paket offroad yang ditawarkan.</p>
            </div>
            
            <a href="{{ url('/tambah-paket') }}" class="w-full lg:w-auto bg-primary hover:bg-secondary text-white px-6 py-3.5 rounded-xl text-lg font-bold shadow-md transition flex items-center justify-center gap-3 shrink-0">
                <i class="fa-solid fa-plus-circle text-xl"></i> Tambah Paket Baru
            </a>
        </header>

        @if($paket_wisata->count() > 0)
            <form action="{{ url('/crud-paket/bulk-delete') }}" method="POST" id="formBulkDelete">
                @csrf
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <label class="flex items-center gap-4 cursor-pointer text-xl font-bold text-gray-800 w-full md:w-auto p-2 hover:bg-gray-50 rounded-lg transition">
                        <input type="checkbox" id="selectAll" class="w-8 h-8 rounded border-gray-400 text-primary focus:ring-primary cursor-pointer">
                        Centang Semua Paket
                    </label>
                    
                    <button type="button" onclick="konfirmasiHapusBanyak()" class="w-full md:w-auto bg-red-100 hover:bg-red-600 text-red-600 hover:text-white px-8 py-3.5 rounded-xl font-bold transition text-lg flex items-center justify-center gap-3 border border-red-200 shadow-sm">
                        <i class="fa-solid fa-trash-can text-xl"></i> Hapus Paket Terpilih
                    </button>
                    <button type="submit" name="hapus_terpilih" id="btnSubmitBulk" class="hidden"></button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6 w-full">
                    
                    @foreach($paket_wisata as $row)
                    <div class="bg-white rounded-3xl shadow-sm hover:shadow-lg transition duration-300 border border-gray-200 overflow-hidden flex flex-col relative group">
                        
                        <label class="absolute top-3 left-3 z-20 cursor-pointer bg-white/90 backdrop-blur p-1.5 rounded-xl shadow-sm border border-gray-100">
                            <input type="checkbox" name="paket_ids[]" value="{{ $row->id }}" class="checkbox-paket w-7 h-7 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer">
                        </label>

                        <div class="relative h-56 bg-gray-200">
                            <img src="{{ asset($row->gambar) }}" onerror="this.src='https://images.unsplash.com/photo-1614055272365-d4cbf873c5df?q=80&w=600&auto=format&fit=crop'" class="w-full h-full object-cover">
                            
                            <div class="absolute top-3 right-3 flex gap-2 z-10">
                                <a href="{{ url('/edit-paket/' . $row->id) }}" class="w-10 h-10 bg-white/90 hover:bg-accent text-gray-700 hover:text-white rounded-xl flex items-center justify-center transition shadow-md backdrop-blur-sm" title="Edit Data">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="{{ url('/crud-paket/hapus/' . $row->id) }}" onclick="return confirm('Yakin ingin menghapus paket {{ addslashes($row->nama_paket) }} secara permanen?')" class="w-10 h-10 bg-red-500/90 hover:bg-red-600 text-white rounded-xl flex items-center justify-center transition shadow-md backdrop-blur-sm" title="Hapus Satu Paket">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-black text-2xl text-primary leading-tight pr-2">{{ $row->nama_paket }}</h3>
                            </div>
                            
                            <div class="mb-3">
                                <span class="bg-accent/10 text-accent font-black text-sm px-3 py-1.5 rounded-lg whitespace-nowrap">
                                    {{ $row->harga > 0 ? 'Rp ' . number_format($row->harga, 0, ',', '.') : 'GRATIS / Nego' }}
                                </span>
                            </div>
                            
                            <p class="text-base text-gray-600 italic line-clamp-2 mb-4 flex-grow">"{{ $row->deskripsi }}"</p>
                            
                            <div class="grid grid-cols-2 gap-3 mt-auto pt-4 border-t border-gray-100">
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <p class="text-xs text-gray-500 font-bold uppercase mb-1"><i class="fa-solid fa-clock text-secondary mr-1"></i> Durasi</p>
                                    <p class="font-bold text-gray-800 text-sm truncate" title="{{ $row->durasi }}">{{ $row->durasi }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <p class="text-xs text-gray-500 font-bold uppercase mb-1"><i class="fa-solid fa-car-side text-secondary mr-1"></i> Kapasitas</p>
                                    <p class="font-bold text-gray-800 text-sm truncate" title="{{ $row->kapasitas }}">{{ $row->kapasitas }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </form>
        @else
            <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-20 flex flex-col items-center justify-center text-center mt-6">
                <i class="fa-solid fa-map-location-dot text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-600 mb-2">Belum Ada Paket</h3>
                <p class="text-gray-400 text-lg">Silakan tambahkan paket wisata baru melalui tombol di kanan atas.</p>
            </div>
        @endif
    </main>

    <script>
        // burger menu
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.checkbox-paket');
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        }

        function konfirmasiHapusBanyak() {
            const checkboxes = document.querySelectorAll('.checkbox-paket:checked');
            
            if (checkboxes.length === 0) {
                alert('Mohon maaf, Anda belum mencentang paket wisata manapun. Silakan centang kotak di kiri atas gambar paket terlebih dahulu.');
                return;
            }

            const pesan = 'Apakah Anda benar-benar yakin ingin menghapus ' + checkboxes.length + ' paket wisata yang dipilih?\n\nPerhatian: Data paket beserta gambarnya akan dihapus secara permanen.';
            
            if (confirm(pesan)) {
                document.getElementById('btnSubmitBulk').click();
            }
        }
    </script>
</body>
</html>