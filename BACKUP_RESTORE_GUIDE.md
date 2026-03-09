# Database Backup & Restore Guide

Complete guide for using the database backup and restore feature in the admin panel.

## Features

- ✅ One-click database backup
- ✅ Download backups to your computer
- ✅ Upload existing backups
- ✅ One-click restore
- ✅ Automatic compression (ZIP format)
- ✅ User-friendly interface

## Accessing Backup Management

1. Login to admin panel: `/admin/login`
2. Navigate to: **Settings → Backup & Restore**
3. Or visit directly: `/admin/backups`

## Creating a Backup

### Method 1: From Admin Panel

1. Go to **Backup & Restore** page
2. Click **"Create Backup Now"** button
3. Wait for the backup to complete
4. Backup will appear in the list below

### Method 2: Using Command Line

```bash
# SSH to your server
ssh ubuntu@your-server-ip

# Navigate to project
cd /var/www/jobone

# Create backup manually
mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql

# Compress backup
gzip backup_*.sql
```

## Downloading Backups

1. Go to **Backup & Restore** page
2. Find the backup you want to download
3. Click the **Download** icon (↓)
4. Save the ZIP file to your computer

**Recommended**: Download backups regularly and store them in multiple locations.

## Uploading Backups

If you have a backup file from another location:

1. Go to **Backup & Restore** page
2. Click **"Choose File"** under Upload Backup
3. Select your backup ZIP file
4. Click **"Upload Backup"**
5. The backup will be added to your list

## Restoring a Backup

⚠️ **WARNING**: Restoring will overwrite ALL current data!

### Before Restoring:

1. **Create a current backup** (in case you need to revert)
2. **Inform users** if the site is live
3. **Ensure you have the correct backup file**

### Restore Process:

1. Go to **Backup & Restore** page
2. Find the backup you want to restore
3. Click the **Restore** icon (↻)
4. Confirm the warning message
5. Wait for restore to complete
6. **You will be logged out** - this is normal
7. Login again with your credentials

### After Restoring:

```bash
# Clear all caches (done automatically, but you can run manually)
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Backup File Format

Backups are stored as compressed ZIP files:

```
backup_2026-03-09_143022.zip
  └── backup_2026-03-09_143022.sql
```

- **Filename format**: `backup_YYYY-MM-DD_HHMMSS.zip`
- **Contains**: SQL dump of entire database
- **Compression**: ZIP format for smaller file size

## Storage Location

Backups are stored in:
```
storage/app/backups/
```

**Important**: This directory is excluded from Git (in `.gitignore`)

## Backup Best Practices

### Regular Backups

- **Daily**: For active sites with frequent updates
- **Weekly**: For sites with moderate activity
- **Before major changes**: Always backup before:
  - Software updates
  - Theme changes
  - Plugin installations
  - Database modifications

### Storage Strategy

1. **Local Storage**: Keep 3-5 recent backups on server
2. **Download**: Download weekly backups to your computer
3. **Cloud Storage**: Upload to Google Drive, Dropbox, or AWS S3
4. **Multiple Locations**: Store in at least 2 different places

### Retention Policy

- Keep last 7 daily backups
- Keep last 4 weekly backups
- Keep last 12 monthly backups
- Delete old backups to save disk space

## Automated Backups

### Using Cron (Linux/Unix)

Create a backup script:

```bash
#!/bin/bash
# /var/www/jobone/backup-auto.sh

cd /var/www/jobone
php artisan backup:create

