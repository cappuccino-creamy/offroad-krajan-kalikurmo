<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\PaketWisata;
use App\Models\Galeri;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash; 

if (!function_exists('log_aktivitas')) {
    function log_aktivitas($aksi) {
        if (session('role') === 'anak_admin') {
            DB::table('aktivitas_admin')->insert(['user_id' => session('user_id'), 'aktivitas' => $aksi, 'created_at' => now()]);
        }
    }
}

// page beranda

Route::get('/', function () {
    $slider_images = DB::table('slide_foto')->where('halaman', 'beranda')->pluck('gambar_url')->map(fn($url) => asset($url))->toArray();

    // Mengambil 4 postingan terbaru dr page galeri
    $galeri_beranda = DB::table('galeri')
                        ->join('users', 'galeri.user_id', '=', 'users.id')
                        ->select('galeri.*', 'users.nama_lengkap as nama_user') 
                        ->where('galeri.status', 'tayang')
                        ->orderBy('galeri.waktu_upload', 'desc')
                        ->take(4)
                        ->get();

    return view('beranda', compact('slider_images', 'galeri_beranda'));
});

// page paket
Route::get('/paket', function () {
    $slider_images = DB::table('slide_foto')->where('halaman', 'paket')->pluck('gambar_url')->toArray();

    $paket_wisata = PaketWisata::all();

    return view('paket', compact('slider_images', 'paket_wisata'));
});

// page detail paket
Route::get('/detail-paket', function (Request $request) {
    $id_paket = $request->query('id', 1);
    $detail_paket = PaketWisata::find($id_paket);

    if (!$detail_paket) {
        return redirect('/paket');
    }

    return view('detail-paket', compact('detail_paket'));
});

// page galeri
Route::get('/galeri', function (Illuminate\Http\Request $request) {
    $slider_images = DB::table('slide_foto')->where('halaman', 'galeri')->pluck('gambar_url')->toArray();

    $limit = 6;
    $page = $request->query('page', 1);
    $offset = ($page - 1) * $limit;

    $total_data = DB::table('galeri')->where('status', 'tayang')->count();
    $total_halaman = ceil($total_data / $limit);

    $galeri = DB::table('galeri')
                ->join('users', 'galeri.user_id', '=', 'users.id')
                ->select('galeri.*', 'users.nama_lengkap as nama_user')
                ->where('galeri.status', 'tayang')
                ->orderBy('galeri.waktu_upload', 'desc')
                ->skip($offset)
                ->take($limit)
                ->get();

    return view('galeri', compact('slider_images', 'galeri', 'page', 'total_halaman'));
});

Route::post('/galeri/delete', function (Request $request) {
    if (!session()->has('login')) {
        return redirect('/login');
    }

    $id_galeri = $request->input('delete_id');
    $item = DB::table('galeri')->where('id', $id_galeri)->first();
    
    if ($item) {
        if (file_exists(public_path($item->media_url))) {
            @unlink(public_path($item->media_url));
        } elseif (file_exists($item->media_url)) {
            @unlink($item->media_url);
        }
        
        DB::table('galeri')->where('id', $id_galeri)->delete();
    }
    
    return back();
});


