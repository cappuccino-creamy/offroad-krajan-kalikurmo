<?php
$webphp = __DIR__ . '/routes/web.php';
$content = file_get_contents($webphp);

// 1. Insert helper function at the top
$helper = <<<EOD

if (!function_exists('log_aktivitas')) {
    function log_aktivitas(\$aksi) {
        if (session('role') === 'anak_admin') {
            Illuminate\Support\Facades\DB::table('aktivitas_admin')->insert([
                'user_id' => session('user_id'),
                'aktivitas' => \$aksi,
                'created_at' => now()
            ]);
        }
    }
}
EOD;

if (strpos($content, 'log_aktivitas') === false) {
    $content = preg_replace('/use Illuminate\\\\Support\\\\Str;/', "use Illuminate\Support\Str;\n" . $helper, $content);
}

// 2. Update login redirect logic
$old_login_logic = <<<EOD
        if (\$user->role === 'admin') {
            return redirect('/admin-dashboard');
        } else {
            return redirect('/');
        }
EOD;
$new_login_logic = <<<EOD
        if (\$user->role === 'admin') {
            return redirect('/admin-dashboard');
        } elseif (\$user->role === 'anak_admin') {
            return redirect('/anak-dashboard');
        } else {
            return redirect('/');
        }
EOD;
$content = str_replace($old_login_logic, $new_login_logic, $content);

// 3. Helper to replace role check in specific route blocks
function replace_role_check($prefix, $content) {
    // We look for:
    // Route::get('/PREFIX... function (...) {
    //     if (!session()->has('login') || session('role') !== 'admin') { return redirect('/login'); }
    // Or similar variations
    
    // Actually, just replace all occurrences of `session('role') !== 'admin'` that are NOT in admin-dashboard or pengaturan-admin
    return $content;
}

// Since there are multiple formats like:
// if (!session()->has('login') || session('role') !== 'admin') { return redirect('/login'); }
// AND
// if (!session()->has('login') || session('role') !== 'admin') {
//     return redirect('/login');
// }

// We will use a regex to replace it inside the allowed routes.
// To do this simply, we replace ALL occurrences in the whole file, and then REVERT the ones inside admin-dashboard and pengaturan-admin.

$content = str_replace("session('role') !== 'admin'", "!in_array(session('role'), ['admin', 'anak_admin'])", $content);

// Revert admin-dashboard
$content = preg_replace(
    "/(Route::get\('\/admin-dashboard'.*?if \(!session\(\)->has\('login'\) \|\| )!in_array\(session\('role'\), \['admin', 'anak_admin'\]\)(.*?return redirect\('\/login'\);.*?})/s",
    "$1session('role') !== 'admin'$2",
    $content
);

// Revert pengaturan-admin (GET, profile, password)
$content = preg_replace(
    "/(Route::get\('\/pengaturan-admin'.*?if \(!session\(\)->has\('login'\) \|\| )!in_array\(session\('role'\), \['admin', 'anak_admin'\]\)(.*?return redirect\('\/login'\);.*?})/s",
    "$1session('role') !== 'admin'$2",
    $content
);
$content = preg_replace(
    "/(Route::post\('\/pengaturan-admin\/profile'.*?if \(!session\(\)->has\('login'\) \|\| )!in_array\(session\('role'\), \['admin', 'anak_admin'\]\)(.*?return redirect\('\/login'\);.*?})/s",
    "$1session('role') !== 'admin'$2",
    $content
);
$content = preg_replace(
    "/(Route::post\('\/pengaturan-admin\/password'.*?if \(!session\(\)->has\('login'\) \|\| )!in_array\(session\('role'\), \['admin', 'anak_admin'\]\)(.*?return redirect\('\/login'\);.*?})/s",
    "$1session('role') !== 'admin'$2",
    $content
);


// 4. Inject log_aktivitas into CRUD POST routes.
// I will append the new routes at the end.

$new_routes = <<<'EOD'

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

    Illuminate\Support\Facades\DB::table('users')->insert([
        'nama_lengkap' => $request->input('nama_lengkap'),
        'email' => $request->input('email'),
        'password' => password_hash($request->input('password'), PASSWORD_BCRYPT, ['cost' => 12]),
        'role' => 'anak_admin',
        'created_at' => now()
    ]);
    return back()->with('success', 'Anak admin berhasil ditambahkan.');
});

Route::get('/data-admin/hapus/{id}', function ($id) {
    if (!session()->has('login') || session('role') !== 'admin') { return redirect('/login'); }
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

EOD;

if (strpos($content, '/data-admin') === false) {
    $content .= $new_routes;
}

// Let's add log_aktivitas to the existing CRUDs using regex.
// crud-users hapus
$content = str_replace(
    "User::where('id', \$id)->delete();",
    "User::where('id', \$id)->delete();\n        log_aktivitas('Menghapus data wisatawan dengan ID: ' . \$id);",
    $content
);
// tambah paket
$content = str_replace(
    "PaketWisata::create([",
    "log_aktivitas('Menambahkan paket wisata baru: ' . \$request->input('nama_paket'));\n        PaketWisata::create([",
    $content
);
// edit paket
$content = str_replace(
    "\$paket->save();",
    "\$paket->save();\n        log_aktivitas('Mengedit paket wisata dengan ID: ' . \$id_paket);",
    $content
);
// hapus paket
$content = str_replace(
    "\$paket->delete();",
    "\$paket->delete();\n        log_aktivitas('Menghapus paket wisata dengan ID: ' . \$id);",
    $content
);
// hapus reservasi
$content = str_replace(
    "\$reservasi->delete();",
    "\$reservasi->delete();\n        log_aktivitas('Menghapus reservasi dengan ID: ' . \$id);",
    $content
);
// terima reservasi (update status) - Wait, there's a switch status in crud-reservasi?
// Let's just log in crud-galeri terima
$content = str_replace(
    "DB::table('galeri')->where('id', \$id)->update(['status' => 'tayang']);",
    "DB::table('galeri')->where('id', \$id)->update(['status' => 'tayang']);\n    log_aktivitas('Menyetujui tayang media galeri dengan ID: ' . \$id);",
    $content
);
// crud-galeri hapus
$content = str_replace(
    "DB::table('galeri')->where('id', \$id)->delete();",
    "DB::table('galeri')->where('id', \$id)->delete();\n        log_aktivitas('Menghapus media galeri dengan ID: ' . \$id);",
    $content
);
// crud-galeri bulk-delete
$content = str_replace(
    "\$count = count(\$ids);",
    "\$count = count(\$ids);\n        log_aktivitas('Menghapus ' . \$count . ' media galeri secara massal');",
    $content
);
// crud-slider tambah
$content = str_replace(
    "return redirect('/crud-slider')->with('success', 'Gambar slider berhasil ditambahkan!');",
    "log_aktivitas('Menambahkan gambar slider baru untuk halaman: ' . \$request->input('halaman'));\n        return redirect('/crud-slider')->with('success', 'Gambar slider berhasil ditambahkan!');",
    $content
);
// crud-slider hapus
$content = str_replace(
    "DB::table('slide_foto')->where('id', \$id)->delete();",
    "DB::table('slide_foto')->where('id', \$id)->delete();\n        log_aktivitas('Menghapus gambar slider dengan ID: ' . \$id);",
    $content
);

file_put_contents($webphp, $content);
echo "Routes Updated successfully.\n";

?>
