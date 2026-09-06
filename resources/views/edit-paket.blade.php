<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Paket Wisata - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>tailwind.config = { theme: { extend: { colors: { primary: '#2E5039', secondary: '#6E4E32', accent: '#F5A623' } } } }</script>
</head>
<body class="bg-gray-100 flex min-h-screen font-sans overflow-x-hidden">

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/60 z-40 hidden transition-opacity duration-300" onclick="toggleSidebar()"></div>

    @include('layouts.sidebar')

    <main class="flex-grow p-5 md:p-10 overflow-y-auto min-w-0 w-full relative">
        <div class="max-w-4xl mx-auto w-full">
            
            <div class="w-full flex items-center gap-3 md:hidden bg-white p-4 rounded-2xl shadow-sm border border-gray-200 mb-4">
                <button onclick="toggleSidebar()" class="text-3xl text-primary focus:outline-none hover:text-secondary transition p-2 bg-gray-50 rounded-lg active:bg-gray-200">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 class="text-xl font-black tracking-tighter text-primary">ADMIN <span class="text-accent">PANEL</span></h1>
            </div>

            <header class="mb-8 flex items-start md:items-center gap-6 border-b border-gray-300 pb-5">
                <a href="{{ url('/crud-paket') }}" class="bg-white border-2 border-gray-300 px-6 py-3 rounded-xl text-base font-bold text-gray-700 hover:bg-gray-100 transition shadow-sm flex items-center gap-3 shrink-0">
                    <i class="fa-solid fa-arrow-left"></i> 
                </a>
                <div>
                    <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">Edit Paket Wisata</h2>
                    <p class="text-base md:text-lg text-gray-600 mt-2">Perbarui detail untuk paket <b>{{ $paket->nama_paket }}</b>.</p>
                </div>
            </header>

            <div class="bg-white rounded-3xl shadow-md border border-gray-200 p-6 md:p-10 w-full">
                <form action="{{ url('/edit-paket/' . $paket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        <label class="block text-lg font-black text-gray-800 mb-2">1. Nama Paket Wisata</label>
                        <input type="text" name="nama_paket" value="{{ $paket->nama_paket }}" required class="w-full bg-white border-2 border-gray-300 rounded-xl px-5 py-4 text-lg focus:border-primary outline-none transition font-bold text-gray-900 shadow-inner">
                    </div>

                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        <label class="block text-lg font-black text-gray-800 mb-2">2. Harga (Rupiah)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-bold text-lg">Rp</span>
                            </div>
                            <input type="number" name="harga" value="{{ $paket->harga }}" required class="w-full bg-white border-2 border-gray-300 rounded-xl pl-14 pr-5 py-4 text-lg focus:border-primary outline-none transition font-bold text-gray-900 shadow-inner">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <label class="block text-lg font-black text-gray-800 mb-2">3. Lama Kegiatan</label>
                            <input type="text" name="durasi" value="{{ $paket->durasi }}" required class="w-full bg-white border-2 border-gray-300 rounded-xl px-5 py-4 text-lg focus:border-primary outline-none transition font-bold text-gray-900 shadow-inner">
                        </div>
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <label class="block text-lg font-black text-gray-800 mb-2">4. Kapasitas & Fasilitas</label>
                            <input type="text" name="kapasitas" value="{{ $paket->kapasitas }}" required class="w-full bg-white border-2 border-gray-300 rounded-xl px-5 py-4 text-lg focus:border-primary outline-none transition font-bold text-gray-900 shadow-inner">
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        <label class="block text-lg font-black text-gray-800 mb-2">5. Ceritakan kelengkapan paket ini</label>
                        <textarea name="deskripsi" rows="5" required class="w-full bg-white border-2 border-gray-300 rounded-xl px-5 py-4 text-lg focus:border-primary outline-none transition text-gray-900 shadow-inner leading-relaxed">{{ $paket->deskripsi }}</textarea>
                    </div>

                    <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                        <label class="block text-lg font-black text-blue-900 mb-2">6. Upload Foto Paket Baru (Opsional)</label>
                        <div class="flex flex-col md:flex-row gap-6 items-center">
                            <div class="flex-shrink-0 relative group">
                                <img src="{{ asset($paket->gambar) }}" onerror="this.src='https://via.placeholder.com/150'" class="w-32 h-32 rounded-xl object-cover border-4 border-white shadow-md">
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-white text-xs font-bold">Foto Saat Ini</span>
                                </div>
                            </div>
                            
                            <div class="flex-grow w-full">
                                <input type="file" name="gambar" id="gambar-paket" accept="image/*" class="w-full bg-white border-2 border-blue-300 rounded-xl px-4 py-3 text-base focus:border-blue-500 outline-none transition font-medium text-gray-900 shadow-inner file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                <p class="text-sm text-gray-500 mt-2 font-medium">* Biarkan kosong jika tidak ingin mengganti foto.<br>* Format yang didukung: JPG, PNG, WEBP (Maks. 2 MB).</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-end">
                        <button type="submit" class="w-full md:w-auto bg-primary hover:bg-secondary text-white font-black py-4 px-10 rounded-2xl shadow-xl transition duration-300 flex items-center justify-center gap-3 text-xl border-b-4 border-green-900 active:border-b-0 active:mt-1">
                            <i class="fa-solid fa-floppy-disk text-2xl"></i> SIMPAN PERUBAHAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            document.getElementById('gambar-paket').addEventListener('change', function() {
                if(this.files[0] && this.files[0].size > 2 * 1024 * 1024) {
                    alert('Ukuran foto terlalu besar! Maksimal 2 MB.');
                    this.value = ''; 
                }
            });
        </script>
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