// proses upload galeri
Route::post('/galeri', function (Illuminate\Http\Request $request) {
    if (!session()->has('login')) {
        return response("<script>alert('Silakan login terlebih dahulu untuk mengunggah cerita.'); window.location='" . url('/login') . "';</script>");
    }

    $validator = Validator::make($request->all(), [
        'file_media' => [
            'required',
            'file',
            'mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/webp,video/mp4,video/quicktime,video/ogg',
            'max:10240', 
        ],
        'caption' => 'required|string|max:500'
    ]);

    if ($validator->fails()) {
        return response("<script>alert('Gagal mengunggah! Format berkas tidak valid atau berbahaya.'); window.location='" . url('/galeri') . "';</script>");
    }

    if ($request->hasFile('file_media')) {
        $file = $request->file('file_media');
        $mime = $file->getMimeType();
        $ukuran_file = $file->getSize();
        $jenis_media = Str::startsWith($mime, 'video/') ? 'video' : 'foto';
        
        if ($jenis_media === 'foto' && $ukuran_file > (2 * 1024 * 1024)) {
            return response("<script>alert('Gagal mengunggah! Ukuran foto terlalu besar. Maksimal ukuran foto adalah 2 MB.'); window.location='" . url('/galeri') . "';</script>");
        }

        if ($jenis_media === 'video' && $ukuran_file > (10 * 1024 * 1024)) {
            return response("<script>alert('Gagal mengunggah! Ukuran video terlalu besar. Maksimal ukuran video adalah 10 MB.'); window.location='" . url('/galeri') . "';</script>");
        }
        
        $tujuan_upload = public_path('gambar/galeri');
        
        $nama_file_baru = time() . '_' . Str::random(12) . '.' . $file->extension();
        $file->move($tujuan_upload, $nama_file_baru);
        $media_url = 'gambar/galeri/' . $nama_file_baru;

        // simpan data postingan ke database
        $insert = DB::table('galeri')->insert([
            'user_id'      => session('user_id'),
            'media_url'    => $media_url,
            'jenis_media'  => $jenis_media,
            'caption'      => $request->input('caption'),
            'status'       => 'tayang',
            'waktu_upload' => now()
        ]);

        if ($insert) {
            return response("<script>alert('Cerita petualanganmu berhasil diunggah dan sudah tayang di web!'); window.location='" . url('/galeri') . "';</script>");
        }
    }

    return response("<script>alert('Gagal mengunggah file. Silakan coba lagi.'); window.location='" . url('/galeri') . "';</script>");
});

// page tentang kami
Route::get('/tentang-kami', function () {
    $slider_images = DB::table('slide_foto')->where('halaman', 'tentang-kami')->pluck('gambar_url')->toArray();

    return view('tentang-kami', compact('slider_images'));
});


// profile
Route::get('/profile', function () {
    // Mengecek apakah user sudah login melalui session
    if (!session()->has('login') || session('login') !== true) {
        return redirect('/login');
    }

    $user_id = session('user_id');
    $user = DB::table('users')->where('id', $user_id)->first();
    $galeri = DB::table('galeri')->where('user_id', $user_id)->orderBy('waktu_upload', 'desc')->get();
    $reservasi = DB::table('reservasi')->where('user_id', $user_id)->orderBy('waktu_pesan', 'desc')->get();

    return view('profile', compact('user', 'galeri', 'reservasi'));
});

// logout
Route::get('/logout', function () {
    // Menghapus semua session dan mengembalikan ke halaman beranda
    session()->flush();
    return redirect('/');
});

