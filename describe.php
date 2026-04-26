<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$cols = DB::select("DESCRIBE posts");
$found = [];
foreach($cols as $col) {
    if (in_array($col->Field, ['age_min', 'exam_date', 'admit_card_date', 'result_date'])) {
        $found[] = $col->Field;
    }
}
echo "FOUND COLUMNS: " . implode(', ', $found) . "\n";
