# Website Stress Testing & Rate Limiting Guide

## 🎯 Purpose
Test your website's performance under load and protect it from traffic spikes/attacks.

---

## 📊 STRESS TESTING TOOLS

### 1. Apache Bench (ab) - Simple & Quick
```bash
# Install
sudo apt-get install apache2-utils

# Test with 100 requests, 10 concurrent
ab -n 100 -c 10 https://jobone.in/

# Test with 1000 requests, 50 concurrent
ab -n 1000 -c 50 https://jobone.in/

# Test specific page
ab -n 500 -c 25 https://jobone.in/posts/latest-govt-jobs
```

### 2. wrk - More Advanced
```bash
# Install
sudo apt-get install wrk

# Test for 30 seconds with 10 connections
wrk -t4 -c10 -d30s https://jobone.in/

# Test for 1 minute with 50 connections
wrk -t8 -c50 -d60s https://jobone.in/
```

### 3. siege - Realistic Load Testing
```bash
# Install
sudo apt-get install siege

# Test with 25 concurrent users for 1 minute
siege -c25 -t1M https://jobone.in/

# Test with 100 concurrent users for 30 seconds
siege -c100 -t30S https://jobone.in/
```

---

## 🛡️ RATE LIMITING (Protect Your Site)

### Nginx Rate Limiting Configuration

Add this to `/etc/nginx/nginx.conf` in the `http` block:

```nginx
# Define rate limit zones
limit_req_zone $binary_remote_addr zone=general:10m rate=10r/s;
limit_req_zone $binary_remote_addr zone=api:10m rate=5r/s;
limit_req_zone $binary_remote_addr zone=login:10m rate=2r/s;

# Connection limit
limit_conn_zone $binary_remote_addr zone=addr:10m;
```

Then add to your server blocks in `/etc/nginx/sites-available/jobone.in`:

```nginx
server {
    # ... existing config ...

    # General rate limit: 10 requests/second per IP
    limit_req zone=general burst=20 nodelay;
    
    # Connection limit: 10 concurrent connections per IP
    limit_conn addr 10;

    # API endpoints - stricter limit
    location /api/ {
        limit_req zone=api burst=10 nodelay;
        # ... rest of config ...
    }

    # Login/admin - very strict
    location /admin/login {
        limit_req zone=login burst=5 nodelay;
        # ... rest of config ...
    }

    # ... rest of config ...
}
```

---

## 🚀 RECOMMENDED RATE LIMITS

### For Your Job Portal:

```nginx
# Public pages: 10 req/sec (600/min)
limit_req_zone $binary_remote_addr zone=public:10m rate=10r/s;

# Search: 5 req/sec (300/min)
limit_req_zone $binary_remote_addr zone=search:10m rate=5r/s;

# API: 5 req/sec (300/min)
limit_req_zone $binary_remote_addr zone=api:10m rate=5r/s;

# Admin login: 2 req/sec (120/min)
limit_req_zone $binary_remote_addr zone=admin:10m rate=2r/s;
```

---

## 📝 COMPLETE NGINX CONFIG WITH RATE LIMITING

```nginx
# Add to /etc/nginx/nginx.conf in http block
http {
    # ... existing config ...

    # Rate limiting zones
    limit_req_zone $binary_remote_addr zone=public:10m rate=10r/s;
    limit_req_zone $binary_remote_addr zone=search:10m rate=5r/s;
    limit_req_zone $binary_remote_addr zone=api:10m rate=5r/s;
    limit_req_zone $binary_remote_addr zone=admin:10m rate=2r/s;
    limit_conn_zone $binary_remote_addr zone=addr:10m;

    # ... rest of config ...
}
```

```nginx
# Add to /etc/nginx/sites-available/jobone.in in server block
server {
    # ... existing config ...

    # General rate limit
    limit_req zone=public burst=20 nodelay;
    limit_conn addr 15;

    # Search endpoint
    location /search {
        limit_req zone=search burst=10 nodelay;
        try_files $uri $uri/ /index.php?$query_string;
    }

    # API endpoints
    location /api/ {
        limit_req zone=api burst=10 nodelay;
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Admin area
    location /admin/ {
        limit_req zone=admin burst=5 nodelay;
        try_files $uri $uri/ /index.php?$query_string;
    }

    # ... rest of config ...
}
```