// login
Route::get('/login', function () {
    if (session()->has('login')) {
        return session('role') === 'admin' ? redirect('/admin-dashboard') : redirect('/profile');
    }

    $cek_admin = DB::table('users')->where('email', 'admin_kali@gmail.com')->first();
    if (!$cek_admin) {
        DB::table('users')->insert([
            'nama_lengkap' => 'Admin Utama',
            'email' => 'admin_kali@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);
    }

    return view('login');
});

Route::post('/login', function (Request $request) {
    $user = DB::table('users')->where('email', $request->email)->first();
    
    if ($user && Hash::check($request->password, $user->password)) {
        session([
            'login' => true,
            'user_id' => $user->id,
            'nama' => $user->nama_lengkap, // Bawaan untuk Super Admin / profile biasa
            'nama_lengkap' => $user->nama_lengkap, // TAHAP INI YANG DITAMBAHKAN UNTUK ANAK ADMIN
            'email' => $user->email, // DITAMBAHKAN JUGA BIAR FORM PENGATURAN NGGAK KOSONG
            'role' => $user->role
        ]);

        if ($user->role === 'admin') {
            return redirect('/admin-dashboard');
        } elseif ($user->role === 'anak_admin') {
            return redirect('/anak-dashboard');
        } else {
            return redirect('/profile');
        }
    }

    return back()->with('error', 'Email atau Password salah!');
});

// lupa password
Route::get('/lupa-password', function () {
    if (session()->has('login')) {
        return session('role') === 'admin' ? redirect('/admin-dashboard') : redirect('/profile');
    }
    return view('lupa-password');
});

Route::post('/lupa-password', function (Request $request) {
    if ($request->action === 'cek_email') {
        $user = DB::table('users')->where('email', $request->email)->first();
        if ($user) {
            return back()->with(['step' => 2, 'email_verified' => $request->email]);
        }
        return back()->with('error', 'Email tidak ditemukan di sistem kami.');
    }

    // ganti password
    if ($request->action === 'ganti_password') {
        $email = $request->email;
        $pass1 = $request->pass1;
        $pass2 = $request->pass2;

        if (strlen($pass1) < 6) {
            return back()->with(['step' => 2, 'email_verified' => $email, 'error' => 'Password minimal harus 6 karakter!']);
        } 
        
        if ($pass1 === $pass2) {
            DB::table('users')->where('email', $email)->update([
                'password' => Hash::make($pass1)
            ]);
            return back()->with('success', 'Password berhasil diubah! Silakan login.');
        } 
        
        return back()->with(['step' => 2, 'email_verified' => $email, 'error' => 'Password baru tidak cocok!']);
    }
});

// dashboard admin
Route::get('/admin-dashboard', function () {
    // Proteksi: Cek login dan role
    if (!session()->has('login') || session('role') !== 'admin') {
        return redirect('/login');
    }

    $total_users = DB::table('users')->where('role', 'wisatawan')->count();
    $total_paket = DB::table('paket_wisata')->count();
    $total_rsv = DB::table('reservasi')->count();
    $rsv_pending = DB::table('reservasi')->whereNotIn('status', ['Selesai', 'Dibatalkan'])->count();
    $total_media = DB::table('galeri')->count();
    $media_pending = DB::table('galeri')->where('status', 'pending')->count();
    $res_paket = DB::table('reservasi')
                    ->select('nama_paket', DB::raw('COUNT(*) as jumlah'))
                    ->groupBy('nama_paket')
                    ->get();

    $label_paket = [];
    $data_paket = [];

    foreach ($res_paket as $p) {
        $label_paket[] = $p->nama_paket;
        $data_paket[] = $p->jumlah;
    }

    if (empty($label_paket)) {
        $label_paket = ['Belum Ada Pesanan'];
        $data_paket = [0];
    }

    return view('admin-dashboard', compact(
        'total_users', 'total_paket', 'total_rsv', 'rsv_pending', 
        'total_media', 'media_pending', 'label_paket', 'data_paket'
    ));
});

// menghubungkan ke API WhatsApp
Route::post('/proses-pesanan', function (Request $request) {
    // 1. Proteksi: Cek apakah user sudah login
    if (!session()->has('login')) {
        return response("<script>alert('Silakan login terlebih dahulu untuk melakukan reservasi.'); window.location='" . url('/login') . "';</script>");
    }

    $user_id = session('user_id');
    $id_paket = (int)$request->input('id_paket');
    $nama = $request->input('nama');
    $whatsapp = $request->input('whatsapp');
    $tanggal = $request->input('tanggal');
    $jumlah_orang = (int)$request->input('jumlah_orang');
    $catatan = $request->input('catatan');

    $paket = PaketWisata::find($id_paket);
    if (!$paket) {
        return response("<script>alert('Paket wisata tidak ditemukan.'); window.history.back();</script>");
    }

    $harga_satuan = $paket->harga; 
    $nama_paket = $paket->nama_paket;
    $total_biaya = $harga_satuan * $jumlah_orang;
    $kode_reservasi = 'RSV-' . date('Ymd') . rand(100, 999);
    $insert = DB::table('reservasi')->insert([
        'kode_reservasi'   => $kode_reservasi,
        'user_id'          => $user_id,
        'id_paket'         => $id_paket,
        'nama_paket'       => $nama_paket,
        'nama_pemesan'     => $nama,
        'whatsapp'         => $whatsapp,
        'tanggal_kunjungan'=> $tanggal,
        'jumlah_orang'     => $jumlah_orang,
        'harga_satuan'     => $harga_satuan,
        'total_biaya'      => $total_biaya,
        'catatan'          => $catatan,
        'status'           => 'Menunggu Konfirmasi Admin',
        'waktu_pesan'      => now() 
    ]);

    if ($insert) {
        $nomor_wa = "6289502506737"; // Nomor kontak WhatsApp
        $pesan_wa = "Halo Admin Kalikurmo Offroad, saya ingin mengonfirmasi reservasi saya.\n\n";
        $pesan_wa .= "*Kode Booking:* " . $kode_reservasi . "\n";
        $pesan_wa .= "*Nama:* " . $nama . "\n";
        $pesan_wa .= "*Paket:* " . $nama_paket . "\n";
        $pesan_wa .= "*Tanggal:* " . $tanggal . "\n";
        $pesan_wa .= "*Jumlah Orang:* " . $jumlah_orang . "\n";
        $pesan_wa .= "*Total Estimasi:* Rp" . number_format($total_biaya, 0, ',', '.') . "\n";
        $pesan_wa .= "*Catatan:* " . ($catatan ?: '-') . "\n\n";
        $pesan_wa .= "Mohon konfirmasinya. Terima kasih!";
        $url_wa = "https://wa.me/" . $nomor_wa . "?text=" . urlencode($pesan_wa);

        return response("<script>
            alert('Reservasi berhasil disimpan di Dasbor! Anda akan diarahkan ke WhatsApp untuk konfirmasi.');
            window.location='" . $url_wa . "';
        </script>");
    } else {
        return response("<script>alert('Gagal memproses pesanan. Silakan coba lagi.'); window.history.back();</script>");
    }
});

// crud galeri
Route::get('/crud-galeri', function () {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) {
        return redirect('/login');
    }

    $galeri = DB::table('galeri')
                ->join('users', 'galeri.user_id', '=', 'users.id')
                ->select('galeri.*', 'users.nama_lengkap')
                ->orderBy('galeri.status', 'asc') // Menampilkan yang 'pending' duluan
                ->orderBy('galeri.waktu_upload', 'desc')
                ->get();

    return view('crud-galeri', compact('galeri'));
});

Route::get('/crud-galeri/terima/{id}', function ($id) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }

    DB::table('galeri')->where('id', $id)->update(['status' => 'tayang']);
    
    return redirect('/crud-galeri');
});

