<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Banking', 'slug' => 'banking', 'icon' => 'bank', 'color' => '#1e40af'],
            ['name' => 'Railways', 'slug' => 'railways', 'icon' => 'train', 'color' => '#dc2626'],
            ['name' => 'SSC', 'slug' => 'ssc', 'icon' => 'briefcase', 'color' => '#059669'],
            ['name' => 'UPSC', 'slug' => 'upsc', 'icon' => 'graduation-cap', 'color' => '#7c3aed'],
            ['name' => 'State PSC', 'slug' => 'state-psc', 'icon' => 'building', 'color' => '#f59e0b'],
            ['name' => 'Defence', 'slug' => 'defence', 'icon' => 'fighter-jet', 'color' => '#0891b2'],
            ['name' => 'Police', 'slug' => 'police', 'icon' => 'user-shield', 'color' => '#dc2626'],
            ['name' => 'SSB', 'slug' => 'ssb', 'icon' => 'user-shield', 'color' => '#64748b'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
