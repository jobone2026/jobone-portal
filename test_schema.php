<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$post = new \App\Models\Post([
    'title' => 'UPSC Civil Services Examination 2026',
    'content' => '<p>This is a test post.</p>',
    'organization' => 'Union Public Service Commission',
    'direct_apply' => 1,
    'salary_min' => 56100,
    'salary_max' => 177500,
    'total_posts' => 1056,
    'qualifications' => 'Bachelor Degree in Any Stream from a Recognized University',
    'type' => 'job',
    'salary_type' => 'salary'
]);
$post->last_date = \Carbon\Carbon::parse('2026-06-01');
$post->created_at = now();
$post->updated_at = now();
$post->notification_date = now()->subDays(5);

$service = app(\App\Services\SchemaService::class);
$schema = $service->generateJobPostingSchema($post);

file_put_contents('schema_test.json', json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "Done";