// Hapus postingan galeri
Route::get('/crud-galeri/hapus/{id}', function ($id) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }

    $item = DB::table('galeri')->where('id', $id)->first();
    
    if ($item) {
        if (file_exists(public_path($item->media_url))) {
            @unlink(public_path($item->media_url));
        } elseif (file_exists($item->media_url)) {
            @unlink($item->media_url);
        }
        
        log_aktivitas("Menghapus galeri dengan ID: $id");
        DB::table('galeri')->where('id', $id)->delete();
    }

    return response("<script>alert('Satu konten media berhasil dihapus!'); window.location='" . url('/crud-galeri') . "';</script>");
});

// Hapus semua postingan galeri
Route::post('/crud-galeri/bulk-delete', function (Request $request) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }

    $ids = $request->input('galeri_ids');

    if (!empty($ids) && is_array($ids)) {
        $items = DB::table('galeri')->whereIn('id', $ids)->get();
        
        foreach ($items as $item) {
            if (file_exists(public_path($item->media_url))) {
                @unlink(public_path($item->media_url));
            } elseif (file_exists($item->media_url)) {
                @unlink($item->media_url);
            }
        }
        
        log_aktivitas("Menghapus massal galeri");
        DB::table('galeri')->whereIn('id', $ids)->delete();
        $count = count($ids);
        
        return response("<script>alert('" . $count . " konten media berhasil dihapus sekaligus!'); window.location='" . url('/crud-galeri') . "';</script>");
    }

    return response("<script>alert('Gagal menghapus media. Silakan coba lagi.'); window.location='" . url('/crud-galeri') . "';</script>");
});

// crud paket
Route::get('/crud-paket', function () {
    // Proteksi admin
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) {
        return redirect('/login');
    }

    $paket_wisata = DB::table('paket_wisata')->orderBy('id', 'asc')->get();

    return view('crud-paket', compact('paket_wisata'));
});