---

## 🧪 STRESS TEST SCENARIOS

### Scenario 1: Light Load (Normal Traffic)
```bash
# 100 users over 1 minute
ab -n 6000 -c 100 https://jobone.in/
```

### Scenario 2: Medium Load (Peak Hours)
```bash
# 250 users over 2 minutes
siege -c250 -t2M https://jobone.in/
```

### Scenario 3: Heavy Load (Viral Post)
```bash
# 500 users over 1 minute
wrk -t12 -c500 -d60s https://jobone.in/
```

### Scenario 4: Attack Simulation
```bash
# 1000 concurrent connections (should be blocked by rate limit)
ab -n 10000 -c 1000 https://jobone.in/
```

---

## 📈 MONITORING DURING STRESS TEST

### Check Server Load
```bash
# CPU, Memory, Load average
htop

# Or
top
```

### Check Nginx Connections
```bash
# Active connections
sudo netstat -an | grep :443 | wc -l

# Or
ss -s
```

### Check Rate Limit Blocks
```bash
# Watch Nginx error log for rate limit messages
sudo tail -f /var/log/nginx/error.log | grep limiting
```

### Check PHP-FPM Status
```bash
# Check if PHP-FPM is handling requests
sudo systemctl status php8.2-fpm

# Check PHP-FPM pool status (if configured)
curl http://localhost/php-fpm-status
```

---

## 🔧 DEPLOYMENT COMMANDS

### Deploy Rate Limiting
```bash
# Backup current config
sudo cp /etc/nginx/nginx.conf /etc/nginx/nginx.conf.backup

# Edit nginx.conf to add rate limit zones
sudo nano /etc/nginx/nginx.conf

# Edit site config to apply rate limits
sudo nano /etc/nginx/sites-available/jobone.in

# Test config
sudo nginx -t

# Reload if test passes
sudo service nginx reload
```

---

## 📊 INTERPRETING RESULTS

### Good Performance Indicators:
- Response time < 200ms for 95% of requests
- 0% failed requests under normal load
- Server load < 2.0 on single CPU
- Memory usage < 80%

### Warning Signs:
- Response time > 500ms
- Failed requests > 1%
- Server load > 4.0
- Memory usage > 90%

### Critical Issues:
- Response time > 2000ms
- Failed requests > 5%
- Server load > 8.0
- Out of memory errors

---

## 🚨 EMERGENCY: STOP ATTACK

If your site is under attack:

```bash
# Block specific IP
sudo iptables -A INPUT -s ATTACKER_IP -j DROP

# Temporarily enable aggressive rate limiting
sudo nano /etc/nginx/sites-available/jobone.in
# Change: limit_req zone=public burst=5 nodelay;

# Reload Nginx
sudo service nginx reload

# Check blocked IPs in logs
sudo tail -100 /var/log/nginx/error.log | grep limiting | awk '{print $11}' | sort | uniq -c | sort -rn
```

---

## 📋 QUICK REFERENCE

| Tool | Best For | Command |
|------|----------|---------|
| ab | Quick tests | `ab -n 1000 -c 50 URL` |
| wrk | Sustained load | `wrk -t8 -c100 -d60s URL` |
| siege | Realistic traffic | `siege -c100 -t1M URL` |

| Rate Limit | Requests/sec | Use Case |
|------------|--------------|----------|
| Public | 10 r/s | General pages |
| Search | 5 r/s | Search queries |
| API | 5 r/s | API endpoints |
| Admin | 2 r/s | Login/admin |

---

## ✅ RECOMMENDED SETUP FOR YOUR SITE

1. Add rate limiting to Nginx (10 req/sec general)
2. Test with `ab -n 1000 -c 50`
3. Monitor with `htop` and `tail -f /var/log/nginx/error.log`
4. Adjust limits based on results
