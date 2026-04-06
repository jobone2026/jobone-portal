# PDF View Options - How to Display PDFs Inside Page

## Option 1: Embed PDF with PDF.js (Best - Full Control)
**Pros**: Works everywhere, shows page numbers, zoom, search, print
**Cons**: Requires PDF.js library

```html
<div class="pdf-viewer-container" style="height: 600px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
    <div id="pdf-toolbar" style="background: #f5f5f5; padding: 10px; border-bottom: 1px solid #ddd; display: flex; gap: 10px; align-items: center;">
        <button id="prev-page" class="btn btn-sm btn-outline">← Previous</button>
        <span id="page-info" style="font-size: 14px; font-weight: bold;">Page <span id="current-page">1</span> of <span id="total-pages">0</span></span>
        <button id="next-page" class="btn btn-sm btn-outline">Next →</button>
        <button id="zoom-in" class="btn btn-sm btn-outline">🔍+</button>
        <button id="zoom-out" class="btn btn-sm btn-outline">🔍-</button>
        <a id="download-pdf" href="{{ asset('storage/' . $post->pdf_path) }}" download class="btn btn-sm btn-primary ml-auto">
            <i class="fas fa-download"></i> Download
        </a>
    </div>
    <div id="pdf-viewer" style="height: calc(100% - 50px); overflow: auto; background: #ccc; display: flex; justify-content: center; align-items: flex-start; padding: 10px;">
        <canvas id="pdf-canvas" style="border: 1px solid #999; background: white;"></canvas>
    </div>
</div>

<!-- PDF.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    const pdfUrl = "{{ asset('storage/' . $post->pdf_path) }}";
    let pdfDoc = null;
    let currentPage = 1;
    let scale = 1.5;

    // Initialize PDF.js
    pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
        pdfDoc = pdf;
        document.getElementById('total-pages').textContent = pdf.numPages;
        renderPage(currentPage);
    });

    function renderPage(pageNum) {
        pdfDoc.getPage(pageNum).then(page => {
            const canvas = document.getElementById('pdf-canvas');
            const ctx = canvas.getContext('2d');
            const viewport = page.getViewport({ scale: scale });

            canvas.width = viewport.width;
            canvas.height = viewport.height;

            page.render({
                canvasContext: ctx,
                viewport: viewport
            }).promise.then(() => {
                document.getElementById('current-page').textContent = pageNum;
            });
        });
    }

    document.getElementById('prev-page').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            renderPage(currentPage);
        }
    });

    document.getElementById('next-page').addEventListener('click', () => {
        if (currentPage < pdfDoc.numPages) {
            currentPage++;
            renderPage(currentPage);
        }
    });

    document.getElementById('zoom-in').addEventListener('click', () => {
        scale += 0.2;
        renderPage(currentPage);
    });

    document.getElementById('zoom-out').addEventListener('click', () => {
        if (scale > 0.5) {
            scale -= 0.2;
            renderPage(currentPage);
        }
    });
</script>
```

---

## Option 2: Embed PDF with iframe (Simplest)
**Pros**: Very simple, works in all browsers
**Cons**: Limited controls, depends on browser PDF viewer

```html
<div class="pdf-viewer-container" style="margin: 20px 0;">
    <div style="background: #f5f5f5; padding: 10px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0; font-size: 16px; font-weight: bold;">
            <i class="fas fa-file-pdf" style="color: #dc2626;"></i> 
            {{ $post->pdf_name }}
        </h3>
        <a href="{{ asset('storage/' . $post->pdf_path) }}" download class="btn btn-sm btn-primary">
            <i class="fas fa-download"></i> Download
        </a>
    </div>
    
    <iframe 
        src="{{ asset('storage/' . $post->pdf_path) }}" 
        style="width: 100%; height: 600px; border: 1px solid #ddd; border-radius: 0 0 8px 8px;"
        frameborder="0">
    </iframe>
</div>
```

---

## Option 3: Google Docs Viewer (Cloud-based)
**Pros**: Works everywhere, no library needed
**Cons**: Requires internet, privacy concerns, slower

```html
<div class="pdf-viewer-container" style="margin: 20px 0;">
    <div style="background: #f5f5f5; padding: 10px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0; font-size: 16px; font-weight: bold;">
            <i class="fas fa-file-pdf" style="color: #dc2626;"></i> 
            {{ $post->pdf_name }}
        </h3>
        <a href="{{ asset('storage/' . $post->pdf_path) }}" download class="btn btn-sm btn-primary">
            <i class="fas fa-download"></i> Download
        </a>
    </div>
    
    <iframe 
        src="https://docs.google.com/gview?url={{ urlencode(asset('storage/' . $post->pdf_path)) }}&embedded=true" 
        style="width: 100%; height: 600px; border: 1px solid #ddd; border-radius: 0 0 8px 8px;"
        frameborder="0">
    </iframe>
</div>
```

---

## Option 4: Tabs - View & Download
**Pros**: User choice, clean UI
**Cons**: Requires more code

