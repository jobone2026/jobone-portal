<style>
:root{--white:#fff;--off:#f9fafb;--surface:#f3f4f6;--border:#e5e7eb;--t1:#111827;--t2:#6b7280;--t3:#9ca3af;--blue:#2563eb;--blue-h:#1d4ed8;--blue-l:#eff6ff;--blue-b:#bfdbfe;--green:#059669;--green-l:#ecfdf5;--amber:#d97706;--amber-l:#fffbeb;--red:#dc2626;--red-l:#fef2f2;--purple:#7c3aed;--purple-l:#f5f3ff;--r:10px;--rs:6px;--sh0:0 1px 3px rgba(0,0,0,.05);}
.pf-wrap{max-width:1100px;margin:0 auto;}
.pf-header{background:var(--white);border:1px solid var(--border);border-radius:var(--r);padding:18px 22px;margin-bottom:18px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;box-shadow:var(--sh0);}
.pf-h-left{display:flex;align-items:center;gap:13px;}
.pf-h-icon{width:42px;height:42px;background:var(--blue-l);border-radius:var(--rs);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.pf-h-icon i{color:var(--blue);font-size:18px;}
.pf-h-title{font-size:19px;font-weight:800;color:var(--t1);}
.pf-h-sub{font-size:12.5px;color:var(--t3);margin-top:1px;}
.pf-error-box{background:var(--red-l);border-left:3px solid var(--red);padding:14px 16px;border-radius:var(--rs);margin-bottom:18px;}
.pf-error-title{font-size:13px;font-weight:700;color:var(--red);margin-bottom:6px;display:flex;align-items:center;gap:6px;}
.pf-error-list{list-style:disc;margin-left:20px;font-size:12px;color:#991b1b;}
.pf-seo-card{background:var(--white);border:1px solid var(--border);border-radius:var(--r);padding:18px;margin-bottom:18px;box-shadow:var(--sh0);}
.pf-seo-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;}
.pf-seo-title{font-size:15px;font-weight:700;color:var(--t1);display:flex;align-items:center;gap:8px;}
.pf-seo-score{font-size:28px;font-weight:800;}
.pf-seo-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:10px;}
.pf-seo-item{background:var(--off);border:1px solid var(--border);border-radius:var(--rs);padding:10px 12px;}
.pf-seo-item-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;}
.pf-seo-item-label{font-size:12px;font-weight:600;color:var(--t2);}
.pf-seo-dot{width:8px;height:8px;border-radius:50%;}
.pf-seo-item-val{font-size:11px;color:var(--t3);}
.pf-card{background:var(--white);border:1px solid var(--border);border-radius:var(--r);padding:20px;margin-bottom:18px;box-shadow:var(--sh0);}
.pf-section-title{font-size:14px;font-weight:700;color:var(--t1);margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;}
.pf-field{margin-bottom:16px;position:relative;}
.pf-field:last-child{margin-bottom:0;}
.pf-field.has-error .pf-input,
.pf-field.has-error .pf-select,
.pf-field.has-error .pf-textarea{border-color:var(--red);background:#fef2f2;}
.pf-field.has-success .pf-input,
.pf-field.has-success .pf-select,
.pf-field.has-success .pf-textarea{border-color:var(--green);background:#f0fdf4;}
.pf-field-icon{position:absolute;right:12px;top:34px;font-size:14px;}
.pf-field-icon.success{color:var(--green);}
.pf-field-icon.error{color:var(--red);}
.pf-label{font-size:13px;font-weight:600;color:var(--t1);margin-bottom:6px;display:block;}
.pf-label .req{color:var(--red);}
.pf-hint{font-size:11.5px;color:var(--t3);margin-top:4px;display:block;}
.pf-input,.pf-select,.pf-textarea{padding:9px 12px;background:var(--off);border:1px solid var(--border);border-radius:var(--rs);font-size:13.5px;font-family:inherit;color:var(--t1);outline:none;transition:all .15s;width:100%;}
.pf-input:focus,.pf-select:focus,.pf-textarea:focus{background:var(--white);border-color:var(--blue-b);box-shadow:0 0 0 3px rgba(37,99,235,.08);}
.pf-input.error,.pf-select.error,.pf-textarea.error{border-color:var(--red);}
.pf-textarea{resize:vertical;min-height:200px;font-family:monospace;font-size:12.5px;line-height:1.6;}
.pf-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.pf-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;}
@media(max-width:768px){.pf-grid-2,.pf-grid-3{grid-template-columns:1fr;}}
.pf-checkbox-wrap{display:flex;align-items:center;gap:10px;padding:12px;background:var(--off);border:1px solid var(--border);border-radius:var(--rs);}
.pf-checkbox{width:18px;height:18px;accent-color:var(--blue);}
.pf-checkbox-label{font-size:13px;font-weight:600;color:var(--t1);}
.pf-actions{display:flex;gap:10px;padding-top:20px;border-top:1px solid var(--border);}
.pf-btn{display:inline-flex;align-items:center;gap:7px;padding:11px 20px;border-radius:var(--rs);font-size:13.5px;font-weight:600;text-decoration:none;cursor:pointer;border:none;transition:all .15s;font-family:inherit;justify-content:center;}
.pf-btn-primary{background:var(--blue);color:#fff;box-shadow:0 1px 5px rgba(37,99,235,.3);flex:1;}
.pf-btn-primary:hover{background:var(--blue-h);transform:translateY(-1px);}
.pf-btn-outline{background:var(--white);color:var(--t2);border:1px solid var(--border);}
.pf-btn-outline:hover{background:var(--off);}
.pf-error-msg{color:var(--red);font-size:11.5px;margin-top:4px;display:flex;align-items:center;gap:4px;}
</style>

<div class="pf-wrap" x-data="seoAnalyzer()">

<div class="pf-header">
<div class="pf-h-left">
<div class="pf-h-icon"><i class="fas fa-pen"></i></div>
<div>
<div class="pf-h-title">{{ isset($post) ? 'Edit Post' : 'Create New Post' }}</div>
<div class="pf-h-sub">Fill in the details below to publish your content</div>
</div>
</div>
</div>

@if ($errors->any())
<div class="pf-error-box">
<div class="pf-error-title">
<i class="fas fa-exclamation-circle"></i>
Please fix the following errors:
</div>
<ul class="pf-error-list">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<div class="pf-seo-card">
<div class="pf-seo-head">
<div class="pf-seo-title">
<i class="fas fa-chart-line"></i>
SEO Score
</div>
<div class="pf-seo-score" :class="scoreColor">
<span x-text="totalScore"></span>/100
</div>
</div>
<div class="pf-seo-grid">
<div class="pf-seo-item">
<div class="pf-seo-item-head">
<span class="pf-seo-item-label">Title</span>
<div class="pf-seo-dot" :class="titleLengthColor"></div>
</div>
<div class="pf-seo-item-val"><span x-text="titleLength"></span>/60</div>
</div>
<div class="pf-seo-item">
<div class="pf-seo-item-head">
<span class="pf-seo-item-label">Description</span>
<div class="pf-seo-dot" :class="descLengthColor"></div>
</div>
<div class="pf-seo-item-val"><span x-text="descLength"></span>/160</div>
</div>
<div class="pf-seo-item">
<div class="pf-seo-item-head">
<span class="pf-seo-item-label">Keyword in Title</span>
<div class="pf-seo-dot" :class="keywordInTitleColor"></div>
</div>
<div class="pf-seo-item-val">Check</div>
</div>
<div class="pf-seo-item">
<div class="pf-seo-item-head">
<span class="pf-seo-item-label">Keyword in Desc</span>
<div class="pf-seo-dot" :class="keywordInDescColor"></div>
</div>
<div class="pf-seo-item-val">Check</div>
</div>
<div class="pf-seo-item">
<div class="pf-seo-item-head">
<span class="pf-seo-item-label">Word Count</span>
<div class="pf-seo-dot" :class="wordCountColor"></div>
</div>
<div class="pf-seo-item-val"><span x-text="wordCount"></span> words</div>
</div>
<div class="pf-seo-item">
<div class="pf-seo-item-head">
<span class="pf-seo-item-label">Internal Links</span>
<div class="pf-seo-dot" :class="linksCountColor"></div>
</div>
<div class="pf-seo-item-val"><span x-text="linksCount"></span> links</div>
</div>
</div>
</div>

<div class="pf-card">
<div class="pf-section-title">
<i class="fas fa-file-alt"></i>
Basic Information
</div>

<div class="pf-field" x-data="{ valid: false, touched: false }" :class="{ 'has-error': touched && !valid && title.length > 0, 'has-success': valid }">
<label class="pf-label">Title <span class="req">*</span></label>
<input type="text" name="title" class="pf-input @error('title') error @enderror" 
value="{{ old('title', $post->title ?? '') }}" required
x-model="title" @input="analyze(); touched = true; valid = title.length >= 10 && title.length <= 100" @blur="touched = true">
<template x-if="valid">
<i class="fas fa-check-circle pf-field-icon success"></i>
</template>
<template x-if="touched && !valid && title.length > 0">
<i class="fas fa-exclamation-circle pf-field-icon error"></i>
</template>
@error('title')
<span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
@enderror
<template x-if="touched && !valid && title.length > 0">
<span class="pf-hint" style="color:var(--red);" x-text="title.length < 10 ? 'Title must be at least 10 characters' : 'Title is too long (max 100 characters)'"></span>
</template>
</div>

<div class="pf-grid-3">
<div class="pf-field">
<label class="pf-label">Type <span class="req">*</span></label>
<select name="type" class="pf-select @error('type') error @enderror" required>
<option value="">Select Type</option>
<option value="job" {{ old('type', $post->type ?? '') === 'job' ? 'selected' : '' }}>Job</option>
<option value="admit_card" {{ old('type', $post->type ?? '') === 'admit_card' ? 'selected' : '' }}>Admit Card</option>
<option value="syllabus" {{ old('type', $post->type ?? '') === 'syllabus' ? 'selected' : '' }}>Syllabus</option>
<option value="result" {{ old('type', $post->type ?? '') === 'result' ? 'selected' : '' }}>Result</option>
<option value="answer_key" {{ old('type', $post->type ?? '') === 'answer_key' ? 'selected' : '' }}>Answer Key</option>
<option value="blog" {{ old('type', $post->type ?? '') === 'blog' ? 'selected' : '' }}>Blog</option>
</select>
@error('type')
<span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
@enderror
</div>

<div class="pf-field">
<label class="pf-label">Category <span class="req">*</span></label>
<select name="category_id" class="pf-select @error('category_id') error @enderror" required>
<option value="">Select Category</option>
@foreach ($categories as $category)
<option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
@endforeach
</select>
@error('category_id')
<span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
@enderror
</div>

<div class="pf-field">
<label class="pf-label">State</label>
<select name="state_id" class="pf-select @error('state_id') error @enderror">
<option value="">Select State</option>
@foreach ($states as $state)
<option value="{{ $state->id }}" {{ old('state_id', $post->state_id ?? '') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
@endforeach
</select>
@error('state_id')
<span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
@enderror
</div>

<div class="pf-field">
<label class="pf-label">Organization</label>
<input type="text" name="organization" class="pf-input @error('organization') error @enderror"
value="{{ old('organization', $post->organization ?? '') }}"
placeholder="e.g., SSC, UPSC, Indian Railways">
<span class="pf-hint">Name of the recruiting organization</span>
@error('organization')
<span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
@enderror
</div>
</div>

<div class="pf-grid-3">
<div class="pf-field">
<label class="pf-label">Total Vacancies</label>
<input type="number" name="total_posts" class="pf-input @error('total_posts') error @enderror"
value="{{ old('total_posts', $post->total_posts ?? '') }}"
placeholder="e.g., 500" min="1">
<span class="pf-hint">Number of available positions</span>
@error('total_posts')
<span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
@enderror
</div>

<div class="pf-field">
<label class="pf-label">Notification Date</label>
<input type="date" name="notification_date" class="pf-input @error('notification_date') error @enderror"
value="{{ old('notification_date', isset($post->notification_date) ? $post->notification_date->format('Y-m-d') : '') }}">
<span class="pf-hint">When notification was released</span>
@error('notification_date')
<span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
@enderror
</div>

<div class="pf-field">
<label class="pf-label">Last Date</label>
<input type="date" name="last_date" class="pf-input @error('last_date') error @enderror"
value="{{ old('last_date', isset($post->last_date) ? $post->last_date->format('Y-m-d') : '') }}">
<span class="pf-hint">Application deadline</span>
@error('last_date')
<span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
@enderror
</div>
</div>

<div class="pf-field" x-data="{ valid: false, touched: false }" :class="{ 'has-error': touched && !valid && content.length > 0, 'has-success': valid }">
<label class="pf-label">Content <span class="req">*</span></label>
<textarea name="content" class="pf-textarea @error('content') error @enderror" required
x-model="content" @input="analyze(); touched = true; valid = content.length >= 50" @blur="touched = true">{!! old('content', $post->content ?? '') !!}</textarea>
<span class="pf-hint">You can paste HTML content here. It will be preserved exactly as entered.</span>
@error('content')
<span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
@enderror
<template x-if="touched && !valid && content.length > 0">
<span class="pf-hint" style="color:var(--red);">Content must be at least 50 characters (currently <span x-text="content.length"></span>)</span>
</template>
</div>
</div>

<div class="pf-card">
<div class="pf-section-title">
<i class="fas fa-search"></i>
SEO & Meta Tags
</div>

<div class="pf-grid-2">
<div class="pf-field">
<label class="pf-label">Meta Title</label>
<input type="text" name="meta_title" maxlength="60" class="pf-input @error('meta_title') error @enderror"
value="{{ old('meta_title', $post->meta_title ?? '') }}"
x-model="metaTitle" @input="analyze()">
<span class="pf-hint">Recommended: 50-60 characters</span>
@error('meta_title')
<span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
@enderror
</div>

<div class="pf-field">
<label class="pf-label">Meta Description</label>
<input type="text" name="meta_description" maxlength="160" class="pf-input @error('meta_description') error @enderror"
value="{{ old('meta_description', $post->meta_description ?? '') }}"
x-model="metaDescription" @input="analyze()">
<span class="pf-hint">Recommended: 120-160 characters</span>
@error('meta_description')
<span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
@enderror
</div>
</div>

<div class="pf-field">
<label class="pf-label">Meta Keywords</label>
<input type="text" name="meta_keywords" maxlength="1000" class="pf-input @error('meta_keywords') error @enderror"
value="{{ old('meta_keywords', $post->meta_keywords ?? '') }}"
x-model="metaKeywords" @input="analyze()">
<span class="pf-hint">Separate keywords with commas. Max 1000 characters (<span x-text="metaKeywords.length"></span>/1000)</span>
@error('meta_keywords')
<span class="pf-error-msg"><i class="fas fa-exclamation-circle"></i>{{ $message }}</span>
@enderror
</div>
</div>

<div class="pf-card">
<div class="pf-section-title">
<i class="fas fa-cog"></i>
Publishing Options
</div>

<div class="pf-grid-2">
<div class="pf-checkbox-wrap">
<input type="checkbox" name="is_featured" value="1" class="pf-checkbox" id="is_featured"
{{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}>
<label for="is_featured" class="pf-checkbox-label">Featured Post</label>
</div>

<div class="pf-checkbox-wrap">
<input type="checkbox" name="is_published" value="1" class="pf-checkbox" id="is_published"
{{ old('is_published', $post->is_published ?? false) ? 'checked' : '' }}>
<label for="is_published" class="pf-checkbox-label">Published</label>
</div>
</div>

<div class="pf-actions">
<button type="submit" class="pf-btn pf-btn-primary">
<i class="fas fa-save"></i>
{{ isset($post) ? 'Update Post' : 'Create Post' }}
</button>
<a href="{{ route('admin.posts.index') }}" class="pf-btn pf-btn-outline">
<i class="fas fa-times"></i>
Cancel
</a>
</div>
</div>

</div>

<script>
function seoAnalyzer() {
return {
title: '{{ old('title', $post->title ?? '') }}',
content: {!! json_encode(old('content', $post->content ?? '')) !!},
metaTitle: '{{ old('meta_title', $post->meta_title ?? '') }}',
metaDescription: '{{ old('meta_description', $post->meta_description ?? '') }}',
metaKeywords: '{{ old('meta_keywords', $post->meta_keywords ?? '') }}',
titleLength: 0,
descLength: 0,
wordCount: 0,
linksCount: 0,
totalScore: 0,
titleLengthColor: 'bg-gray-400',
descLengthColor: 'bg-gray-400',
keywordInTitleColor: 'bg-gray-400',
keywordInDescColor: 'bg-gray-400',
wordCountColor: 'bg-gray-400',
linksCountColor: 'bg-gray-400',
scoreColor: 'text-gray-600',
init() {
this.analyze();
},
analyze() {
this.$nextTick(() => {
this.analyzeTitleLength();
this.analyzeDescLength();
this.analyzeKeywordInTitle();
this.analyzeKeywordInDesc();
this.analyzeWordCount();
this.analyzeLinksCount();
this.calculateTotalScore();
});
},
analyzeTitleLength() {
const effectiveTitle = this.metaTitle || this.title;
this.titleLength = effectiveTitle.length;
if (this.titleLength >= 50 && this.titleLength <= 60) {
this.titleLengthColor = 'bg-green-500';
} else if (this.titleLength >= 40 && this.titleLength < 50) {
this.titleLengthColor = 'bg-yellow-500';
} else if (this.titleLength > 60) {
this.titleLengthColor = 'bg-red-500';
} else {
this.titleLengthColor = 'bg-red-500';
}
},
analyzeDescLength() {
this.descLength = this.metaDescription.length;
if (this.descLength >= 120 && this.descLength <= 160) {
this.descLengthColor = 'bg-green-500';
} else if (this.descLength >= 80 && this.descLength < 120) {
this.descLengthColor = 'bg-yellow-500';
} else if (this.descLength > 160) {
this.descLengthColor = 'bg-red-500';
} else if (this.descLength > 0) {
this.descLengthColor = 'bg-yellow-500';
} else {
this.descLengthColor = 'bg-red-500';
}
},
analyzeKeywordInTitle() {
const keywords = this.extractKeywords();
const effectiveTitle = (this.metaTitle || this.title).toLowerCase();
const found = keywords.some(kw => effectiveTitle.includes(kw.toLowerCase()));
this.keywordInTitleColor = found ? 'bg-green-500' : 'bg-red-500';
},
analyzeKeywordInDesc() {
const keywords = this.extractKeywords();
const desc = this.metaDescription.toLowerCase();
const found = keywords.some(kw => desc.includes(kw.toLowerCase()));
if (found) {
this.keywordInDescColor = 'bg-green-500';
} else if (desc.length === 0) {
this.keywordInDescColor = 'bg-gray-400';
} else {
this.keywordInDescColor = 'bg-yellow-500';
}
},
analyzeWordCount() {
const text = this.stripHtml(this.content);
const words = text.trim().split(/\s+/).filter(w => w.length > 0);
this.wordCount = words.length;
if (this.wordCount >= 300) {
this.wordCountColor = 'bg-green-500';
} else if (this.wordCount >= 150) {
this.wordCountColor = 'bg-yellow-500';
} else if (this.wordCount > 0) {
this.wordCountColor = 'bg-red-500';
} else {
this.wordCountColor = 'bg-red-500';
}
},
analyzeLinksCount() {
const linkMatches = this.content.match(/<a\s+[^>]*href=["'][^"']*["'][^>]*>/gi) || [];
this.linksCount = linkMatches.length;
if (this.linksCount >= 2) {
this.linksCountColor = 'bg-green-500';
} else if (this.linksCount === 1) {
this.linksCountColor = 'bg-yellow-500';
} else {
this.linksCountColor = 'bg-red-500';
}
},
calculateTotalScore() {
let score = 0;
if (this.titleLength >= 50 && this.titleLength <= 60) score += 20;
else if (this.titleLength >= 40 && this.titleLength < 50) score += 15;
else if (this.titleLength > 0) score += 5;
if (this.descLength >= 120 && this.descLength <= 160) score += 20;
else if (this.descLength >= 80 && this.descLength < 120) score += 15;
else if (this.descLength > 0) score += 5;
if (this.keywordInTitleColor === 'bg-green-500') score += 20;
if (this.keywordInDescColor === 'bg-green-500') score += 15;
if (this.wordCount >= 300) score += 15;
else if (this.wordCount >= 150) score += 10;
else if (this.wordCount > 0) score += 5;
if (this.linksCount >= 2) score += 10;
else if (this.linksCount === 1) score += 5;
this.totalScore = score;
if (score >= 80) {
this.scoreColor = 'text-green-600';
} else if (score >= 60) {
this.scoreColor = 'text-yellow-600';
} else {
this.scoreColor = 'text-red-600';
}
},
extractKeywords() {
if (!this.metaKeywords) return [];
return this.metaKeywords.split(',').map(k => k.trim()).filter(k => k.length > 0);
},
stripHtml(html) {
const tmp = document.createElement('div');
tmp.innerHTML = html;
return tmp.textContent || tmp.innerText || '';
}
};
}
</script>
