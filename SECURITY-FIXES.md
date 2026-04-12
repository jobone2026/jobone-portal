# Security Fixes Applied

## Date: April 12, 2026

### Issues Fixed

#### 1. HIGH: API Sensitive Data Exposure (10 issues) ✅ FIXED
**Problem:** API endpoints were returning full database models exposing sensitive fields like `admin_id`, internal timestamps, etc.

**Solution:**
- Created `PostResource` class to filter API responses
- Only returns necessary public fields
- Hides sensitive internal data like `admin_id`
- Applied to all API endpoints in `PostApiController`

**Files Changed:**
- `app/Http/Resources/PostResource.php` (new)
- `app/Http/Controllers/Api/PostApiController.php`

---

#### 2. HIGH: Sensitive Data in Logs ✅ FIXED
**Problem:** `TestModalApi` command was logging full API tokens

**Solution:**
- Masked token to show only first 8 characters
- Changed from: `Token ID: sk_live_abc123...`
- Changed to: `Token ID: sk_live_...`

**Files Changed:**
- `app/Console/Commands/TestModalApi.php`

---

#### 3. HIGH: Plaintext Sensitive Storage ⚠️ BY DESIGN
**Problem:** IndexNow API key stored in plaintext public file

**Explanation:**
- This is REQUIRED by IndexNow API specification
- The key file MUST be publicly accessible for domain verification
- This is not a security vulnerability - it's by design
- Added clarifying comments to code

**Files Changed:**
- `app/Services/IndexNowService.php` (added comments)

---

#### 4. CRITICAL: Vulnerable NPM Packages ✅ FIXED
**Problem:** 
- axios@1.13.6 had CVE-2026-40175 (Critical, CVSS 10.0)
- vite@7.3.1 had multiple CVEs

**Solution:**
- Updated axios from 1.13.6 to 1.15.0
- Updated vite from 7.3.1 to 7.3.2

**Files Changed:**
- `package.json`

**Action Required:**
Run `npm install` to update packages

---

#### 5. Medium/Low: Other Package Vulnerabilities
**Packages to Update (when available):**
- picomatch: 2.3.1 → 2.3.2
- firebase/php-jwt: 6.11.1 → 7.0.0
- google/protobuf: 4.33.5 → 4.33.6
- league/commonmark: 2.8.1 → 2.8.2

**Note:** These are dependency packages. Update when Laravel framework updates them.

---

#### 6. Secrets Detection (3 Medium) ⚠️ FALSE POSITIVES
**Files Flagged:**
- `google-services.json` - Firebase config (public, not secret)
- `public/firebase-messaging-sw.js` - Firebase public key (not secret)
- `public/js/firebase-init.js` - Firebase public key (not secret)

**Explanation:**
- These are Firebase PUBLIC keys, not secrets
- They are meant to be public and included in client-side code
- No action needed

---

## Summary

### Fixed:
✅ API sensitive data exposure (10 HIGH issues)
✅ Sensitive data logging (1 HIGH issue)
✅ Critical npm vulnerabilities (2 CRITICAL issues)

### By Design (Not Issues):
⚠️ IndexNow plaintext storage (required by API)
⚠️ Firebase public keys (meant to be public)

### Pending (Dependencies):
⏳ Minor package updates (waiting for Laravel framework updates)

---

## Next Steps

1. Run `npm install` to update axios and vite
2. Test API endpoints to ensure resource filtering works
3. Monitor for updates to dependency packages
4. Re-run security scan to verify fixes

---

## Deployment

All code changes have been:
- ✅ Committed to git
- ✅ Pushed to repository
- ⏳ Ready to deploy to production

To deploy:
```bash
# Upload files
scp -i .ssh/jobone2026.pem app/Http/Resources/PostResource.php ubuntu@3.108.161.67:/tmp/
scp -i .ssh/jobone2026.pem app/Http/Controllers/Api/PostApiController.php ubuntu@3.108.161.67:/tmp/

# SSH and move files
ssh -i .ssh/jobone2026.pem ubuntu@3.108.161.67
sudo mv /tmp/PostResource.php /var/www/jobone/app/Http/Resources/
sudo mv /tmp/PostApiController.php /var/www/jobone/app/Http/Controllers/Api/
sudo chown -R www-data:www-data /var/www/jobone/app
cd /var/www/jobone
sudo -u www-data php artisan optimize:clear
sudo systemctl restart php8.2-fpm
```
