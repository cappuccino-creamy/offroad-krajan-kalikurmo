<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Wisatawan - Admin</title>
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
                <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">Data Akun Wisatawan</h2>
                <p class="text-base md:text-lg text-gray-600 mt-2">Kelola dan hapus daftar pengguna yang mendaftar di sistem.</p>
            </div>
            
            <div class="bg-white px-5 py-3 rounded-xl shadow-md border-l-4 border-accent font-bold text-gray-700 hidden md:flex items-center gap-3 text-lg shrink-0">
                <i class="fa-solid fa-users text-accent text-2xl"></i>
                Total: {{ $users->count() }} Orang
            </div>
        </header>

        @if($users->count() > 0)
            <form action="{{ url('/crud-users/bulk-delete') }}" method="POST" id="formBulkDelete">
                @csrf
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <label class="flex items-center gap-4 cursor-pointer text-xl font-bold text-gray-800 w-full md:w-auto p-2 hover:bg-gray-50 rounded-lg transition">
                        <input type="checkbox" id="selectAll" class="w-8 h-8 rounded border-gray-400 text-primary focus:ring-primary cursor-pointer">
                        Centang Semua Data
                    </label>
                    
                    <button type="button" onclick="konfirmasiHapusBanyak()" class="w-full md:w-auto bg-red-100 hover:bg-red-600 text-red-600 hover:text-white px-8 py-3.5 rounded-xl font-bold transition text-lg flex items-center justify-center gap-3 border border-red-200 shadow-sm">
                        <i class="fa-solid fa-trash-can text-xl"></i> Hapus Data Terpilih
                    </button>
                    <button type="submit" name="hapus_terpilih" id="btnSubmitBulk" class="hidden"></button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
                    
                    @foreach($users as $u)
                    <div class="bg-white rounded-3xl shadow-sm hover:shadow-md transition duration-300 border border-gray-200 p-6 text-center relative overflow-hidden">
                        
                        <label class="absolute top-4 left-4 z-20 cursor-pointer p-1">
                            <input type="checkbox" name="user_ids[]" value="{{ $u->id }}" class="checkbox-user w-7 h-7 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer shadow-sm">
                        </label>

                        <div class="absolute top-0 left-0 w-full h-20 bg-gray-50 border-b border-gray-100"></div>

                        <a href="{{ url('/crud-users/hapus/' . $u->id) }}" 
                        onclick="return confirm('Yakin ingin menghapus akun Bpk/Ibu {{ addslashes($u->nama_lengkap) }}?')" 
                        class="absolute top-4 right-4 text-red-400 hover:text-white hover:bg-red-500 bg-white shadow-sm border border-red-100 rounded-full w-10 h-10 flex items-center justify-center transition duration-300 z-10"
                        title="Hapus Satu Akun Ini">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>

                        <div class="relative w-24 h-24 mx-auto rounded-full bg-white border-4 border-white shadow-md mb-4 mt-2 overflow-hidden z-10">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($u->nama_lengkap) }}&background=2E5039&color=fff&size=128&bold=true" alt="Avatar" class="w-full h-full object-cover">
                        </div>

                        <h3 class="text-xl font-black text-gray-800 truncate px-2" title="{{ $u->nama_lengkap }}">
                            {{ $u->nama_lengkap }}
                        </h3>
                        
                        <div class="flex items-center justify-center gap-2 text-base text-gray-600 mb-5 mt-2 bg-gray-50 py-1 rounded-lg">
                            <i class="fa-solid fa-envelope text-accent"></i>
                            <span class="truncate px-2 font-medium">{{ $u->email }}</span>
                        </div>

                        <div class="inline-flex items-center bg-green-50 px-4 py-2 rounded-xl border border-green-100 text-sm text-green-700 font-bold w-full justify-center">
                            <i class="fa-regular fa-calendar-check mr-2"></i> 
                            Terdaftar: {{ date('d M Y', strtotime($u->created_at)) }}
                        </div>

                    </div>
                    @endforeach
                    
                </div>
            </form>
        @else
            <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-20 flex flex-col items-center justify-center text-center mt-6">
                <i class="fa-solid fa-user-xmark text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-600 mb-2">Belum Ada Wisatawan</h3>
                <p class="text-gray-400 text-lg">Belum ada akun wisatawan yang mendaftar di sistem Kalikurmo.</p>
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
                const checkboxes = document.querySelectorAll('.checkbox-user');
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        }

        function konfirmasiHapusBanyak() {
            const checkboxes = document.querySelectorAll('.checkbox-user:checked');
            
            if (checkboxes.length === 0) {
                alert('Mohon maaf, Anda belum mencentang data wisatawan manapun. Silakan centang kotak di sisi kiri atas kartu terlebih dahulu.');
                return;
            }

            const pesan = 'Apakah Anda benar-benar yakin ingin menghapus ' + checkboxes.length + ' akun wisatawan yang dipilih?\n\nPerhatian: Data yang dihapus tidak dapat dikembalikan lagi.';
            
            if (confirm(pesan)) {
                document.getElementById('btnSubmitBulk').click();
            }
        }
    </script>
</body>
</html>