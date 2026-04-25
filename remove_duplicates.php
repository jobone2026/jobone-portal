<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Finding duplicate posts...\n";

$duplicates = DB::table('posts')
    ->select('title', DB::raw('COUNT(*) as count'), DB::raw('GROUP_CONCAT(id) as ids'))
    ->groupBy('title')
    ->having('count', '>', 1)
    ->orderBy('count', 'DESC')
    ->limit(50)
    ->get();

if ($duplicates->isEmpty()) {
    echo "No duplicate posts found!\n";
    exit(0);
}

echo "Found " . count($duplicates) . " titles with duplicates:\n\n";

$totalDuplicates = 0;
$idsToDelete = [];

foreach ($duplicates as $dup) {
    $ids = explode(',', $dup->ids);
    $count = count($ids);
    
    // Keep the first one (oldest), delete the rest
    $keepId = array_shift($ids);
    $deleteIds = $ids;
    
    $totalDuplicates += count($deleteIds);
    $idsToDelete = array_merge($idsToDelete, $deleteIds);
    
    echo "Title: " . substr($dup->title, 0, 60) . "...\n";
    echo "  Total: $count, Keep ID: $keepId, Delete IDs: " . implode(', ', $deleteIds) . "\n\n";
}

echo "Total duplicates to remove: $totalDuplicates\n";
echo "Confirm deletion? (y/n): ";

$handle = fopen("php://stdin", "r");
$line = fgets($handle);
if (trim($line) !== 'y') {
    echo "Aborted.\n";
    exit(0);
}

if (!empty($idsToDelete)) {
    DB::table('posts')->whereIn('id', $idsToDelete)->delete();
    echo "Deleted " . count($idsToDelete) . " duplicate posts!\n";
}

echo "Done!\n";