<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use ZipArchive;

class BackupController extends Controller
{
    /**
     * Display backup management page
     */
    public function index()
    {
        $backups = $this->getBackupFiles();
        
        return view('admin.backups.index', compact('backups'));
    }

    /**
     * Create a new database backup
     */
    public function create()
    {
        try {
            $filename = 'backup_' . date('Y-m-d_His') . '.sql';
            $backupPath = storage_path('app/backups');
            
            // Create backups directory if it doesn't exist
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }
            
            $filepath = $backupPath . '/' . $filename;
            
            // Get database configuration
            $dbHost = config('database.connections.mysql.host');
            $dbName = config('database.connections.mysql.database');
            $dbUser = config('database.connections.mysql.username');
            $dbPass = config('database.connections.mysql.password');
            
            // Create backup using mysqldump
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Windows
                $command = sprintf(
                    'mysqldump --user=%s --password=%s --host=%s %s > %s',
                    escapeshellarg($dbUser),
                    escapeshellarg($dbPass),
                    escapeshellarg($dbHost),
                    escapeshellarg($dbName),
                    escapeshellarg($filepath)
                );
            } else {
                // Linux/Unix
                $command = sprintf(
                    'mysqldump -u%s -p%s -h%s %s > %s',
                    escapeshellarg($dbUser),
                    escapeshellarg($dbPass),
                    escapeshellarg($dbHost),
                    escapeshellarg($dbName),
                    escapeshellarg($filepath)
                );
            }
            
            exec($command, $output, $returnVar);
            
            if ($returnVar !== 0 || !file_exists($filepath)) {
                throw new \Exception('Backup creation failed');
            }
            
            // Compress the backup
            $zipFilename = str_replace('.sql', '.zip', $filename);
            $zipPath = $backupPath . '/' . $zipFilename;
            
            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                $zip->addFile($filepath, $filename);
                $zip->close();
                
                // Delete uncompressed SQL file
                unlink($filepath);
            }
            
            return redirect()->route('admin.backups.index')
                ->with('success', 'Database backup created successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.backups.index')
                ->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    /**
     * Download a backup file
     */
    public function download($filename)
    {
        $filepath = storage_path('app/backups/' . $filename);
        
        if (!file_exists($filepath)) {
            return redirect()->route('admin.backups.index')
                ->with('error', 'Backup file not found');
        }
        
        return response()->download($filepath);
    }

    /**
     * Delete a backup file
     */
    public function delete($filename)
    {
        $filepath = storage_path('app/backups/' . $filename);
        
        if (file_exists($filepath)) {
            unlink($filepath);
            
            return redirect()->route('admin.backups.index')
                ->with('success', 'Backup deleted successfully');
        }
        
        return redirect()->route('admin.backups.index')
            ->with('error', 'Backup file not found');
    }

    /**
     * Restore database from backup
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|string'
        ]);
        
        try {
            $filename = $request->backup_file;
            $filepath = storage_path('app/backups/' . $filename);
            
            if (!file_exists($filepath)) {
                throw new \Exception('Backup file not found');
            }
            
            // Extract SQL file from ZIP
            $zip = new ZipArchive();
            $extractPath = storage_path('app/backups/temp');
            
            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0755, true);
            }
            
            if ($zip->open($filepath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();
                
                // Find the SQL file
                $sqlFile = null;
                $files = scandir($extractPath);
                foreach ($files as $file) {
                    if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                        $sqlFile = $extractPath . '/' . $file;
                        break;
                    }
                }
                
                if (!$sqlFile) {
                    throw new \Exception('SQL file not found in backup');
                }
                
                // Get database configuration
                $dbHost = config('database.connections.mysql.host');
                $dbName = config('database.connections.mysql.database');
                $dbUser = config('database.connections.mysql.username');
                $dbPass = config('database.connections.mysql.password');
                
                // Restore database
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    // Windows
                    $command = sprintf(
                        'mysql --user=%s --password=%s --host=%s %s < %s',
                        escapeshellarg($dbUser),
                        escapeshellarg($dbPass),
                        escapeshellarg($dbHost),
                        escapeshellarg($dbName),
                        escapeshellarg($sqlFile)
                    );
                } else {
                    // Linux/Unix
                    $command = sprintf(
                        'mysql -u%s -p%s -h%s %s < %s',
                        escapeshellarg($dbUser),
                        escapeshellarg($dbPass),
                        escapeshellarg($dbHost),
                        escapeshellarg($dbName),
                        escapeshellarg($sqlFile)
                    );
                }
                
                exec($command, $output, $returnVar);
                
                // Clean up temp files
                unlink($sqlFile);
                rmdir($extractPath);
                
                if ($returnVar !== 0) {
                    throw new \Exception('Database restore failed');
                }
                
                // Clear all caches
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                
                return redirect()->route('admin.backups.index')
                    ->with('success', 'Database restored successfully! Please re-login.');
                    
            } else {
                throw new \Exception('Failed to extract backup file');
            }
            
        } catch (\Exception $e) {
            return redirect()->route('admin.backups.index')
                ->with('error', 'Restore failed: ' . $e->getMessage());
        }
    }

    /**
     * Upload and restore backup
     */
    public function upload(Request $request)
    {
        $request->validate([
            'backup_upload' => 'required|file|mimes:zip|max:102400' // Max 100MB
        ]);
        
        try {
            $file = $request->file('backup_upload');
            $filename = 'uploaded_' . date('Y-m-d_His') . '.zip';
            $backupPath = storage_path('app/backups');
            
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }
            
            $file->move($backupPath, $filename);
            
            return redirect()->route('admin.backups.index')
                ->with('success', 'Backup file uploaded successfully! You can now restore it.');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.backups.index')
                ->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    /**
     * Get list of backup files
     */
    private function getBackupFiles()
    {
        $backupPath = storage_path('app/backups');
        
        if (!file_exists($backupPath)) {
            return [];
        }
        
        $files = scandir($backupPath);
        $backups = [];
        
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                $filepath = $backupPath . '/' . $file;
                $backups[] = [
                    'filename' => $file,
                    'size' => $this->formatBytes(filesize($filepath)),
                    'date' => date('Y-m-d H:i:s', filemtime($filepath))
                ];
            }
        }
        
        // Sort by date descending
        usort($backups, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        return $backups;
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
