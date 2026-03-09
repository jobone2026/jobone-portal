<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;
use App\Models\State;
use Illuminate\Support\Str;

echo "Adding Categories and States...\n\n";

// Categories for Government Jobs
$categories = [
    ['name' => 'Banking', 'icon' => 'fa-university', 'color' => '#3B82F6'],
    ['name' => 'Railways', 'icon' => 'fa-train', 'color' => '#EF4444'],
    ['name' => 'SSC', 'icon' => 'fa-graduation-cap', 'color' => '#10B981'],
    ['name' => 'UPSC', 'icon' => 'fa-landmark', 'color' => '#8B5CF6'],
    ['name' => 'Defence', 'icon' => 'fa-shield-alt', 'color' => '#F59E0B'],
    ['name' => 'Police', 'icon' => 'fa-user-shield', 'color' => '#06B6D4'],
    ['name' => 'Teaching', 'icon' => 'fa-chalkboard-teacher', 'color' => '#EC4899'],
    ['name' => 'PSU', 'icon' => 'fa-industry', 'color' => '#6366F1'],
    ['name' => 'State Govt', 'icon' => 'fa-building', 'color' => '#14B8A6'],
    ['name' => 'Central Govt', 'icon' => 'fa-flag', 'color' => '#F97316'],
    ['name' => 'Court', 'icon' => 'fa-gavel', 'color' => '#A855F7'],
    ['name' => 'Medical', 'icon' => 'fa-hospital', 'color' => '#EF4444'],
    ['name' => 'Engineering', 'icon' => 'fa-cogs', 'color' => '#3B82F6'],
    ['name' => 'Agriculture', 'icon' => 'fa-leaf', 'color' => '#10B981'],
    ['name' => 'Post Office', 'icon' => 'fa-envelope', 'color' => '#F59E0B'],
];

echo "Adding Categories:\n";
foreach ($categories as $cat) {
    $category = Category::firstOrCreate(
        ['slug' => Str::slug($cat['name'])],
        [
            'name' => $cat['name'],
            'icon' => $cat['icon'],
            'color' => $cat['color']
        ]
    );
    echo "  ✓ {$cat['name']}\n";
}

// All Indian States and Union Territories
$states = [
    'Andhra Pradesh',
    'Arunachal Pradesh',
    'Assam',
    'Bihar',
    'Chhattisgarh',
    'Goa',
    'Gujarat',
    'Haryana',
    'Himachal Pradesh',
    'Jharkhand',
    'Karnataka',
    'Kerala',
    'Madhya Pradesh',
    'Maharashtra',
    'Manipur',
    'Meghalaya',
    'Mizoram',
    'Nagaland',
    'Odisha',
    'Punjab',
    'Rajasthan',
    'Sikkim',
    'Tamil Nadu',
    'Telangana',
    'Tripura',
    'Uttar Pradesh',
    'Uttarakhand',
    'West Bengal',
    'Andaman and Nicobar Islands',
    'Chandigarh',
    'Dadra and Nagar Haveli and Daman and Diu',
    'Delhi',
    'Jammu and Kashmir',
    'Ladakh',
    'Lakshadweep',
    'Puducherry',
    'All India',
];

echo "\nAdding States:\n";
foreach ($states as $stateName) {
    $state = State::firstOrCreate(
        ['slug' => Str::slug($stateName)],
        ['name' => $stateName]
    );
    echo "  ✓ {$stateName}\n";
}

echo "\n✅ Successfully added:\n";
echo "   - " . Category::count() . " Categories\n";
echo "   - " . State::count() . " States\n";
echo "\nYou can now create posts in the admin panel!\n";
