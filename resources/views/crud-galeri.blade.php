<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Galeri - Admin</title>
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
                <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">Tinjau Galeri</h2>
                <p class="text-base md:text-lg text-gray-600 mt-2">Setujui foto/video pengunjung atau hapus yang tidak pantas.</p>
            </div>
            
            <div class="bg-white px-5 py-3 rounded-xl shadow-md border-l-4 border-accent font-bold text-gray-700 hidden md:flex items-center gap-3 text-lg shrink-0">
                <i class="fa-solid fa-image text-accent text-2xl"></i> Total: {{ $galeri->count() }} Media
            </div>
        </header>

        @if ($galeri->count() > 0)
            <form action="{{ url('/crud-galeri/bulk-delete') }}" method="POST" id="formBulkDelete">
                @csrf
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <label class="flex items-center gap-4 cursor-pointer text-xl font-bold text-gray-800 w-full md:w-auto p-2 hover:bg-gray-50 rounded-lg transition">
                        <input type="checkbox" id="selectAll" class="w-8 h-8 rounded border-gray-400 text-primary focus:ring-primary cursor-pointer">
                        Centang Semua Foto / Video
                    </label>
                    
                    <button type="button" onclick="konfirmasiHapusBanyak()" class="w-full md:w-auto bg-red-100 hover:bg-red-600 text-red-600 hover:text-white px-8 py-3.5 rounded-xl font-bold transition text-lg flex items-center justify-center gap-3 border border-red-200 shadow-sm">
                        <i class="fa-solid fa-trash-can text-xl"></i> Hapus Media Terpilih
                    </button>
                    <button type="submit" name="hapus_terpilih" id="btnSubmitBulk" class="hidden"></button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6 w-full">
                    
                    @foreach($galeri as $row)
                        @php 
                            $ext = strtolower(pathinfo($row->media_url, PATHINFO_EXTENSION));
                            $is_video = in_array($ext, ['mp4', 'webm', 'ogg', 'mov']);
                            $status_color = ($row->status == 'pending') ? 'bg-orange-500' : 'bg-green-600';
                            $status_text = ($row->status == 'pending') ? 'Butuh Persetujuan' : 'Tayang Publik';
                        @endphp
                    
                        <div class="bg-white rounded-3xl shadow-sm hover:shadow-lg transition duration-300 border-2 {{ ($row->status == 'pending') ? 'border-orange-300' : 'border-gray-100' }} overflow-hidden flex flex-col group relative">
                            
                            <label class="absolute top-3 left-3 z-20 cursor-pointer bg-white/90 backdrop-blur p-2 rounded-xl shadow-md border border-gray-200" onclick="event.stopPropagation()">
                                <input type="checkbox" name="galeri_ids[]" value="{{ $row->id }}" class="checkbox-galeri w-7 h-7 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer">
                            </label>

                            <div class="relative h-56 bg-gray-200 cursor-pointer overflow-hidden" 
                                 onclick="openModal('{{ asset($row->media_url) }}', {{ $is_video ? 'true' : 'false' }}, '{{ htmlspecialchars(addslashes($row->caption), ENT_QUOTES) }}')">
                                
                                @if ($is_video)
                                    <video src="{{ asset($row->media_url) }}" class="w-full h-full object-cover" preload="none"></video>
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center group-hover:bg-black/60 transition">
                                        <i class="fa-solid fa-circle-play text-white text-6xl opacity-80 group-hover:opacity-100 group-hover:scale-110 transition transform shadow-xl rounded-full"></i>
                                    </div>
                                @else
                                    <img src="{{ asset($row->media_url) }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @endif
                                
                                <span class="absolute top-3 right-3 text-white text-xs font-bold px-3 py-1.5 rounded shadow-md {{ $status_color }}">
                                    {{ $status_text }}
                                </span>
                                
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none z-10">
                                    <div class="bg-white/90 text-gray-800 p-4 rounded-full shadow-lg backdrop-blur-sm pointer-events-auto flex items-center gap-2 font-bold text-sm">
                                        <i class="fa-solid fa-magnifying-glass-plus text-xl"></i> Lihat Penuh
                                    </div>
                                </div>
                            </div>

                            <div class="p-5 flex-grow flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-3">
                                        <p class="font-black text-gray-800 text-base truncate pr-2"><i class="fa-solid fa-user-circle text-gray-400 mr-2 text-xl"></i> {{ $row->nama_lengkap }}</p>
                                        
                                        <a href="{{ url('/crud-galeri/hapus/' . $row->id) }}" onclick="return confirm('Hapus konten ini secara permanen?')" class="text-red-500 hover:text-white hover:bg-red-600 bg-red-50 p-2.5 rounded-xl border border-red-100 transition shadow-sm" title="Hapus Gambar Ini">
                                            <i class="fa-solid fa-trash-can text-lg"></i>
                                        </a>
                                    </div>
                                    <p class="text-sm text-gray-700 italic line-clamp-3 mb-4 p-3 bg-gray-50 rounded-lg border border-gray-100">"{{ $row->caption }}"</p>
                                </div>
                                
                                @if($row->status == 'pending')
                                    <div class="mt-auto pt-2 border-t border-gray-200">
                                        <a href="{{ url('/crud-galeri/terima/' . $row->id) }}" onclick="return confirm('Tampilkan postingan ini ke Galeri Publik agar bisa dilihat wisatawan lain?')" class="flex w-full bg-green-600 hover:bg-green-700 text-white items-center justify-center gap-2 text-base font-bold py-3.5 rounded-xl transition shadow-md">
                                            <i class="fa-solid fa-thumbs-up text-xl"></i> Setujui Konten
                                        </a>
                                    </div>
                                @else
                                     <div class="mt-auto pt-2 border-t border-gray-100 text-center text-sm font-bold text-gray-400">
                                        Sudah Tampil di Web
                                     </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        @else
            <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-20 flex flex-col items-center justify-center text-center mt-6">
                <i class="fa-solid fa-photo-film text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-600 mb-2">Galeri Masih Kosong</h3>
                <p class="text-gray-400 text-lg">Belum ada wisatawan yang mengunggah momen mereka.</p>
            </div>
        @endif

    </main>

    <div id="mediaModal" class="fixed inset-0 z-[100] bg-black/95 hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300 backdrop-blur-sm">
        <button onclick="closeModal()" class="absolute top-6 right-6 text-white/50 hover:text-white text-4xl focus:outline-none hover:scale-110 transition transform"><i class="fa-solid fa-xmark"></i></button>
        <div class="w-full max-w-5xl p-4 flex flex-col items-center">
            <img id="modalImg" class="max-h-[75vh] max-w-full rounded-lg hidden shadow-2xl border border-white/10" src="" alt="Zoomed Media">
            <video id="modalVid" class="max-h-[75vh] max-w-full rounded-lg hidden shadow-2xl border border-white/10 outline-none" controls controlsList="nodownload"></video>
            <p id="modalCaption" class="text-gray-300 mt-6 text-center italic text-lg lg:text-xl font-light max-w-2xl px-4"></p>
        </div>
    </div>

    <script>
        // burger menu
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        const modal = document.getElementById('mediaModal');
        const modalImg = document.getElementById('modalImg');
        const modalVid = document.getElementById('modalVid');
        const modalCaption = document.getElementById('modalCaption');

        function openModal(url, isVideo, caption) {
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.remove('opacity-0'); }, 10);
            modalCaption.innerText = caption ? '"' + caption + '"' : '';
            if (isVideo) {
                modalImg.classList.add('hidden');
                modalVid.classList.remove('hidden');
                modalVid.src = url;
                modalVid.play();
            } else {
                modalVid.classList.add('hidden');
                modalVid.pause();
                modalImg.classList.remove('hidden');
                modalImg.src = url;
            }
        }

        function closeModal() {
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modalVid.pause();
                modalVid.src = '';
                modalImg.src = '';
            }, 300);
        }

        modal.addEventListener('click', function(e) {
            if (e.target === modal || e.target.parentElement === modal && e.target !== modalImg && e.target !== modalVid) { closeModal(); }
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) { closeModal(); }
        });

        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.checkbox-galeri');
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        }

        function konfirmasiHapusBanyak() {
            const checkboxes = document.querySelectorAll('.checkbox-galeri:checked');
            
            if (checkboxes.length === 0) {
                alert('Mohon maaf, Anda belum mencentang media manapun. Silakan centang kotak di sisi kiri atas gambar terlebih dahulu.');
                return;
            }

            const pesan = 'Apakah Anda benar-benar yakin ingin menghapus ' + checkboxes.length + ' media (foto/video) yang dipilih?\n\nPerhatian: Data yang dihapus tidak dapat dikembalikan lagi.';
            
            if (confirm(pesan)) {
                document.getElementById('btnSubmitBulk').click();
            }
        }
    </script>

</body>
</html>