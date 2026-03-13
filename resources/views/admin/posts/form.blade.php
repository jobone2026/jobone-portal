<div class="bg-white rounded-lg shadow-md p-6" x-data="seoAnalyzer()">
    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <h3 class="text-red-800 font-bold">Please fix the following errors:</h3>
            </div>
            <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- SEO Analyzer Panel -->
    <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-chart-line text-blue-600"></i>
                SEO Score Analyzer
            </h3>
            <div class="text-2xl font-bold" :class="scoreColor">
                <span x-text="totalScore"></span>/100
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Title Length -->
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-gray-700">Title Length</span>
                    <div class="w-3 h-3 rounded-full" :class="titleLengthColor"></div>
                </div>
                <div class="text-xs text-gray-600">
                    <span x-text="titleLength"></span> / 60 chars
                </div>
                <div class="text-xs mt-1" :class="titleLengthColor.replace('bg-', 'text-')" x-text="titleLengthMessage"></div>
            </div>
            
            <!-- Description Length -->
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-gray-700">Description Length</span>
                    <div class="w-3 h-3 rounded-full" :class="descLengthColor"></div>
                </div>
                <div class="text-xs text-gray-600">
                    <span x-text="descLength"></span> / 160 chars
                </div>
                <div class="text-xs mt-1" :class="descLengthColor.replace('bg-', 'text-')" x-text="descLengthMessage"></div>
            </div>
            
            <!-- Keyword in Title -->
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-gray-700">Keyword in Title</span>
                    <div class="w-3 h-3 rounded-full" :class="keywordInTitleColor"></div>
                </div>
                <div class="text-xs mt-1" :class="keywordInTitleColor.replace('bg-', 'text-')" x-text="keywordInTitleMessage"></div>
            </div>
            
            <!-- Keyword in Description -->
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-gray-700">Keyword in Description</span>
                    <div class="w-3 h-3 rounded-full" :class="keywordInDescColor"></div>
                </div>
                <div class="text-xs mt-1" :class="keywordInDescColor.replace('bg-', 'text-')" x-text="keywordInDescMessage"></div>
            </div>
            
            <!-- Content Word Count -->
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-gray-700">Content Words</span>
                    <div class="w-3 h-3 rounded-full" :class="wordCountColor"></div>
                </div>
                <div class="text-xs text-gray-600">
                    <span x-text="wordCount"></span> words
                </div>
                <div class="text-xs mt-1" :class="wordCountColor.replace('bg-', 'text-')" x-text="wordCountMessage"></div>
            </div>
            
            <!-- Internal Links -->
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-gray-700">Internal Links</span>
                    <div class="w-3 h-3 rounded-full" :class="linksCountColor"></div>
                </div>
                <div class="text-xs text-gray-600">
                    <span x-text="linksCount"></span> links
                </div>
                <div class="text-xs mt-1" :class="linksCountColor.replace('bg-', 'text-')" x-text="linksCountMessage"></div>
            </div>
        </div>
    </div>

    <div class="mb-6">
        <label for="title" class="block text-gray-700 font-bold mb-2">Title *</label>
        <input type="text" id="title" name="title" value="{{ old('title', $post->title ?? '') }}" required 
               class="w-full px-4 py-2 border @error('title') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:border-blue-600"
               x-model="title" @input="analyze()">
        @error('title')
            <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div>
            <label for="type" class="block text-gray-700 font-bold mb-2">Type *</label>
            <select id="type" name="type" required class="w-full px-4 py-2 border @error('type') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:border-blue-600">
                <option value="">Select Type</option>
                <option value="job" {{ old('type', $post->type ?? '') === 'job' ? 'selected' : '' }}>Job</option>
                <option value="admit_card" {{ old('type', $post->type ?? '') === 'admit_card' ? 'selected' : '' }}>Admit Card</option>
                <option value="syllabus" {{ old('type', $post->type ?? '') === 'syllabus' ? 'selected' : '' }}>Syllabus</option>
                <option value="result" {{ old('type', $post->type ?? '') === 'result' ? 'selected' : '' }}>Result</option>
                <option value="answer_key" {{ old('type', $post->type ?? '') === 'answer_key' ? 'selected' : '' }}>Answer Key</option>
                <option value="blog" {{ old('type', $post->type ?? '') === 'blog' ? 'selected' : '' }}>Blog</option>
            </select>
            @error('type')
                <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="category_id" class="block text-gray-700 font-bold mb-2">Category *</label>
            <select id="category_id" name="category_id" required class="w-full px-4 py-2 border @error('category_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:border-blue-600">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="state_id" class="block text-gray-700 font-bold mb-2">State</label>
            <select id="state_id" name="state_id" class="w-full px-4 py-2 border @error('state_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:border-blue-600">
                <option value="">Select State</option>
                @foreach ($states as $state)
                    <option value="{{ $state->id }}" {{ old('state_id', $post->state_id ?? '') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
            </select>
            @error('state_id')
                <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mb-6">
        <label for="content" class="block text-gray-700 font-bold mb-2">Content *</label>
        <textarea id="content" name="content" rows="10" required 
                  class="w-full px-4 py-2 border @error('content') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:border-blue-600"
                  x-model="content" @input="analyze()">{!! old('content', $post->content ?? '') !!}</textarea>
        <p class="text-xs text-gray-500 mt-1">You can paste HTML content here. It will be preserved exactly as entered.</p>
        @error('content')
            <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="meta_title" class="block text-gray-700 font-bold mb-2">Meta Title (max 60 chars)</label>
            <input type="text" id="meta_title" name="meta_title" maxlength="60" value="{{ old('meta_title', $post->meta_title ?? '') }}" 
                   class="w-full px-4 py-2 border @error('meta_title') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:border-blue-600"
                   x-model="metaTitle" @input="analyze()">
            @error('meta_title')
                <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="meta_description" class="block text-gray-700 font-bold mb-2">Meta Description (max 160 chars)</label>
            <input type="text" id="meta_description" name="meta_description" maxlength="160" value="{{ old('meta_description', $post->meta_description ?? '') }}" 
                   class="w-full px-4 py-2 border @error('meta_description') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:border-blue-600"
                   x-model="metaDescription" @input="analyze()">
            @error('meta_description')
                <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mb-6">
        <label for="meta_keywords" class="block text-gray-700 font-bold mb-2">
            Meta Keywords 
            <span class="text-xs text-gray-500 font-normal">
                (<span x-text="metaKeywords.length"></span>/1000 chars)
            </span>
        </label>
        <input type="text" id="meta_keywords" name="meta_keywords" maxlength="1000" value="{{ old('meta_keywords', $post->meta_keywords ?? '') }}" 
               class="w-full px-4 py-2 border @error('meta_keywords') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:border-blue-600"
               x-model="metaKeywords" @input="analyze()">
        <p class="text-xs text-gray-500 mt-1">Separate keywords with commas. Max 1000 characters.</p>
        @error('meta_keywords')
            <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="flex items-center">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }} class="mr-2">
            <label for="is_featured" class="text-gray-700 font-bold">Featured Post</label>
        </div>
        
        <div class="flex items-center">
            <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $post->is_published ?? false) ? 'checked' : '' }} class="mr-2">
            <label for="is_published" class="text-gray-700 font-bold">Published</label>
        </div>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            {{ isset($post) ? 'Update Post' : 'Create Post' }}
        </button>
        <a href="{{ route('admin.posts.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500">
            Cancel
        </a>
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
        
        titleLengthMessage: '',
        descLengthMessage: '',
        keywordInTitleMessage: '',
        keywordInDescMessage: '',
        wordCountMessage: '',
        linksCountMessage: '',
        
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
                this.titleLengthMessage = 'Perfect length!';
            } else if (this.titleLength >= 40 && this.titleLength < 50) {
                this.titleLengthColor = 'bg-yellow-500';
                this.titleLengthMessage = 'Good, but could be longer';
            } else if (this.titleLength > 60) {
                this.titleLengthColor = 'bg-red-500';
                this.titleLengthMessage = 'Too long, will be truncated';
            } else {
                this.titleLengthColor = 'bg-red-500';
                this.titleLengthMessage = 'Too short';
            }
        },
        
        analyzeDescLength() {
            this.descLength = this.metaDescription.length;
            
            if (this.descLength >= 120 && this.descLength <= 160) {
                this.descLengthColor = 'bg-green-500';
                this.descLengthMessage = 'Perfect length!';
            } else if (this.descLength >= 80 && this.descLength < 120) {
                this.descLengthColor = 'bg-yellow-500';
                this.descLengthMessage = 'Good, but could be longer';
            } else if (this.descLength > 160) {
                this.descLengthColor = 'bg-red-500';
                this.descLengthMessage = 'Too long, will be truncated';
            } else if (this.descLength > 0) {
                this.descLengthColor = 'bg-yellow-500';
                this.descLengthMessage = 'Too short';
            } else {
                this.descLengthColor = 'bg-red-500';
                this.descLengthMessage = 'Missing description';
            }
        },
        
        analyzeKeywordInTitle() {
            const keywords = this.extractKeywords();
            const effectiveTitle = (this.metaTitle || this.title).toLowerCase();
            
            const found = keywords.some(kw => effectiveTitle.includes(kw.toLowerCase()));
            
            if (found) {
                this.keywordInTitleColor = 'bg-green-500';
                this.keywordInTitleMessage = 'Keyword found in title';
            } else {
                this.keywordInTitleColor = 'bg-red-500';
                this.keywordInTitleMessage = 'No keyword in title';
            }
        },
        
        analyzeKeywordInDesc() {
            const keywords = this.extractKeywords();
            const desc = this.metaDescription.toLowerCase();
            
            const found = keywords.some(kw => desc.includes(kw.toLowerCase()));
            
            if (found) {
                this.keywordInDescColor = 'bg-green-500';
                this.keywordInDescMessage = 'Keyword found in description';
            } else if (desc.length === 0) {
                this.keywordInDescColor = 'bg-gray-400';
                this.keywordInDescMessage = 'No description yet';
            } else {
                this.keywordInDescColor = 'bg-yellow-500';
                this.keywordInDescMessage = 'Consider adding keyword';
            }
        },
        
        analyzeWordCount() {
            const text = this.stripHtml(this.content);
            const words = text.trim().split(/\s+/).filter(w => w.length > 0);
            this.wordCount = words.length;
            
            if (this.wordCount >= 300) {
                this.wordCountColor = 'bg-green-500';
                this.wordCountMessage = 'Excellent content length';
            } else if (this.wordCount >= 150) {
                this.wordCountColor = 'bg-yellow-500';
                this.wordCountMessage = 'Good, but could be longer';
            } else if (this.wordCount > 0) {
                this.wordCountColor = 'bg-red-500';
                this.wordCountMessage = 'Content too short';
            } else {
                this.wordCountColor = 'bg-red-500';
                this.wordCountMessage = 'No content yet';
            }
        },
        
        analyzeLinksCount() {
            const linkMatches = this.content.match(/<a\s+[^>]*href=["'][^"']*["'][^>]*>/gi) || [];
            this.linksCount = linkMatches.length;
            
            if (this.linksCount >= 2) {
                this.linksCountColor = 'bg-green-500';
                this.linksCountMessage = 'Good internal linking';
            } else if (this.linksCount === 1) {
                this.linksCountColor = 'bg-yellow-500';
                this.linksCountMessage = 'Add more internal links';
            } else {
                this.linksCountColor = 'bg-red-500';
                this.linksCountMessage = 'No internal links';
            }
        },
        
        calculateTotalScore() {
            let score = 0;
            
            // Title length (20 points)
            if (this.titleLength >= 50 && this.titleLength <= 60) score += 20;
            else if (this.titleLength >= 40 && this.titleLength < 50) score += 15;
            else if (this.titleLength > 0) score += 5;
            
            // Description length (20 points)
            if (this.descLength >= 120 && this.descLength <= 160) score += 20;
            else if (this.descLength >= 80 && this.descLength < 120) score += 15;
            else if (this.descLength > 0) score += 5;
            
            // Keyword in title (20 points)
            if (this.keywordInTitleColor === 'bg-green-500') score += 20;
            
            // Keyword in description (15 points)
            if (this.keywordInDescColor === 'bg-green-500') score += 15;
            
            // Word count (15 points)
            if (this.wordCount >= 300) score += 15;
            else if (this.wordCount >= 150) score += 10;
            else if (this.wordCount > 0) score += 5;
            
            // Internal links (10 points)
            if (this.linksCount >= 2) score += 10;
            else if (this.linksCount === 1) score += 5;
            
            this.totalScore = score;
            
            // Set score color
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
