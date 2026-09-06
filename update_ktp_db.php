<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

DB::statement("ALTER TABLE users ADD COLUMN ktp_url VARCHAR(255) NULL");
echo "Column ktp_url added to users table.\n";
