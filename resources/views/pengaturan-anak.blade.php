<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Anak Admin - Kalikurmo Offroad</title>
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
        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 border-b border-gray-300 pb-5 gap-4">
            <div class="w-full flex items-center gap-3 md:hidden bg-white p-4 rounded-2xl shadow-sm border border-gray-200">
                <button onclick="toggleSidebar()" class="text-3xl text-primary focus:outline-none hover:text-secondary transition p-2 bg-gray-50 rounded-lg active:bg-gray-200">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 class="text-xl font-black tracking-tighter text-primary">ADMIN <span class="text-accent">PANEL</span></h1>
            </div>

            <div class="mt-2 md:mt-0">
                <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">Pengaturan Akun & SOP</h2>
                <p class="text-base md:text-lg text-gray-600 mt-2">Perbarui data diri, kata sandi, dan panduan SOP layanan.</p>
            </div>
            
            <div class="bg-white px-5 py-3 rounded-xl shadow-md border-l-4 border-blue-500 font-bold text-gray-700 hidden md:flex items-center gap-3 text-lg shrink-0">
                <i class="fa-solid fa-shield-halved text-primary text-2xl"></i> Sub-Admin
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

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 w-full">
            
            <div class="flex flex-col gap-8">
                
                <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-8 hover:shadow-lg transition duration-300">
                    <h3 class="text-2xl font-black text-primary mb-6 flex items-center gap-3 border-b pb-4">
                        <i class="fa-solid fa-user-pen text-3xl"></i> 1. Ubah Data Diri
                    </h3>
                    <form action="{{ url('/pengaturan-anak/profile') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ session('nama_lengkap') }}" required class="w-full bg-gray-50 border-2 border-gray-300 rounded-xl px-5 py-4 text-lg focus:border-primary outline-none transition font-bold text-gray-900 shadow-inner">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ session('email') }}" required class="w-full bg-gray-50 border-2 border-gray-300 rounded-xl px-5 py-4 text-lg focus:border-primary outline-none transition font-bold text-gray-900 shadow-inner">
                        </div>
                        <button type="submit" class="w-full bg-primary hover:bg-primary text-white font-bold py-3.5 px-6 rounded-xl transition shadow-md flex items-center justify-center gap-2 text-lg">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Profil
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-8 hover:shadow-lg transition duration-300">
                    <h3 class="text-2xl font-black text-gray-800 mb-6 flex items-center gap-3 border-b pb-4">
                        <i class="fa-solid fa-key text-3xl"></i> 2. Ganti Kata Sandi
                    </h3>
                    <form action="{{ url('/pengaturan-anak/password') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Kata Sandi Baru</label>
                            <div class="relative">
                                <input type="password" name="password_baru" id="pwdBaru" required placeholder="Minimal 6 karakter..."
                                       class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-gray-800 focus:ring-1 focus:ring-gray-800 transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Konfirmasi Kata Sandi Baru</label>
                            <div class="relative">
                                <input type="password" name="konfirmasi_password" id="pwdKonfirm" required placeholder="Ketik ulang sandi baru..."
                                       class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-gray-800 focus:ring-1 focus:ring-gray-800 transition">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-gray-800 hover:bg-black text-white font-bold py-3.5 px-6 rounded-xl transition shadow-md flex items-center justify-center gap-2 text-lg">
                            <i class="fa-solid fa-lock"></i> Perbarui Kata Sandi
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-8 hover:shadow-lg transition duration-300 h-fit">
                <h3 class="text-2xl font-black text-accent mb-6 flex items-center gap-3 border-b pb-4">
                    <i class="fa-solid fa-file-contract text-3xl"></i> 3. SOP Layanan (Hanya Baca)
                </h3>
                
                <div class="prose max-w-none text-gray-700 space-y-4 text-justify">
                    <p class="font-bold text-lg text-gray-800">Standar Operasional Prosedur (SOP) Anak Admin Kalikurmo Offroad:</p>
                    
                    <ul class="list-disc pl-5 space-y-3">
                        <li><b>Akses Terbatas:</b> Anak admin tidak memiliki hak untuk menambah, mengubah, atau menghapus data sesama admin maupun super admin.</li>
                        <li><b>Verifikasi Galeri:</b> Setiap foto/video yang diunggah wisatawan harus ditinjau. Hapus konten yang mengandung unsur SARA, pornografi, atau tidak relevan dengan wisata Kalikurmo.</li>
                        <li><b>Manajemen Reservasi:</b> Pastikan menghubungi nomor WhatsApp pemesan maksimal 1x24 jam setelah reservasi masuk untuk konfirmasi pembayaran dan titik kumpul.</li>
                        <li><b>Data Wisatawan:</b> Dilarang keras membagikan nomor WhatsApp atau email wisatawan kepada pihak ketiga mana pun tanpa izin dari Super Admin.</li>
                        <li><b>Aktivitas Tercatat:</b> Semua aktivitas Anda (menambah, mengubah, menghapus) di dalam sistem akan tercatat dalam log aktivitas yang dapat dipantau oleh Super Admin.</li>
                    </ul>
                    
                    <div class="mt-8 p-5 bg-orange-50 border border-orange-200 rounded-xl">
                        <p class="text-orange-800 italic font-medium"><i class="fa-solid fa-circle-info mr-2"></i> SOP ini ditetapkan oleh Super Admin. Jika ada hal yang kurang jelas, silakan hubungi Super Admin untuk arahan lebih lanjut.</p>
                    </div>
                </div>
            </div>
            
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
