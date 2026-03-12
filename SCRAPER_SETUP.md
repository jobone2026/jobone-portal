# FreeJobAlert Scraper Setup Guide

## Quick Start

### 1. Deploy to Server
```bash
cd /var/www/jobone
sudo git pull origin main
sudo chmod +x scrape-jobs.sh
```

### 2. Test Scraper (First Run)
```bash
# Scrape 10 jobs to test
php artisan scrape:freejobalert --limit=10
```

### 3. Full Scrape
```bash
# Scrape 100 jobs
php artisan scrape:freejobalert --limit=100

# Or use the script
sudo bash scrape-jobs.sh 100
```

---

## Enable Daily Scheduling

Add this line to your crontab to run the scheduler every minute:

```bash
sudo crontab -e
```

Add this line:
```
* * * * * cd /var/www/jobone && php artisan schedule:run >> /dev/null 2>&1
```

This will automatically scrape 100 jobs daily at 2:00 AM.

---

## How It Works

1. **Scrapes** freejobalert.com/government-jobs/
2. **Extracts** job title, description, and content
3. **Auto-categorizes** based on keywords:
   - Banking (SBI, IBPS, Clerk, PO)
   - Railways (RRB, NTPC)
   - SSC (CGL, CHSL)
   - UPSC (IAS, IPS, Civil Service)
   - Defence (Army, Navy, Air Force)
   - Police (Constable, SI)
   - Teaching (Lecturer, Professor)
   - PSU (NTPC, BHEL, IOCL)
   - State Govt (PSC)
   - Central Govt
   - Medical (NEET, Doctor, Nurse)
   - Engineering (GATE)

4. **Sets** all jobs to "All India" state
5. **Skips** duplicates (checks by slug)
6. **Publishes** automatically
7. **Generates** SEO metadata

---

## Manual Commands

```bash
# Scrape 50 jobs
php artisan scrape:freejobalert --limit=50

# Scrape 200 jobs
php artisan scrape:freejobalert --limit=200

# Check if scheduler is running
ps aux | grep schedule:run
```

---

## Troubleshooting

### Command not found
```bash
php artisan list | grep scrape
```

### Check cron is running
```bash
sudo service cron status
```

### View cron logs
```bash
sudo tail -f /var/log/syslog | grep CRON
```

### Manual test
```bash
cd /var/www/jobone
php artisan scrape:freejobalert --limit=5
```

---

## Features

✅ Automatic duplicate detection  
✅ Smart category detection  
✅ HTML content extraction  
✅ SEO metadata generation  
✅ Daily scheduling  
✅ Error handling  
✅ Progress reporting  

---

**Status:** ✅ Ready to Deploy  
**Last Updated:** March 12, 2026