// Hapus satu"
Route::get('/crud-paket/hapus/{id}', function ($id) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }

    $item = DB::table('paket_wisata')->where('id', $id)->first();
    
    if ($item) {
        // Hapus file gambar fisik jika ada
        if (file_exists(public_path($item->gambar))) {
            @unlink(public_path($item->gambar));
        } elseif (file_exists($item->gambar)) {
            @unlink($item->gambar);
        }
        
        log_aktivitas("Menghapus paket wisata dengan ID: $id");
        DB::table('paket_wisata')->where('id', $id)->delete();
    }

    return response("<script>alert('Satu paket wisata berhasil dihapus!'); window.location='" . url('/crud-paket') . "';</script>");
});

// Hapus semua
Route::post('/crud-paket/bulk-delete', function (Request $request) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }

    $ids = $request->input('paket_ids');

    if (!empty($ids) && is_array($ids)) {
        $items = DB::table('paket_wisata')->whereIn('id', $ids)->get();
        
        foreach ($items as $item) {
            if (file_exists(public_path($item->gambar))) {
                @unlink(public_path($item->gambar));
            } elseif (file_exists($item->gambar)) {
                @unlink($item->gambar);
            }
        }
        
        log_aktivitas("Menghapus massal paket wisata");
        DB::table('paket_wisata')->whereIn('id', $ids)->delete();
        $count = count($ids);
        
        return response("<script>alert('" . $count . " paket wisata berhasil dihapus sekaligus!'); window.location='" . url('/crud-paket') . "';</script>");
    }

    return response("<script>alert('Gagal menghapus data paket. Silakan coba lagi.'); window.location='" . url('/crud-paket') . "';</script>");
});

// crud reservasi
Route::get('/crud-reservasi', function () {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) {
        return redirect('/login');
    }

    $reservasi = DB::table('reservasi')
        ->join('users', 'reservasi.user_id', '=', 'users.id')
        ->select('reservasi.*', 'users.nama_lengkap')
        ->orderBy('reservasi.waktu_pesan', 'desc')
        ->get();

    return view('crud-reservasi', compact('reservasi'));
});

Route::get('/crud-reservasi/status/{id}/{status}', function ($id, $status) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }

    DB::table('reservasi')->where('id', $id)->update(['status' => $status]);
    
    return redirect('/crud-reservasi');
});

// Hapus satu"
Route::get('/crud-reservasi/hapus/{id}', function ($id) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }

    log_aktivitas("Menghapus reservasi dengan ID: $id");
    DB::table('reservasi')->where('id', $id)->delete();
    
    return response("<script>alert('Satu data reservasi berhasil dihapus permanen.'); window.location='" . url('/crud-reservasi') . "';</script>");
});

// Hapus semua
Route::post('/crud-reservasi/bulk-delete', function (Request $request) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }

    $ids = $request->input('reservasi_ids');

    if (!empty($ids) && is_array($ids)) {
        log_aktivitas("Menghapus massal reservasi");
        DB::table('reservasi')->whereIn('id', $ids)->delete();
        $count = count($ids);
        
        return response("<script>alert('" . $count . " data reservasi berhasil dihapus sekaligus!'); window.location='" . url('/crud-reservasi') . "';</script>");
    }

    return response("<script>alert('Gagal menghapus data. Silakan coba lagi.'); window.location='" . url('/crud-reservasi') . "';</script>");
});

// crud user
Route::get('/crud-users', function () {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) {
        return redirect('/login');
    }

    $users = DB::table('users')
        ->where('role', 'wisatawan')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('crud-users', compact('users'));
});

// Hapus satu"
Route::get('/crud-users/hapus/{id}', function ($id) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { 
        return redirect('/login'); 
    }

    log_aktivitas("Menghapus user dengan ID: $id");
    DB::table('users')->where('id', $id)->delete();
    
    return response("<script>alert('Satu akun wisatawan berhasil dihapus.'); window.location='" . url('/crud-users') . "';</script>");
});

// Hapus semua
Route::post('/crud-users/bulk-delete', function (Request $request) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { 
        return redirect('/login'); 
    }

    $ids = $request->input('user_ids');

    if (!empty($ids) && is_array($ids)) {
        log_aktivitas("Menghapus massal user");
        DB::table('users')->whereIn('id', $ids)->delete();
        $count = count($ids);
        
        return response("<script>alert('" . $count . " akun wisatawan berhasil dihapus sekaligus!'); window.location='" . url('/crud-users') . "';</script>");
    }

    return response("<script>alert('Gagal menghapus data. Silakan coba lagi.'); window.location='" . url('/crud-users') . "';</script>");
});

