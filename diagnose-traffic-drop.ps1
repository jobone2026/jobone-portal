# Traffic Drop Diagnostic Script (PowerShell)
# Run this to quickly check all potential issues

Write-Host "==================================================" -ForegroundColor Cyan
Write-Host "🔍 JOBONE.IN TRAFFIC DROP DIAGNOSTIC" -ForegroundColor Cyan
Write-Host "==================================================" -ForegroundColor Cyan
Write-Host ""

# 1. Check if site is accessible
Write-Host "1️⃣  Checking if site is accessible..." -ForegroundColor Yellow
try {
    $response = Invoke-WebRequest -Uri "https://jobone.in/" -Method Head -TimeoutSec 10 -UseBasicParsing
    if ($response.StatusCode -eq 200) {
        Write-Host "✅ Site is accessible (HTTP 200)" -ForegroundColor Green
    }
} catch {
    Write-Host "❌ Site is NOT accessible!" -ForegroundColor Red
}
Write-Host ""

# 2. Check robots.txt
Write-Host "2️⃣  Checking robots.txt..." -ForegroundColor Yellow
try {
    $robots = Invoke-WebRequest -Uri "https://jobone.in/robots.txt" -UseBasicParsing
    Write-Host ($robots.Content.Split("`n") | Select-Object -First 20)
    if ($robots.Content -match "Disallow: /\*\.xml") {
        Write-Host "❌ WARNING: robots.txt blocks XML files (sitemaps)!" -ForegroundColor Red
    } else {
        Write-Host "✅ robots.txt looks good" -ForegroundColor Green
    }
} catch {
    Write-Host "❌ Could not fetch robots.txt" -ForegroundColor Red
}
Write-Host ""

# 3. Check sitemaps
Write-Host "3️⃣  Checking sitemaps..." -ForegroundColor Yellow
$sitemaps = @("sitemap.xml", "sitemap-news.xml", "sitemap-posts.xml")
foreach ($sitemap in $sitemaps) {
    try {
        $response = Invoke-WebRequest -Uri "https://jobone.in/$sitemap" -Method Head -UseBasicParsing
        Write-Host "✅ $sitemap - OK (HTTP $($response.StatusCode))" -ForegroundColor Green
    } catch {
        Write-Host "❌ $sitemap - FAILED" -ForegroundColor Red
    }
}
Write-Host ""

# 4. Check .env for GA tracking
Write-Host "4️⃣  Checking Google Analytics configuration..." -ForegroundColor Yellow
if (Test-Path ".env") {
    $envContent = Get-Content ".env"
    $gaLine = $envContent | Where-Object { $_ -match "^GA_TRACKING_ID=" }
    if ($gaLine) {
        $gaId = ($gaLine -split "=")[1]
        if ([string]::IsNullOrWhiteSpace($gaId)) {
            Write-Host "❌ GA_TRACKING_ID is empty in .env" -ForegroundColor Red
        } else {
            Write-Host "✅ GA_TRACKING_ID is set: $gaId" -ForegroundColor Green
        }
    } else {
        Write-Host "❌ GA_TRACKING_ID not found in .env" -ForegroundColor Red
        Write-Host "   Add this line to .env: GA_TRACKING_ID=G-XXXXXXXXXX" -ForegroundColor Yellow
    }
} else {
    Write-Host "❌ .env file not found" -ForegroundColor Red
}
Write-Host ""

# 5. Check database connection
Write-Host "5️⃣  Checking database connection..." -ForegroundColor Yellow
try {
    $dbTest = php artisan tinker --execute="DB::connection()->getPdo(); echo 'OK';" 2>&1
    if ($dbTest -match "OK") {
        Write-Host "✅ Database connection OK" -ForegroundColor Green
    } else {
        Write-Host "❌ Database connection FAILED" -ForegroundColor Red
    }
} catch {
    Write-Host "❌ Could not test database connection" -ForegroundColor Red
}
Write-Host ""

# 6. Check recent posts
Write-Host "6️⃣  Checking recent posts (last 7 days)..." -ForegroundColor Yellow
try {
    $recentPosts = php artisan tinker --execute="echo \App\Models\Post::where('created_at', '>=', now()->subDays(7))->count();" 2>&1 | Select-Object -Last 1
    if ($recentPosts -match "\d+" -and [int]$Matches[0] -gt 0) {
        Write-Host "✅ Found $($Matches[0]) posts in last 7 days" -ForegroundColor Green
    } else {
        Write-Host "⚠️  No posts created in last 7 days" -ForegroundColor Yellow
    }
} catch {
    Write-Host "❌ Could not check recent posts" -ForegroundColor Red
}
Write-Host ""

# 7. Check disk space
Write-Host "7️⃣  Checking disk space..." -ForegroundColor Yellow
$drive = (Get-Location).Drive
$diskInfo = Get-PSDrive $drive.Name
$percentUsed = [math]::Round((($diskInfo.Used / ($diskInfo.Used + $diskInfo.Free)) * 100), 2)
if ($percentUsed -lt 90) {
    Write-Host "✅ Disk space OK ($percentUsed% used)" -ForegroundColor Green
} else {
    Write-Host "❌ Disk space critical ($percentUsed% used)" -ForegroundColor Red
}
Write-Host ""

# 8. Check Laravel logs for errors
Write-Host "8️⃣  Checking recent Laravel errors..." -ForegroundColor Yellow
$logPath = "storage/logs/laravel.log"
if (Test-Path $logPath) {
    $errors = Select-String -Path $logPath -Pattern "ERROR" -SimpleMatch
    if ($errors.Count -gt 0) {
        Write-Host "⚠️  Found $($errors.Count) errors in laravel.log" -ForegroundColor Yellow
        Write-Host "   Last 5 errors:" -ForegroundColor Yellow
        $errors | Select-Object -Last 5 | ForEach-Object { Write-Host "   $_" }
    } else {
        Write-Host "✅ No recent errors in laravel.log" -ForegroundColor Green
    }
} else {
    Write-Host "⚠️  laravel.log not found" -ForegroundColor Yellow
}
Write-Host ""

# Summary
Write-Host "==================================================" -ForegroundColor Cyan
Write-Host "📊 DIAGNOSTIC SUMMARY" -ForegroundColor Cyan
Write-Host "==================================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Next steps:" -ForegroundColor White
Write-Host "1. Review TRAFFIC-DROP-ANALYSIS.md for detailed analysis" -ForegroundColor White
Write-Host "2. Follow IMMEDIATE-RECOVERY-CHECKLIST.md step by step" -ForegroundColor White
Write-Host "3. Check Google Search Console for penalties/errors" -ForegroundColor White
Write-Host "4. Monitor recovery over next 7 days" -ForegroundColor White
Write-Host ""
Write-Host "Critical actions:" -ForegroundColor Yellow
Write-Host "- Add GA_TRACKING_ID to .env if missing" -ForegroundColor Yellow
Write-Host "- Submit sitemaps to Google Search Console" -ForegroundColor Yellow
Write-Host "- Request indexing for key pages" -ForegroundColor Yellow
Write-Host "- Clear all caches: php artisan cache:clear" -ForegroundColor Yellow
Write-Host ""
Write-Host "==================================================" -ForegroundColor Cyan
