# Quick Reference Card

## 🔌 Connect
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67
```

## 🚀 Deploy
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67 "cd /var/www/jobone && git pull && sudo chown -R www-data:www-data . && sudo -u www-data php artisan config:cache && sudo systemctl restart php8.2-fpm"
```

## 🆘 Emergency Fix
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67 "cd /var/www/jobone && sudo mkdir -p bootstrap/cache storage/framework/{cache,views,sessions} && sudo chown -R www-data:www-data storage bootstrap && sudo -u www-data php artisan config:cache && sudo systemctl restart php8.2-fpm"
```

## 📊 Check Status
```bash
curl -I https://jobone.in/
```

## 📝 View Logs
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67 "tail -50 /var/www/jobone/storage/logs/laravel.log"
```

## 🔄 Restart Services
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67 "sudo systemctl restart php8.2-fpm nginx"
```

## 🧹 Clear Cache
```bash
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67 "cd /var/www/jobone && sudo -u www-data php artisan cache:clear && sudo -u www-data php artisan config:cache"
```

## 📚 Full Documentation
- **SERVER_CONNECTION.md** - Complete server guide
- **AI_CONTEXT.md** - AI assistant context
- **AUTO_MAINTENANCE_SETUP.md** - Maintenance system
- **API_COMPLETE_DOCUMENTATION.md** - API docs

## 🌐 URLs
- **Site**: https://jobone.in
- **API**: https://jobone.in/api/categories
- **Server IP**: 3.108.161.67
