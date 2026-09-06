<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Reservasi - Admin</title>
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
                <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">Pesanan Masuk</h2>
                <p class="text-base md:text-lg text-gray-600 mt-2">Konfirmasi pesanan baru atau hapus riwayat pemesanan lama.</p>
            </div>
            
            <div class="bg-white px-5 py-3 rounded-xl shadow-md border-l-4 border-accent font-bold text-gray-700 hidden md:flex items-center gap-3 text-lg shrink-0">
                <i class="fa-solid fa-file-invoice text-accent text-2xl"></i>
                Total: {{ $reservasi->count() }} Pesanan
            </div>
        </header>

        @if($reservasi->count() > 0)
            <form action="{{ url('/crud-reservasi/bulk-delete') }}" method="POST" id="formBulkDelete">
                @csrf
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <label class="flex items-center gap-4 cursor-pointer text-xl font-bold text-gray-800 w-full md:w-auto p-2 hover:bg-gray-50 rounded-lg transition">
                        <input type="checkbox" id="selectAll" class="w-8 h-8 rounded border-gray-400 text-primary focus:ring-primary cursor-pointer">
                        Centang Semua Pesanan
                    </label>
                    
                    <button type="button" onclick="konfirmasiHapusBanyak()" class="w-full md:w-auto bg-gray-800 hover:bg-red-600 text-white px-8 py-3.5 rounded-xl font-bold transition text-lg flex items-center justify-center gap-3 border shadow-sm">
                        <i class="fa-solid fa-trash-can text-xl"></i> Hapus Pesanan Terpilih
                    </button>
                    <button type="submit" name="hapus_terpilih" id="btnSubmitBulk" class="hidden"></button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6 w-full">
                    
                    @foreach($reservasi as $row)
                        @php
                            $bg_status = 'bg-yellow-100 text-yellow-800 border-yellow-300';
                            $icon_status = 'fa-hourglass-half';
                            $line_color = 'bg-yellow-400';
                            
                            if ($row->status == 'Selesai') { 
                                $bg_status = 'bg-green-100 text-green-800 border-green-300'; 
                                $icon_status = 'fa-check-circle';
                                $line_color = 'bg-green-500';
                            } else if ($row->status == 'Dibatalkan') { 
                                $bg_status = 'bg-red-100 text-red-800 border-red-300'; 
                                $icon_status = 'fa-times-circle';
                                $line_color = 'bg-red-500';
                            }
                        @endphp
                    
                    <div class="bg-white rounded-3xl shadow-sm hover:shadow-lg transition duration-300 border border-gray-200 p-6 flex flex-col relative overflow-hidden group">
                        
                        <label class="absolute top-4 left-4 z-20 cursor-pointer p-1 bg-white rounded">
                            <input type="checkbox" name="reservasi_ids[]" value="{{ $row->id }}" class="checkbox-rsv w-7 h-7 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer shadow-sm">
                        </label>

                        <a href="{{ url('/crud-reservasi/hapus/' . $row->id) }}" 
                           onclick="return confirm('Hapus permanen pesanan ini dari riwayat?')" 
                           class="absolute top-4 right-4 text-gray-400 hover:text-white hover:bg-red-500 bg-gray-50 shadow-sm border border-gray-200 rounded-full w-10 h-10 flex items-center justify-center transition duration-300 z-10"
                           title="Hapus Pesanan">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>

                        <div class="absolute top-0 left-0 w-full h-2 {{ $line_color }}"></div>
                        
                        <div class="flex flex-col gap-2 mb-4 mt-8">
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs font-black px-3 py-1.5 rounded-lg tracking-widest uppercase border w-max">
                                #{{ $row->kode_reservasi }}
                            </span>
                            <span class="inline-flex w-max px-3 py-1.5 rounded-lg text-xs font-black uppercase border shadow-sm items-center gap-1.5 {{ $bg_status }}">
                                <i class="fa-solid {{ $icon_status }}"></i> STATUS: {{ $row->status }}
                            </span>
                        </div>

                        <div class="mb-5 border-b border-gray-100 pb-4">
                            <p class="text-sm text-gray-500 mb-1">Nama Pemesan:</p>
                            <h3 class="text-2xl font-black text-gray-800 leading-tight">{{ $row->nama_lengkap }}</h3>
                            <p class="text-primary font-bold text-base mt-2"><i class="fa-solid fa-map-location-dot mr-1"></i> {{ $row->nama_paket }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <p class="text-xs text-gray-500 font-bold uppercase mb-1">Kunjungan</p>
                                <p class="font-bold text-gray-800 text-sm"><i class="fa-regular fa-calendar-check text-accent mr-1"></i> {{ date('d/m/Y', strtotime($row->tanggal_kunjungan)) }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <p class="text-xs text-gray-500 font-bold uppercase mb-1">Peserta</p>
                                <p class="font-bold text-gray-800 text-sm"><i class="fa-solid fa-users text-accent mr-1"></i> {{ $row->jumlah_orang }} Orang</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 col-span-2 flex justify-between items-center">
                                <p class="text-xs text-gray-500 font-bold uppercase">Biaya Total</p>
                                <p class="font-black text-primary text-xl">Rp {{ number_format($row->total_biaya, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        @if ($row->status == 'Menunggu Konfirmasi Admin' || $row->status == 'Menunggu')
                            <div class="mt-auto flex gap-3 pt-2">
                                <a href="{{ url('/crud-reservasi/status/' . $row->id . '/Selesai') }}" 
                                   onclick="return confirm('Terima dan tandai pesanan ini Selesai?')"
                                   class="flex-1 bg-green-100 text-green-700 hover:bg-green-600 hover:text-white border border-green-200 text-center py-3 rounded-xl text-base font-bold transition flex items-center justify-center gap-2 shadow-sm">
                                    <i class="fa-solid fa-check"></i> Selesai
                                </a>
                                <a href="{{ url('/crud-reservasi/status/' . $row->id . '/Dibatalkan') }}" 
                                   onclick="return confirm('Tolak/Batalkan pesanan ini?')"
                                   class="flex-1 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white border border-red-100 text-center py-3 rounded-xl text-base font-bold transition flex items-center justify-center gap-2 shadow-sm">
                                    <i class="fa-solid fa-xmark"></i> Batal
                                </a>
                            </div>
                        @else
                            <div class="mt-auto pt-2 text-center text-sm text-gray-400 italic">
                                Tindakan sudah diambil.
                            </div>
                        @endif

                    </div>
                    @endforeach
                    
                </div>
            </form>
        @else
            <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-20 flex flex-col items-center justify-center text-center mt-6">
                <i class="fa-solid fa-box-open text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-600 mb-2">Belum Ada Reservasi</h3>
                <p class="text-gray-400 text-lg">Pesanan dari wisatawan akan muncul di sini.</p>
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
                const checkboxes = document.querySelectorAll('.checkbox-rsv');
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        }

        function konfirmasiHapusBanyak() {
            const checkboxes = document.querySelectorAll('.checkbox-rsv:checked');
            
            if (checkboxes.length === 0) {
                alert('Mohon maaf, Anda belum memilih pesanan manapun. Silakan centang kotak di kiri atas kartu pesanan terlebih dahulu.');
                return;
            }

            const pesan = 'Apakah Anda benar-benar yakin ingin MENGHAPUS PERMANEN ' + checkboxes.length + ' data pesanan yang dipilih dari sistem?\n\nPerhatian: Data yang dihapus tidak dapat dilihat lagi.';
            
            if (confirm(pesan)) {
                document.getElementById('btnSubmitBulk').click();
            }
        }
    </script>
</body>
</html>