<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

\DB::table('migrations')->where('migration', '2026_04_25_000000_add_comprehensive_job_fields')->delete();
echo "Deleted migration record.\n";
