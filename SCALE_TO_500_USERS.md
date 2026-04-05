# Scaling to 500+ Concurrent Users

## Current Capacity
- **Tested**: 100 concurrent users (stress test)
- **Throughput**: 17 requests/second
- **Real user capacity**: 300-500 users (depending on browsing speed)

---

## If You Need More Capacity

### 1. INCREASE PHP-FPM WORKERS (Quick Win)

Current PHP-FPM is likely limiting you. Check current settings:

```bash
sudo nano /etc/php/8.2/fpm/pool.d/www.conf
```

Find and update these lines:

```ini
; Current (probably):
pm = dynamic
pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3

; Change to (for 500+ users):
pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.max_requests = 500
```

Then restart:
```bash
sudo service php8.2-fpm restart
```

**Expected improvement**: 3-5x more capacity (50-85 req/sec)

---

### 2. ENABLE OPCACHE (Huge Performance Boost)

Check if enabled:
```bash
php -i | grep opcache.enable
```

If not enabled, edit:
```bash
sudo nano /etc/php/8.2/fpm/php.ini
```

Add/update:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

Restart:
```bash
sudo service php8.2-fpm restart
```

**Expected improvement**: 2-3x faster PHP execution

---

### 3. INCREASE NGINX WORKER CONNECTIONS

Edit nginx.conf:
```bash
sudo nano /etc/nginx/nginx.conf
```

Change:
```nginx
events {
    worker_connections 768;  # Current
}
```

To:
```nginx
events {
    worker_connections 2048;  # For 500+ users
    multi_accept on;
    use epoll;
}
```

Reload:
```bash
sudo nginx -t && sudo service nginx reload
```

---

### 4. ADD REDIS CACHE (Advanced)

Install Redis:
```bash
sudo apt-get install redis-server php8.2-redis
sudo service redis-server start
sudo service php8.2-fpm restart
```

Update Laravel .env:
```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

Clear cache:
```bash
cd /var/www/jobone
php artisan config:cache
php artisan cache:clear
```

**Expected improvement**: 5-10x faster for cached content

---

### 5. DATABASE OPTIMIZATION

Check MySQL connections:
```bash
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
```

Update:
```ini
max_connections = 200
innodb_buffer_pool_size = 512M
query_cache_size = 64M
query_cache_limit = 2M
```

Restart:
```bash
sudo service mysql restart
```

---

## QUICK UPGRADE PATH (Recommended)

### Step 1: PHP-FPM Workers (5 minutes)
```bash
sudo nano /etc/php/8.2/fpm/pool.d/www.conf
# Set pm.max_children = 50
sudo service php8.2-fpm restart
```

### Step 2: Enable OPcache (5 minutes)
```bash
sudo nano /etc/php/8.2/fpm/php.ini
# Enable opcache settings above
sudo service php8.2-fpm restart
```

### Step 3: Test Again
```bash
ab -n 1000 -c 100 https://jobone.in/
# Should see 40-60 req/sec now (was 17)
```

---

## MONITORING REAL TRAFFIC

### Install monitoring tools:
```bash
sudo apt-get install -y htop iotop nethogs
```

### Watch real-time stats:
```bash
# CPU and memory
htop

# Active connections
watch -n 1 'sudo netstat -an | grep :443 | wc -l'

# PHP-FPM status
watch -n 1 'sudo systemctl status php8.2-fpm | grep active'

# Nginx access log (real-time requests)
sudo tail -f /var/log/nginx/jobone.in-access.log
```

---

## CAPACITY CALCULATOR

After PHP-FPM upgrade (50 workers):

```
Estimated capacity with 50 PHP-FPM workers:

Light browsing (1 page/30s): 50 × 30 = 1,500 users ✓
Normal browsing (1 page/20s): 50 × 20 = 1,000 users ✓
Heavy browsing (1 page/10s): 50 × 10 = 500 users ✓
```

---

## WHEN TO UPGRADE SERVER

If you consistently see:
- Server load > 4.0 (check with `uptime`)
- Memory usage > 90% (check with `free -h`)
- Response time > 3 seconds for normal pages

Then consider:
- Upgrading to larger EC2 instance (more CPU/RAM)
- Adding a CDN (CloudFlare, AWS CloudFront)
- Load balancer with multiple servers

---

## CURRENT STATUS

✓ Your site handles 300-500 real users comfortably
✓ Rate limiting protects from attacks
✓ Performance optimized (71-74/100)

**Next step if you need more**: Increase PHP-FPM workers to 50
