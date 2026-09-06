@php
    $role = session('role');
    $is_super = $role === 'admin';
    $bg_sidebar = $is_super ? 'bg-primary' : 'bg-primary';
@endphp
<aside id="sidebar" class="w-64 {{ $bg_sidebar }} text-white flex flex-col shadow-2xl fixed inset-y-0 left-0 z-50 transform -translate-x-full md:sticky md:top-0 md:translate-x-0 transition-transform duration-300 ease-in-out h-screen shrink-0">
    <div class="p-6 border-b border-white/10 flex justify-between items-center">
        <h1 class="text-xl font-black tracking-tighter text-center w-full">
            {{ $is_super ? 'SUPER ADMIN' : 'ANAK ADMIN' }}
        </h1>
        <button onclick="toggleSidebar()" class="md:hidden text-white hover:text-red-400 text-2xl focus:outline-none">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <nav class="flex-grow p-4 space-y-2 overflow-y-auto">
        <a href="{{ url($is_super ? '/admin-dashboard' : '/anak-dashboard') }}" class="flex items-center gap-3 p-3 {{ request()->is('admin-dashboard') || request()->is('anak-dashboard') ? 'bg-white/10 rounded-xl font-bold border-l-4 border-accent' : 'hover:bg-white/10 rounded-xl transition' }}">
            <i class="fa-solid fa-gauge text-lg w-6"></i> Dasbor Utama
        </a>
        
        @if($is_super)
        <a href="{{ url('/data-admin') }}" class="flex items-center gap-3 p-3 {{ request()->is('data-admin*') ? 'bg-white/10 rounded-xl font-bold border-l-4 border-accent' : 'hover:bg-white/10 rounded-xl transition' }}">
            <i class="fa-solid fa-user-shield text-lg w-6"></i> Data Anak Admin
        </a>
        @endif

        <a href="{{ url('/crud-users') }}" class="flex items-center gap-3 p-3 {{ request()->is('crud-users*') ? 'bg-white/10 rounded-xl font-bold border-l-4 border-accent' : 'hover:bg-white/10 rounded-xl transition' }}">
            <i class="fa-solid fa-users text-lg w-6"></i> Data Wisatawan
        </a>
        <a href="{{ url('/crud-paket') }}" class="flex items-center gap-3 p-3 {{ request()->is('crud-paket*') || request()->is('tambah-paket') || request()->is('edit-paket*') ? 'bg-white/10 rounded-xl font-bold border-l-4 border-accent' : 'hover:bg-white/10 rounded-xl transition' }}">
            <i class="fa-solid fa-map-location-dot text-lg w-6"></i> Paket Wisata
        </a>
        <a href="{{ url('/crud-reservasi') }}" class="flex items-center gap-3 p-3 {{ request()->is('crud-reservasi*') ? 'bg-white/10 rounded-xl font-bold border-l-4 border-accent' : 'hover:bg-white/10 rounded-xl transition' }}">
            <i class="fa-solid fa-calendar-check text-lg w-6"></i> Pesanan Masuk
        </a>
        <a href="{{ url('/crud-galeri') }}" class="flex items-center gap-3 p-3 {{ request()->is('crud-galeri*') ? 'bg-white/10 rounded-xl font-bold border-l-4 border-accent' : 'hover:bg-white/10 rounded-xl transition' }}">
            <i class="fa-solid fa-images text-lg w-6"></i> Review Galeri
        </a>
        <a href="{{ url('/crud-slider') }}" class="flex items-center gap-3 p-3 {{ request()->is('crud-slider*') ? 'bg-white/10 rounded-xl font-bold border-l-4 border-accent' : 'hover:bg-white/10 rounded-xl transition' }}">
            <i class="fa-solid fa-image text-lg w-6"></i> Slider Gambar
        </a>

        @if($is_super)
        <a href="{{ url('/aktivitas-admin') }}" class="flex items-center gap-3 p-3 {{ request()->is('aktivitas-admin*') ? 'bg-white/10 rounded-xl font-bold border-l-4 border-accent' : 'hover:bg-white/10 rounded-xl transition' }}">
            <i class="fa-solid fa-list-check text-lg w-6"></i> Aktivitas Sub-Admin
        </a>
        @endif

        <a href="{{ url($is_super ? '/pengaturan-admin' : '/pengaturan-anak') }}" class="flex items-center gap-3 p-3 {{ request()->is('pengaturan-admin*') || request()->is('pengaturan-anak*') ? 'bg-white/10 rounded-xl font-bold border-l-4 border-accent' : 'hover:bg-white/10 rounded-xl transition' }}">
            <i class="fa-solid fa-gear text-lg w-6"></i> Pengaturan
        </a>
    </nav>
    <div class="p-4 border-t border-white/10">
        <a href="{{ url('/logout') }}" class="flex items-center gap-3 p-3 text-red-300 hover:text-white transition font-bold" onclick="return confirm('Yakin ingin keluar?');">
            <i class="fa-solid fa-power-off text-lg w-6"></i> Keluar Aplikasi
        </a>
    </div>
</aside>