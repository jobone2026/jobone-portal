<?php
// Run this file to add missing categories
// Usage: php add-categories.php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;

$categories = [
    ['name' => 'Police', 'slug' => 'police', 'icon' => 'user-shield', 'color' => '#dc2626'],
    ['name' => 'SSB', 'slug' => 'ssb', 'icon' => 'user-shield', 'color' => '#64748b'],
];

foreach ($categories as $categoryData) {
    $category = Category::where('slug', $categoryData['slug'])->first();
    
    if (!$category) {
        Category::create($categoryData);
        echo "✓ Created category: {$categoryData['name']}\n";
    } else {
        echo "- Category already exists: {$categoryData['name']}\n";
    }
}

// Update Defence icon
$defence = Category::where('slug', 'defence')->first();
if ($defence) {
    $defence->update(['icon' => 'fighter-jet']);
    echo "✓ Updated Defence icon\n";
}

echo "\nDone!\n";