// pengaturan admin
Route::get('/pengaturan-admin', function () {
    if (!session()->has('login') || session('role') !== 'admin') {
        return redirect('/login');
    }

    $user_id = session('user_id');
    $admin_data = DB::table('users')->where('id', $user_id)->first();

    return view('pengaturan-admin', compact('admin_data'));
});

// update profile admin
Route::post('/pengaturan-admin/profile', function (Request $request) {
    if (!session()->has('login') || session('role') !== 'admin') { return redirect('/login'); }

    $user_id = session('user_id');
    $nama = $request->input('nama');
    $email = $request->input('email');

    $update = DB::table('users')->where('id', $user_id)->update([
        'nama_lengkap' => $nama,
        'email' => $email
    ]);

    if ($update !== false) {
        session(['nama' => $nama]); 
        return back()->with('success', 'Data profil Anda berhasil diperbarui!');
    }

    return back()->with('error', 'Gagal memperbarui profil. Silakan coba lagi.');
});

// update password admin
Route::post('/pengaturan-admin/password', function (Request $request) {
    if (!session()->has('login') || session('role') !== 'admin') { return redirect('/login'); }

    $user_id = session('user_id');
    $pw_baru = Hash::make($request->input('password_baru'));

    $update = DB::table('users')->where('id', $user_id)->update([
        'password' => $pw_baru
    ]);

    if ($update !== false) {
        return back()->with('success', 'Kata sandi (password) Anda berhasil diganti!');
    }

    return back()->with('error', 'Gagal mengganti kata sandi. Silakan coba lagi.');
});


// edit paket wisata
Route::get('/edit-paket/{id}', function ($id) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }
    
    $paket = DB::table('paket_wisata')->where('id', $id)->first();
    if (!$paket) return redirect('/crud-paket');

    return view('edit-paket', compact('paket'));
});

// update data
Route::post('/edit-paket/{id}', function (Request $request, $id) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }

    $paket = DB::table('paket_wisata')->where('id', $id)->first();
    if (!$paket) {
        return back()->with('error', 'Data paket tidak ditemukan.');
    }

    $data_update = [
        'nama_paket' => $request->input('nama_paket'),
        'harga'      => $request->input('harga'),
        'durasi'     => $request->input('durasi'),
        'kapasitas'  => $request->input('kapasitas'),
        'deskripsi'  => $request->input('deskripsi'),
    ];

    if ($request->hasFile('gambar')) {
        $validator = Validator::make($request->all(), [
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Gagal: File harus berupa gambar dan berukuran maksimal 2 MB.');
        }

        $file = $request->file('gambar');
        $nama_file_baru = time() . '_' . Str::random(10) . '.' . $file->extension();
        $tujuan_upload = public_path('gambar/paket'); 
        $file->move($tujuan_upload, $nama_file_baru);
        
        if (file_exists(public_path($paket->gambar)) && $paket->gambar != '') {
            @unlink(public_path($paket->gambar));
        }

        $data_update['gambar'] = 'gambar/paket/' . $nama_file_baru;
    }

    log_aktivitas("Mengedit paket wisata dengan ID: $id");
    $update = DB::table('paket_wisata')->where('id', $id)->update($data_update);

    if ($update !== false) {
        return redirect('/crud-paket')->with('success', 'Data paket berhasil diperbarui!');
    }
    return back()->with('error', 'Gagal memperbarui data paket.');
});

Route::get('/tambah-paket', function () {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }
    return view('tambah-paket');
});

