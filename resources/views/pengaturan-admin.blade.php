<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Admin - Kalikurmo Offroad</title>
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
                <p class="text-base md:text-lg text-gray-600 mt-2">Ubah nama, email, kata sandi Anda, serta baca panduan tugas admin.</p>
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

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-5 space-y-8">
                
                <section class="bg-white rounded-3xl shadow-md border border-gray-200 p-6 md:p-8">
                    <h3 class="text-2xl font-black text-primary mb-6 flex items-center gap-3 border-b pb-4">
                        <i class="fa-solid fa-user-pen text-3xl"></i> 1. Ubah Data Diri
                    </h3>
                    <form action="{{ url('/pengaturan-admin/profile') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-base font-bold text-gray-700 mb-2">Nama Lengkap Anda</label>
                            <input type="text" name="nama" value="{{ $admin_data->nama_lengkap ?? '' }}" required class="w-full bg-gray-50 border-2 border-gray-300 rounded-xl px-5 py-4 text-lg focus:border-primary outline-none transition font-bold text-gray-900 shadow-inner">
                        </div>
                        <div>
                            <label class="block text-base font-bold text-gray-700 mb-2">Alamat Email / Kontak</label>
                            <input type="email" name="email" value="{{ $admin_data->email ?? '' }}" required class="w-full bg-gray-50 border-2 border-gray-300 rounded-xl px-5 py-4 text-lg focus:border-primary outline-none transition font-bold text-gray-900 shadow-inner">
                        </div>
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menyimpan perubahan nama/email ini?')" class="w-full bg-primary hover:bg-secondary text-white font-bold py-4 rounded-xl transition text-lg flex items-center justify-center gap-2 border-b-4 border-green-900 active:border-b-0 active:mt-1">
                            <i class="fa-solid fa-floppy-disk"></i> SIMPAN PROFIL
                        </button>
                    </form>
                </section>

                <section class="bg-white rounded-3xl shadow-md border border-gray-200 p-6 md:p-8">
                    <h3 class="text-2xl font-black text-secondary mb-6 flex items-center gap-3 border-b pb-4">
                        <i class="fa-solid fa-key text-3xl"></i> 2. Ganti Kata Sandi
                    </h3>
                    <form action="{{ url('/pengaturan-admin/password') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-base font-bold text-gray-700 mb-2">Kata Sandi (Password) Baru</label>
                            <p class="text-sm text-gray-500 mb-3">Ketik kata sandi baru yang mudah Anda ingat, namun sulit ditebak orang lain.</p>
                            <input type="password" name="password_baru" placeholder="Ketik sandi baru di sini..." class="w-full bg-gray-50 border-2 border-gray-300 rounded-xl px-5 py-4 text-lg focus:border-secondary outline-none transition shadow-inner font-bold" required>
                        </div>
                        <button type="submit" onclick="return confirm('Peringatan: Jika Anda mengubah kata sandi, pastikan Anda mencatatnya. Lanjutkan?')" class="w-full bg-secondary hover:bg-primary text-white font-bold py-4 rounded-xl transition text-lg flex items-center justify-center gap-2 border-b-4 border-gray-800 active:border-b-0 active:mt-1">
                            <i class="fa-solid fa-lock"></i> GANTI KATA SANDI
                        </button>
                    </form>
                </section>
                
            </div>

            <div class="lg:col-span-7">
                <section class="bg-blue-50 rounded-3xl shadow-md border border-blue-200 p-6 md:p-10 h-full">
                    <h3 class="text-3xl font-black text-blue-900 mb-2 flex items-center gap-3">
                        <i class="fa-solid fa-clipboard-list text-accent"></i> SOP Administrator
                    </h3>
                    <p class="text-lg text-blue-800 mb-8 pb-4 border-b border-blue-200">
                        Standar Operasional Prosedur (SOP) harian yang wajib dipatuhi oleh Admin website Desa Wisata Kalikurmo.
                    </p>

                    <div class="space-y-6">
                        
                        <div class="flex gap-5 items-start bg-white p-5 rounded-2xl shadow-sm border border-blue-100">
                            <div class="w-14 h-14 shrink-0 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl font-black border-2 border-blue-300">
                                1
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 mb-1">Cek Pesanan Setiap Hari</h4>
                                <p class="text-base text-gray-600 leading-relaxed">
                                    Buka menu <b>Pesanan Masuk</b> minimal 2 kali sehari (Pagi dan Sore). Pastikan tidak ada reservasi wisatawan yang terlewat atau terlalu lama menunggu di status <i>"Menunggu"</i>.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-5 items-start bg-white p-5 rounded-2xl shadow-sm border border-blue-100">
                            <div class="w-14 h-14 shrink-0 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl font-black border-2 border-blue-300">
                                2
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 mb-1">Hubungi Sebelum "Selesai"</h4>
                                <p class="text-base text-gray-600 leading-relaxed">
                                    Sebelum mengklik tombol hijau <b>"Selesai"</b> pada halaman Pesanan, pastikan pihak pengelola sudah menghubungi nomor kontak pemesan untuk konfirmasi pembayaran dan jadwal kedatangan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-5 items-start bg-white p-5 rounded-2xl shadow-sm border border-blue-100">
                            <div class="w-14 h-14 shrink-0 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl font-black border-2 border-blue-300">
                                3
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 mb-1">Saring (Filter) Foto Galeri</h4>
                                <p class="text-base text-gray-600 leading-relaxed">
                                    Di menu <b>Review Galeri</b>, periksa baik-baik foto atau video yang diunggah pengunjung. Hanya klik <b>"Setujui Konten"</b> jika gambar tersebut sopan, pantas, dan terkait dengan aktivitas desa wisata. Hapus segera jika terdapat unsur negatif/spam.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-5 items-start bg-white p-5 rounded-2xl shadow-sm border border-blue-100">
                            <div class="w-14 h-14 shrink-0 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-2xl font-black border-2 border-red-300">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-red-700 mb-1">Jaga Kerahasiaan Akun</h4>
                                <p class="text-base text-gray-600 leading-relaxed">
                                    Dilarang keras membagikan alamat email dan kata sandi (password) akun ini kepada pihak luar. Pastikan selalu menekan tombol <b>Keluar Aplikasi</b> (Log Out) di kiri bawah jika membuka website ini di komputer umum/pinjaman.
                                </p>
                            </div>
                        </div>

                    </div>
                </section>
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