# Domain-Based State Filtering

This feature allows you to automatically filter all content to a specific state based on the domain name. This is useful when you have multiple domains pointing to the same application but want each domain to show only content for a specific state.

## Configuration

### Environment Setup

Add the following to your `.env` file:

```env
DOMAIN_STATE_MAP=karnatakajob.online:karnataka,www.karnatakajob.online:karnataka
```

Format: `domain1:state_slug1,domain2:state_slug2`

### Example Configurations

**Single domain for Karnataka:**
```env
DOMAIN_STATE_MAP=karnatakajob.online:karnataka
```

**Multiple domains:**
```env
DOMAIN_STATE_MAP=karnatakajob.online:karnataka,maharashtrajobs.com:maharashtra,delhijobs.in:delhi
```

## How It Works

1. The `DomainStateFilter` middleware intercepts all incoming requests
2. It checks the request domain against the `DOMAIN_STATE_MAP` configuration
3. If a match is found, it sets the state filter globally for that request
4. All controllers automatically filter posts by the configured state

## Affected Areas

When domain filtering is active, the following areas will only show content for the specified state:

- **Homepage** - All sections (jobs, admit cards, results, etc.)
- **Post Listings** - Jobs, admit cards, results, answer keys, syllabus, blogs
- **Category Pages** - Only posts from the filtered state
- **Search Results** - Only posts from the filtered state
- **Load More** - Pagination respects the state filter

## Example Usage

### karnatakajob.online
- Shows ONLY Karnataka jobs, results, admit cards, etc.
- All pages automatically filtered to Karnataka state
- Users cannot see posts from other states

### jobone.in
- Shows ALL posts from ALL states (no filtering)
- Normal multi-state operation

### jobone.in/state/karnataka
- Shows Karnataka posts via URL routing (existing functionality)
- Different from domain filtering

## Database Requirements

Make sure the Karnataka state exists in your database:

```sql
INSERT INTO states (name, slug, created_at, updated_at) 
VALUES ('Karnataka', 'karnataka', NOW(), NOW());
```

## Testing

1. Update your hosts file to test locally:
   ```
   127.0.0.1 karnatakajob.online
   ```

2. Access `http://karnatakajob.online:8000` - should show only Karnataka posts

3. Access `http://localhost:8000` - should show all posts

## Cache Considerations

The system uses separate cache keys for domain-filtered content:
- Normal cache: `home_sections`
- Karnataka domain cache: `home_sections_state_{state_id}`

This ensures filtered and non-filtered content don't conflict.

## API Integration

The API endpoints are not affected by domain filtering. External systems should use the `state_id` query parameter:

```bash
# Get Karnataka jobs via API
curl -H "Authorization: Bearer YOUR_TOKEN" \
  "https://jobone.in/api/posts?type=job&state_id=1"
```

## Deployment

After updating `.env` on the server:

1. Clear configuration cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

2. Restart PHP-FPM:
   ```bash
   sudo systemctl restart php8.2-fpm
   ```

3. Verify the domain is pointing to your server in DNS settings

## Troubleshooting

**Issue:** Domain filtering not working
- Check `.env` has correct `DOMAIN_STATE_MAP` format
- Verify state slug exists in database
- Clear config cache: `php artisan config:clear`
- Check middleware is registered in `bootstrap/app.php`

**Issue:** Wrong state being filtered
- Verify domain spelling in `DOMAIN_STATE_MAP`
- Check state slug matches database exactly (case-sensitive)
- Clear cache: `php artisan cache:clear`
