<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anak Admin - Kalikurmo Offroad</title>
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
                <h2 class="text-3xl md:text-4xl font-black text-primary tracking-tight uppercase">Data Anak Admin</h2>
                <p class="text-base md:text-lg text-gray-600 mt-2">Kelola akun Sub-Admin yang dapat membantu mengurus data website.</p>
            </div>
            
            <div class="bg-white px-5 py-3 rounded-xl shadow-md border-l-4 border-accent font-bold text-gray-700 hidden md:flex items-center gap-3 text-lg shrink-0">
                <i class="fa-solid fa-user-shield text-accent text-2xl"></i> Total: {{ count($data_admin) }} Akun
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

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200 mb-8 w-full">
            <h3 class="text-xl font-black text-primary mb-5"><i class="fa-solid fa-user-plus mr-2"></i> Tambah Akun Anak Admin</h3>
            <form action="{{ url('/data-admin/tambah') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @csrf
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required class="w-full border-gray-300 border rounded-xl p-3 focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Email</label>
                    <input type="email" name="email" required class="w-full border-gray-300 border rounded-xl p-3 focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Foto KTP</label>
                    <input type="file" name="ktp" accept="image/*" class="w-full border-gray-300 border rounded-xl p-2 focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-gray-50 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Kata Sandi</label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative w-full">
                            <input type="password" name="password" id="inputPassword" required class="w-full border-gray-300 border rounded-xl p-3 pr-10 focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i id="eyeIcon" class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <button type="submit" class="bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-xl transition shadow-sm whitespace-nowrap">
                            <i class="fa-solid fa-plus mr-2"></i> Tambah
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 font-black tracking-wider text-sm uppercase">
                            <th class="p-5 w-16 text-center">No</th>
                            <th class="p-5">Nama Lengkap</th>
                            <th class="p-5">Email</th>
                            <th class="p-5 text-center">Berkas KTP</th>
                            <th class="p-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($data_admin as $index => $row)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="p-5 text-center font-bold text-gray-500">{{ $index + 1 }}</td>
                            <td class="p-5 text-gray-800 font-bold">{{ $row->nama_lengkap }}</td>
                            <td class="p-5 text-gray-600">{{ $row->email }}</td>
                            <td class="p-5 text-center">
                                @if($row->ktp_url)
                                    <a href="{{ asset($row->ktp_url) }}" target="_blank" class="text-blue-500 hover:text-blue-700 underline font-bold"><i class="fa-solid fa-id-card mr-1"></i> Lihat KTP</a>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="p-5 text-center">
                                <a href="{{ url('/data-admin/hapus/'.$row->id) }}" onclick="return confirm('Yakin ingin menghapus anak admin ini?')" class="bg-red-50 text-red-500 hover:bg-red-600 hover:text-white border border-red-200 px-4 py-2 rounded-lg font-bold transition">
                                    <i class="fa-solid fa-trash-can mr-2"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @if (count($data_admin) == 0)
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-400 italic">Belum ada data anak admin.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
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

        function togglePassword() {
            const passwordInput = document.getElementById('inputPassword');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