# Keep only last 7 backups
cd storage/app/backups
ls -t | tail -n +8 | xargs rm -f
```

Make it executable:
```bash
chmod +x /var/www/jobone/backup-auto.sh
```

Add to crontab:
```bash
crontab -e
```

Add this line (runs daily at 2 AM):
```cron
0 2 * * * /var/www/jobone/backup-auto.sh >> /var/www/jobone/storage/logs/backup.log 2>&1
```

### Using Laravel Scheduler

Add to `routes/console.php`:

```php
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    // Create backup
    $filename = 'backup_' . date('Y-m-d_His') . '.sql';
    $backupPath = storage_path('app/backups');
    
    if (!file_exists($backupPath)) {
        mkdir($backupPath, 0755, true);
    }
    
    $filepath = $backupPath . '/' . $filename;
    
    $dbHost = config('database.connections.mysql.host');
    $dbName = config('database.connections.mysql.database');
    $dbUser = config('database.connections.mysql.username');
    $dbPass = config('database.connections.mysql.password');
    
    $command = sprintf(
        'mysqldump -u%s -p%s -h%s %s > %s',
        escapeshellarg($dbUser),
        escapeshellarg($dbPass),
        escapeshellarg($dbHost),
        escapeshellarg($dbName),
        escapeshellarg($filepath)
    );
    
    exec($command);
    
    // Compress
    $zip = new ZipArchive();
    $zipPath = str_replace('.sql', '.zip', $filepath);
    if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
        $zip->addFile($filepath, $filename);
        $zip->close();
        unlink($filepath);
    }
})->daily()->at('02:00');
```

## Troubleshooting

### "Backup creation failed"

**Possible causes:**
- MySQL not installed or not in PATH
- Incorrect database credentials
- Insufficient disk space
- Permission issues

**Solutions:**
```bash
# Check MySQL is installed
mysql --version

# Check disk space
df -h

# Check permissions
ls -la storage/app/backups

# Fix permissions
sudo chown -R www-data:www-data storage/app/backups
sudo chmod -R 775 storage/app/backups
```

### "Restore failed"

**Possible causes:**
- Corrupted backup file
- Incompatible database version
- Insufficient permissions

**Solutions:**
```bash
# Test backup file
unzip -t backup_file.zip

# Check MySQL version
mysql --version

# Manual restore
unzip backup_file.zip
mysql -u username -p database_name < backup_file.sql
```

### "Permission denied"

```bash
# Fix storage permissions
sudo chown -R www-data:www-data storage/
sudo chmod -R 775 storage/

# Fix backup directory
sudo mkdir -p storage/app/backups
sudo chown -R www-data:www-data storage/app/backups
sudo chmod -R 775 storage/app/backups
```

### Large Database Issues

For databases larger than 100MB:

1. **Increase PHP limits** in `php.ini`:
```ini
upload_max_filesize = 500M
post_max_size = 500M
max_execution_time = 300
memory_limit = 512M
```

2. **Use command line** for large backups:
```bash
# Backup
mysqldump -u username -p database_name | gzip > backup.sql.gz

# Restore
gunzip < backup.sql.gz | mysql -u username -p database_name
```

## Security Considerations

### Backup Security

1. **Encrypt backups** for sensitive data:
```bash
# Encrypt
zip -e backup.zip backup.sql

# Decrypt
unzip backup.zip
```

2. **Secure storage location**:
```bash
# Set restrictive permissions
chmod 600 storage/app/backups/*.zip
```

3. **Regular cleanup**:
```bash
# Delete backups older than 30 days
find storage/app/backups -name "*.zip" -mtime +30 -delete
```

### Access Control

- Only administrators can access backup features
- Backup files are stored outside public directory
- Download links are protected by authentication

## Backup Checklist

Before going live:

- [ ] Test backup creation
- [ ] Test backup download
- [ ] Test backup restore
- [ ] Set up automated backups
- [ ] Configure backup retention
- [ ] Document backup procedures
- [ ] Test disaster recovery

## Disaster Recovery Plan

### If Site Goes Down:

1. **Assess the situation**
   - Check error logs
   - Identify the issue

2. **Restore from backup**
   - Upload latest backup
   - Restore database
   - Clear caches

3. **Verify restoration**
   - Check homepage loads
   - Test admin login
   - Verify data integrity

4. **Post-recovery**
   - Document what happened
   - Update backup procedures
   - Implement preventive measures

## Support

For backup-related issues:

- **Email**: jobone2026@gmail.com
- **Check logs**: `storage/logs/laravel.log`
- **Server logs**: `/var/log/nginx/error.log`

## Additional Resources

- [MySQL Backup Documentation](https://dev.mysql.com/doc/refman/8.0/en/backup-and-recovery.html)
- [Laravel Backup Package](https://spatie.be/docs/laravel-backup)
- [AWS S3 Backup Guide](https://docs.aws.amazon.com/AmazonS3/latest/userguide/backup-and-restore.html)

---

**Remember**: Regular backups are your safety net. Don't skip them! 🛡️

**Last Updated**: March 9, 2026
