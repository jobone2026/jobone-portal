<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HealthCheck extends Command
{
    protected $signature = 'health:check';
    protected $description = 'Perform health check and fix common issues';

    public function handle()
    {
        $this->info('🏥 Running Health Check...');

        // Check storage directories
        $storagePath = storage_path();
        $directories = [
            'framework/views',
            'framework/cache',
            'framework/sessions',
            'logs',
            'app',
        ];

        foreach ($directories as $dir) {
            $path = $storagePath . '/' . $dir;
            if (!is_dir($path)) {
                mkdir($path, 0775, true);
                $this->warn("Created missing directory: $dir");
            }
        }

        // Fix permissions
        exec("chown -R www-data:www-data {$storagePath}");
        exec("chmod -R 775 {$storagePath}");
        $this->info('✅ Storage permissions fixed');

        // Clear old compiled views
        $viewsPath = storage_path('framework/views');
        $files = glob($viewsPath . '/*.php');
        if ($files) {
            foreach ($files as $file) {
                if (filemtime($file) < time() - 86400) { // Older than 1 day
                    unlink($file);
                }
            }
            $this->info('✅ Old compiled views cleaned');
        }

        // Check database connection
        try {
            \DB::connection()->getPdo();
            $this->info('✅ Database connection OK');
        } catch (\Exception $e) {
            $this->error('❌ Database connection failed: ' . $e->getMessage());
            return 1;
        }

        $this->info('✅ Health check completed successfully!');
        return 0;
    }
}