Route::post('/tambah-paket', function (Request $request) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }

    $validator = Validator::make($request->all(), [
        'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
    ]);

    if ($validator->fails()) {
        return back()->with('error', 'Gagal: File foto wajib diisi dan ukurannya maksimal 2 MB!');
    }

    // upload gambar paket wisata
    $media_url = '';
    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');
        $nama_file_baru = time() . '_' . Str::random(10) . '.' . $file->extension();
        $tujuan_upload = public_path('gambar/paket'); 
        $file->move($tujuan_upload, $nama_file_baru);
        $media_url = 'gambar/paket/' . $nama_file_baru;
    }

    log_aktivitas("Menambahkan paket wisata baru");
    $insert = DB::table('paket_wisata')->insert([
        'nama_paket' => $request->input('nama_paket'),
        'harga'      => $request->input('harga'),
        'durasi'     => $request->input('durasi'),
        'kapasitas'  => $request->input('kapasitas'),
        'deskripsi'  => $request->input('deskripsi'),
        'gambar'     => $media_url, 
    ]);

    if ($insert) {
        return redirect('/crud-paket')->with('success', 'Paket wisata baru berhasil ditambahkan!');
    }
    
    return back()->with('error', 'Gagal menyimpan data. Silakan coba lagi.');
});


Route::get('/register', function () {
    if (session()->has('login')) {
        return redirect('/profile');
    }
    return view('register');
});

Route::post('/register', function (Request $request) {
    if (session()->has('login')) {
        return redirect('/profile');
    }

    $nama = $request->input('nama');
    $email = $request->input('email');
    $raw_password = $request->input('password');

    if (strlen($raw_password) < 6) {
        return back()->with('error', 'Password minimal harus 6 karakter!')->withInput();
    }

    $userExists = DB::table('users')->where('email', $email)->exists();

    if ($userExists) {
        return back()->with('error', 'Email sudah terdaftar!')->withInput();
    }

    $password = Hash::make($raw_password);
    
    DB::table('users')->insert([
        'nama_lengkap' => $nama,
        'email' => $email,
        'password' => $password,
        'role' => 'wisatawan' 
    ]);

    return response("<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='" . url('/login') . "';</script>");
});

// crud slider
Route::get('/crud-slider', function () {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) {
        return redirect('/login');
    }

    $slide_foto = DB::table('slide_foto')->orderBy('halaman')->get();
    return view('crud-slider', compact('slide_foto'));
});

Route::post('/crud-slider', function (Request $request) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }

    $validator = Validator::make($request->all(), [
        'halaman' => 'required',
        'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
    ]);

    if ($validator->fails()) {
        return back()->with('error', 'Gagal: File foto wajib diisi dan ukurannya maksimal 2 MB!');
    }

    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');
        $nama_file_baru = time() . '_' . Str::random(10) . '.' . $file->extension();
        $tujuan_upload = public_path('gambar/slider'); 
        $file->move($tujuan_upload, $nama_file_baru);
        
        log_aktivitas("Menambahkan gambar slider baru");
        DB::table('slide_foto')->insert([
            'halaman' => $request->input('halaman'),
            'gambar_url' => 'gambar/slider/' . $nama_file_baru
        ]);

        return redirect('/crud-slider')->with('success', 'Gambar slider berhasil ditambahkan!');
    }
    
    return back()->with('error', 'Gagal mengupload gambar.');
});

Route::get('/crud-slider/hapus/{id}', function ($id) {
    if (!session()->has('login') || !in_array(session('role'), ['admin', 'anak_admin'])) { return redirect('/login'); }

    $item = DB::table('slide_foto')->where('id', $id)->first();
    if ($item) {
        if (file_exists(public_path($item->gambar_url))) {
            @unlink(public_path($item->gambar_url));
        }
        log_aktivitas("Menghapus gambar slider dengan ID: $id");
        DB::table('slide_foto')->where('id', $id)->delete();
    }
    return redirect('/crud-slider')->with('success', 'Satu gambar slider berhasil dihapus!');
});

// ====================================================
// ROUTES UNTUK SUPER ADMIN (DATA ANAK ADMIN & AKTIVITAS)
// ====================================================

Route::get('/data-admin', function () {
    if (!session()->has('login') || session('role') !== 'admin') { return redirect('/login'); }
    $data_admin = Illuminate\Support\Facades\DB::table('users')->where('role', 'anak_admin')->get();
    return view('data-admin', compact('data_admin'));
});

