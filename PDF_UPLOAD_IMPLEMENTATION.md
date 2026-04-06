# PDF Upload Feature for Job Posts

## Overview
Add ability to upload PDF files (like notification PDFs, syllabus PDFs, answer keys, etc.) to job posts. Users can download these PDFs from the post page.

## Implementation Details

### 1. Database Changes
**Migration needed**: Add `pdf_path` column to posts table

```sql
ALTER TABLE posts ADD COLUMN pdf_path VARCHAR(255) NULL AFTER content;
ALTER TABLE posts ADD COLUMN pdf_name VARCHAR(255) NULL AFTER pdf_path;
```

### 2. Model Changes
**File**: `app/Models/Post.php`

Add to `$fillable` array:
```php
'pdf_path', 'pdf_name'
```

### 3. Storage Configuration
**Location**: `storage/app/public/pdfs/`
- PDFs stored in public storage for direct download
- Organized by post type: `pdfs/jobs/`, `pdfs/admit_cards/`, etc.
- File naming: `{post_id}-{timestamp}.pdf`

### 4. Form Changes
**File**: `resources/views/admin/posts/form.blade.php`

Add new section in the form:
```html
<div class="pf-card">
    <div class="pf-section-title">
        <i class="fas fa-file-pdf"></i>
        PDF Upload (Optional)
    </div>
    
    <div class="pf-field">
        <label class="pf-label">Upload PDF</label>
        <input type="file" name="pdf" class="pf-input @error('pdf') error @enderror" 
               accept=".pdf" id="pdf-input">
        <span class="pf-hint">Max 10 MB. Accepted format: PDF only</span>
        @error('pdf')
        <span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
        @enderror
        
        @if(isset($post) && $post->pdf_path)
        <div style="margin-top: 12px; padding: 12px; background: #f0fdf4; border-radius: 6px; border-left: 3px solid #10b981;">
            <p style="font-size: 13px; color: #065f46; margin: 0;">
                <i class="fas fa-check-circle"></i> Current PDF: 
                <a href="{{ asset('storage/' . $post->pdf_path) }}" target="_blank" style="color: #059669; text-decoration: underline;">
                    {{ $post->pdf_name }}
                </a>
            </p>
            <label style="margin-top: 8px; display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 12px; color: #dc2626;">
                <input type="checkbox" name="delete_pdf" value="1"> Delete this PDF
            </label>
        </div>
        @endif
    </div>
</div>
```

### 5. Controller Changes
**File**: `app/Http/Controllers/Admin/PostController.php`

**In store() method**, add validation:
```php
'pdf' => 'nullable|file|mimes:pdf|max:10240', // 10MB
```

**In store() method**, add file handling:
```php
if ($request->hasFile('pdf')) {
    $pdf = $request->file('pdf');
    $filename = $post->id . '-' . time() . '.pdf';
    $path = $pdf->storeAs('pdfs/' . $post->type, $filename, 'public');
    
    $validated['pdf_path'] = $path;
    $validated['pdf_name'] = $pdf->getClientOriginalName();
}
```

**In update() method**, add similar logic:
```php
if ($request->hasFile('pdf')) {
    // Delete old PDF if exists
    if ($post->pdf_path && Storage::disk('public')->exists($post->pdf_path)) {
        Storage::disk('public')->delete($post->pdf_path);
    }
    
    $pdf = $request->file('pdf');
    $filename = $post->id . '-' . time() . '.pdf';
    $path = $pdf->storeAs('pdfs/' . $post->type, $filename, 'public');
    
    $post->pdf_path = $path;
    $post->pdf_name = $pdf->getClientOriginalName();
}

// Handle PDF deletion
if ($request->has('delete_pdf') && $request->delete_pdf) {
    if ($post->pdf_path && Storage::disk('public')->exists($post->pdf_path)) {
        Storage::disk('public')->delete($post->pdf_path);
    }
    $post->pdf_path = null;
    $post->pdf_name = null;
}

$post->save();
```

### 6. Frontend Display
**File**: `resources/views/posts/show.blade.php`

Add PDF download button:
```html
@if($post->pdf_path)
<div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="fas fa-file-pdf text-red-600 text-2xl"></i>
            <div>
                <p class="font-bold text-gray-900">{{ $post->pdf_name }}</p>
                <p class="text-sm text-gray-600">Official PDF Document</p>
            </div>
        </div>
        <a href="{{ asset('storage/' . $post->pdf_path) }}" 
           download="{{ $post->pdf_name }}"
           class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-bold flex items-center gap-2">
            <i class="fas fa-download"></i> Download PDF
        </a>
    </div>
</div>
@endif
```

### 7. API Response
**File**: `app/Http/Controllers/Api/PostApiController.php`

Add to post response:
```php
'pdf_url' => $post->pdf_path ? asset('storage/' . $post->pdf_path) : null,
'pdf_name' => $post->pdf_name,
```

## Security Considerations

1. **File Validation**: Only PDF files allowed, max 10MB
2. **Storage**: Files stored outside public web root initially, then symlinked
3. **Access Control**: Only admins can upload/delete PDFs
4. **Filename Sanitization**: Use post ID + timestamp to prevent conflicts
5. **Virus Scanning**: Optional - can add ClamAV integration later

## File Structure
```
storage/app/public/pdfs/
├── jobs/
│   ├── 1-1712345678.pdf
│   └── 2-1712345679.pdf
├── admit_cards/
│   └── 3-1712345680.pdf
├── results/
├── syllabus/
├── answer_keys/
└── blogs/
```

## Migration Command
```bash
php artisan make:migration add_pdf_to_posts_table
```

## Nginx Configuration
Add to `/etc/nginx/sites-available/jobone.in`:
```nginx
# Allow PDF downloads
location ~* ^/storage/pdfs/.*\.pdf$ {
    expires 30d;
    add_header Cache-Control "public, immutable";
    add_header Content-Disposition "attachment";
}
```

## Testing Checklist
- [ ] Upload PDF to new post
- [ ] Upload PDF to existing post
- [ ] Delete PDF from post
- [ ] Download PDF from frontend
- [ ] Check file permissions
- [ ] Verify file size limit (10MB)
- [ ] Test with invalid file types
- [ ] Check API response includes PDF URL
- [ ] Verify PDF is cached properly

## Benefits
✅ Users can download official documents directly
✅ Better user experience for job seekers
✅ Reduced external link dependencies
✅ Better SEO (PDFs indexed by search engines)
✅ Improved engagement and trust
✅ Easy management from admin panel

## Future Enhancements
- Multiple PDF uploads per post
- PDF preview in browser
- PDF text extraction for search
- Automatic PDF generation from content
- PDF analytics (download tracking)
