<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CleanupCache extends Command
{
    protected $signature = 'cache:cleanup {--max-size=100 : Max cache size in MB}';
    protected $description = 'Clean up old cache files to prevent memory issues';

    public function handle()
    {
        $maxSizeMB = $this->option('max-size');
        $maxSizeBytes = $maxSizeMB * 1024 * 1024;

        $this->info("Starting cache cleanup (max size: {$maxSizeMB}MB)...");

        // Clean file cache
        $this->cleanFileCache($maxSizeBytes);

        // Clean view cache
        $this->cleanViewCache();

        $this->info('✓ Cache cleanup completed successfully!');
    }

    private function cleanFileCache($maxSizeBytes)
    {
        $cacheDir = storage_path('framework/cache/data');

        if (!is_dir($cacheDir)) {
            $this->warn('Cache directory not found');
            return;
        }

        $totalSize = 0;
        $files = [];

        // Get all cache files with their sizes
        foreach (File::allFiles($cacheDir) as $file) {
            $size = $file->getSize();
            $totalSize += $size;
            $files[] = [
                'path' => $file->getRealPath(),
                'size' => $size,
                'time' => $file->getMTime()
            ];
        }

        $this->line("Current cache size: " . $this->formatBytes($totalSize));

        // If cache is too large, delete oldest files
        if ($totalSize > $maxSizeBytes) {
            $this->warn("Cache size exceeds limit! Cleaning up...");

            // Sort by modification time (oldest first)
            usort($files, function ($a, $b) {
                return $a['time'] - $b['time'];
            });

            $deletedSize = 0;
            $deletedCount = 0;

            foreach ($files as $file) {
                if ($totalSize - $deletedSize <= $maxSizeBytes * 0.8) {
                    break; // Stop when we reach 80% of max size
                }

                if (@unlink($file['path'])) {
                    $deletedSize += $file['size'];
                    $deletedCount++;
                }
            }

            $this->line("Deleted {$deletedCount} old cache files (" . $this->formatBytes($deletedSize) . ")");
        }

        // Delete individual files larger than 10MB
        foreach ($files as $file) {
            if ($file['size'] > 10 * 1024 * 1024) {
                if (@unlink($file['path'])) {
                    $this->line("Deleted large cache file: " . $this->formatBytes($file['size']));
                }
            }
        }
    }

    private function cleanViewCache()
    {
        $viewCacheDir = storage_path('framework/views');

        if (is_dir($viewCacheDir)) {
            $files = File::allFiles($viewCacheDir);
            $count = count($files);

            if ($count > 0) {
                File::deleteDirectory($viewCacheDir);
                $this->line("Cleaned {$count} view cache files");
            }
        }
    }

    private function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