Route::post('/data-admin/tambah', function (Illuminate\Http\Request $request) {
    if (!session()->has('login') || session('role') !== 'admin') { return redirect('/login'); }
    
    $exists = Illuminate\Support\Facades\DB::table('users')->where('email', $request->input('email'))->exists();
    if ($exists) {
        return back()->with('error', 'Email sudah terdaftar!');
    }

    $ktp_url = null;
    if ($request->hasFile('ktp')) {
        $file = $request->file('ktp');
        $nama_file = time() . '_' . Illuminate\Support\Str::random(10) . '.' . $file->extension();
        $tujuan = public_path('gambar/ktp');
        $file->move($tujuan, $nama_file);
        $ktp_url = 'gambar/ktp/' . $nama_file;
    }

    Illuminate\Support\Facades\DB::table('users')->insert([
        'nama_lengkap' => $request->input('nama_lengkap'),
        'email' => $request->input('email'),
        'password' => password_hash($request->input('password'), PASSWORD_BCRYPT, ['cost' => 12]),
        'role' => 'anak_admin',
        'ktp_url' => $ktp_url,
        'created_at' => now()
    ]);
    return back()->with('success', 'Anak admin berhasil ditambahkan.');
});

Route::get('/data-admin/hapus/{id}', function ($id) {
    if (!session()->has('login') || session('role') !== 'admin') { return redirect('/login'); }
    $user = Illuminate\Support\Facades\DB::table('users')->where('id', $id)->first();
    if ($user && $user->ktp_url && file_exists(public_path($user->ktp_url))) {
        @unlink(public_path($user->ktp_url));
    }
    Illuminate\Support\Facades\DB::table('users')->where('id', $id)->delete();
    return back()->with('success', 'Anak admin berhasil dihapus.');
});

Route::get('/aktivitas-admin', function () {
    if (!session()->has('login') || session('role') !== 'admin') { return redirect('/login'); }
    $aktivitas = Illuminate\Support\Facades\DB::table('aktivitas_admin')
        ->join('users', 'aktivitas_admin.user_id', '=', 'users.id')
        ->select('aktivitas_admin.*', 'users.nama_lengkap as nama_admin')
        ->orderBy('aktivitas_admin.created_at', 'desc')
        ->get();
    return view('aktivitas-admin', compact('aktivitas'));
});

// ====================================================
// ROUTES UNTUK ANAK ADMIN (DASHBOARD & PENGATURAN)
// ====================================================

Route::get('/anak-dashboard', function () {
    if (!session()->has('login') || session('role') !== 'anak_admin') { return redirect('/login'); }
    return view('anak-dashboard');
});

Route::get('/pengaturan-anak', function () {
    if (!session()->has('login') || session('role') !== 'anak_admin') { return redirect('/login'); }
    return view('pengaturan-anak');
});

Route::post('/pengaturan-anak/profile', function (Illuminate\Http\Request $request) {
    if (!session()->has('login') || session('role') !== 'anak_admin') { return redirect('/login'); }
    
    $user_id = session('user_id');
    Illuminate\Support\Facades\DB::table('users')->where('id', $user_id)->update([
        'nama_lengkap' => $request->input('nama_lengkap'),
        'email' => $request->input('email')
    ]);
    
    session(['nama_lengkap' => $request->input('nama_lengkap'), 'email' => $request->input('email')]);
    log_aktivitas("Mengubah data profil diri");
    return back()->with('success', 'Data profil berhasil diperbarui.');
});

Route::post('/pengaturan-anak/password', function (Illuminate\Http\Request $request) {
    if (!session()->has('login') || session('role') !== 'anak_admin') { return redirect('/login'); }
    
    if (strlen($request->input('password_baru')) < 6) {
        return back()->with('error', 'Kata sandi minimal 6 karakter.');
    }
    if ($request->input('password_baru') !== $request->input('konfirmasi_password')) {
        return back()->with('error', 'Konfirmasi kata sandi tidak cocok.');
    }

    Illuminate\Support\Facades\DB::table('users')->where('id', session('user_id'))->update([
        'password' => password_hash($request->input('password_baru'), PASSWORD_BCRYPT, ['cost' => 12])
    ]);
    
    log_aktivitas("Mengganti kata sandi");
    return back()->with('success', 'Kata sandi berhasil diperbarui.');
});