```html
<div class="pdf-viewer-container" style="margin: 20px 0; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
    <!-- Tabs -->
    <div style="display: flex; background: #f5f5f5; border-bottom: 1px solid #ddd;">
        <button class="pdf-tab active" data-tab="view" style="flex: 1; padding: 12px; border: none; background: transparent; cursor: pointer; font-weight: bold; border-bottom: 3px solid #2563eb;">
            <i class="fas fa-eye"></i> View PDF
        </button>
        <button class="pdf-tab" data-tab="info" style="flex: 1; padding: 12px; border: none; background: transparent; cursor: pointer; font-weight: bold;">
            <i class="fas fa-info-circle"></i> Info
        </button>
    </div>

    <!-- View Tab -->
    <div id="view-tab" class="pdf-tab-content" style="display: block; height: 600px; overflow: auto;">
        <iframe 
            src="{{ asset('storage/' . $post->pdf_path) }}" 
            style="width: 100%; height: 100%; border: none;"
            frameborder="0">
        </iframe>
    </div>

    <!-- Info Tab -->
    <div id="info-tab" class="pdf-tab-content" style="display: none; padding: 20px;">
        <div style="background: #f0fdf4; padding: 15px; border-radius: 8px; border-left: 4px solid #10b981;">
            <p style="margin: 0 0 10px 0;"><strong>File Name:</strong> {{ $post->pdf_name }}</p>
            <p style="margin: 0 0 10px 0;"><strong>File Size:</strong> <span id="file-size">Loading...</span></p>
            <p style="margin: 0 0 10px 0;"><strong>Uploaded:</strong> {{ $post->created_at->format('d M Y') }}</p>
            <a href="{{ asset('storage/' . $post->pdf_path) }}" download class="btn btn-primary" style="margin-top: 10px;">
                <i class="fas fa-download"></i> Download PDF
            </a>
        </div>
    </div>
</div>

<script>
    // Tab switching
    document.querySelectorAll('.pdf-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const tabName = this.dataset.tab;
            
            // Hide all tabs
            document.querySelectorAll('.pdf-tab-content').forEach(content => {
                content.style.display = 'none';
            });
            
            // Remove active class
            document.querySelectorAll('.pdf-tab').forEach(t => {
                t.style.borderBottom = 'none';
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').style.display = 'block';
            this.style.borderBottom = '3px solid #2563eb';
        });
    });

    // Get file size
    fetch("{{ asset('storage/' . $post->pdf_path) }}", { method: 'HEAD' })
        .then(response => {
            const size = response.headers.get('content-length');
            const sizeInMB = (size / (1024 * 1024)).toFixed(2);
            document.getElementById('file-size').textContent = sizeInMB + ' MB';
        });
</script>
```

---

## Option 5: Modal Popup (Lightbox)
**Pros**: Doesn't take page space, clean design
**Cons**: Requires modal library

```html
<!-- Button to open PDF -->
<button class="btn btn-primary" onclick="openPdfModal()">
    <i class="fas fa-eye"></i> View PDF
</button>

<!-- Modal -->
<div id="pdf-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; padding: 20px;">
    <div style="background: white; border-radius: 8px; height: 100%; display: flex; flex-direction: column; max-width: 1000px; margin: 0 auto;">
        <!-- Header -->
        <div style="padding: 15px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0;">{{ $post->pdf_name }}</h3>
            <button onclick="closePdfModal()" style="background: none; border: none; font-size: 24px; cursor: pointer;">×</button>
        </div>
        
        <!-- PDF Viewer -->
        <div style="flex: 1; overflow: auto;">
            <iframe 
                src="{{ asset('storage/' . $post->pdf_path) }}" 
                style="width: 100%; height: 100%; border: none;"
                frameborder="0">
            </iframe>
        </div>
        
        <!-- Footer -->
        <div style="padding: 15px; border-top: 1px solid #ddd; display: flex; gap: 10px;">
            <a href="{{ asset('storage/' . $post->pdf_path) }}" download class="btn btn-primary">
                <i class="fas fa-download"></i> Download
            </a>
            <button onclick="closePdfModal()" class="btn btn-outline">Close</button>
        </div>
    </div>
</div>

<script>
    function openPdfModal() {
        document.getElementById('pdf-modal').style.display = 'flex';
    }
    
    function closePdfModal() {
        document.getElementById('pdf-modal').style.display = 'none';
    }
    
    // Close on background click
    document.getElementById('pdf-modal').addEventListener('click', function(e) {
        if (e.target === this) closePdfModal();
    });
</script>
```

---

## Comparison Table

| Option | Ease | Features | Performance | Browser Support |
|--------|------|----------|-------------|-----------------|
| **PDF.js** | Medium | ⭐⭐⭐⭐⭐ | Fast | Excellent |
| **iframe** | Easy | ⭐⭐ | Fast | Excellent |
| **Google Docs** | Easy | ⭐⭐⭐ | Slow | Excellent |
| **Tabs** | Medium | ⭐⭐⭐ | Fast | Excellent |
| **Modal** | Medium | ⭐⭐⭐ | Fast | Excellent |

---

## Recommendation

**For your job portal, I recommend Option 1 (PDF.js)** because:
- ✅ Full control over UI
- ✅ Works offline
- ✅ Professional appearance
- ✅ Page navigation
- ✅ Zoom controls
- ✅ Print support
- ✅ No privacy concerns

**Or Option 2 (iframe)** if you want simplicity:
- ✅ Easiest to implement
- ✅ Works in all browsers
- ✅ Uses browser's native PDF viewer

Which option do you prefer? I'll implement it for you!
