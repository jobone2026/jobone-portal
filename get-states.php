<?php

/**
 * Get all states from database with their IDs
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "==============================================\n";
echo "States in Database\n";
echo "==============================================\n\n";

$states = DB::table('states')->orderBy('name')->get();

echo "Total States: " . $states->count() . "\n\n";

echo "PHP Array Format:\n";
echo "==============================================\n";
echo "\$states = [\n";

foreach ($states as $state) {
    $name = strtolower($state->name);
    echo "    '{$name}' => {$state->id},\n";
}

echo "];\n\n";

echo "==============================================\n";
echo "Table Format:\n";
echo "==============================================\n";
printf("%-5s | %-30s | %-30s\n", "ID", "Name", "Slug");
echo str_repeat("-", 70) . "\n";

foreach ($states as $state) {
    printf("%-5s | %-30s | %-30s\n", $state->id, $state->name, $state->slug);
}

echo "\n";
