# How to Add HTML Content in Admin Post Editor

## Current Setup
The admin post editor uses a plain textarea that accepts HTML content. The content is stored as-is in the database and rendered on the frontend.

## Steps to Add HTML Content:

### 1. Prepare Your HTML
- Make sure your HTML is valid and complete
- Remove any `<!DOCTYPE>`, `<html>`, `<head>`, and `<body>` tags
- Keep only the content that should appear in the post body

### 2. Paste in Content Field
- Go to Admin > Posts > Create/Edit Post
- In the "Content" textarea, paste your HTML
- The HTML will be stored exactly as you paste it

### 3. Important Notes:
- **DO NOT** include `<!DOCTYPE html>`, `<html>`, `<head>`, or `<body>` tags
- **DO** include all your CSS in `<style>` tags within the content
- **DO** wrap everything in a container div with a unique ID (e.g., `<div id="upsi-wrap">`)
- **DO** use scoped CSS to avoid conflicts with site styles

## Example Structure:

```html
<style>
#my-post-wrap {
    /* Your scoped styles here */
    font-family: Arial, sans-serif;
}
#my-post-wrap h1 {
    color: #333;
}
</style>

<div id="my-post-wrap">
    <h1>Your Title</h1>
    <p>Your content here...</p>
    <!-- Rest of your HTML -->
</div>
```

## Best Practices:

1. **Use Unique IDs**: Always wrap your content in a div with a unique ID
2. **Scope Your CSS**: Prefix all CSS selectors with your container ID
3. **Test First**: Test your HTML in a separate file before pasting
4. **Minify**: Remove unnecessary whitespace to reduce size
5. **Validate**: Use an HTML validator to check for errors

## Troubleshooting:

### If HTML appears as text:
- Check if you're viewing the post on the frontend
- The admin preview might show escaped HTML
- View the actual post page to see rendered HTML

### If styles don't work:
- Make sure all CSS is scoped with your container ID
- Check for CSS conflicts with site styles
- Use more specific selectors if needed

### If content is cut off:
- Check database field length limits
- Content field is `longText` type (supports large content)
- If still having issues, check server upload limits

## Current Database Limits:
- `content`: longText (4GB max)
- `meta_title`: 60 characters
- `meta_description`: 160 characters  
- `meta_keywords`: 500 characters

## Need Help?
If you're still having issues, check the Laravel logs at:
`storage/logs/laravel.log`
