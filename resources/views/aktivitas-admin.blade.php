<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivitas Sub-Admin - Kalikurmo Offroad</title>
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
                <h2 class="text-3xl md:text-4xl font-black text-primary tracking-tight uppercase">Aktivitas Sub-Admin</h2>
                <p class="text-base md:text-lg text-gray-600 mt-2">Log aktivitas dari semua Anak Admin di sistem.</p>
            </div>
            
            <div class="bg-white px-5 py-3 rounded-xl shadow-md border-l-4 border-accent font-bold text-gray-700 hidden md:flex items-center gap-3 text-lg shrink-0">
                <i class="fa-solid fa-list-check text-accent text-2xl"></i> Total: {{ count($aktivitas) }} Log
            </div>
        </header>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden w-full">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 font-black tracking-wider text-sm uppercase">
                            <th class="p-5 w-16 text-center">No</th>
                            <th class="p-5">Waktu</th>
                            <th class="p-5">Nama Sub-Admin</th>
                            <th class="p-5">Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($aktivitas as $index => $row)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="p-5 text-center font-bold text-gray-500">{{ $index + 1 }}</td>
                            <td class="p-5 text-gray-800 font-medium">
                                <i class="fa-regular fa-clock text-gray-400 mr-2"></i>
                                {{ \Carbon\Carbon::parse($row->created_at)->translatedFormat('d F Y, H:i') }}
                            </td>
                            <td class="p-5 text-primary font-bold">
                                <i class="fa-solid fa-user-shield text-gray-400 mr-2"></i>
                                {{ $row->nama_admin }}
                            </td>
                            <td class="p-5 text-gray-700 whitespace-normal">
                                {{ $row->aktivitas }}
                            </td>
                        </tr>
                        @endforeach

                        @if (count($aktivitas) == 0)
                        <tr>
                            <td colspan="4" class="p-10 text-center text-gray-400 italic">Belum ada aktivitas yang terekam.</td>
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
    </script>
</body>
</html>
