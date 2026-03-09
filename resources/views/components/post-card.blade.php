<div class="bg-white rounded-lg shadow-md p-1.5 hover:shadow-lg transition-shadow">
    <div class="flex justify-between items-start mb-0.5">
        <h3 class="text-xs font-semibold text-red-500 flex-1">
            <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" class="hover:text-red-700">
                {{ $post->title }}
            </a>
        </h3>
        @if ($post->isNew())
            <span class="bg-red-500 text-white px-1 py-0.5 rounded text-xs font-bold ml-1">NEW</span>
        @endif
    </div>
    
    <div class="flex flex-wrap gap-0.5 mb-0.5">
        <span class="text-xs bg-blue-100 text-blue-700 px-1 py-0.5 rounded">{{ ucfirst(str_replace('_', ' ', $post->type)) }}</span>
        @if ($post->category)
            <span class="text-xs bg-gray-100 text-gray-700 px-1 py-0.5 rounded">{{ $post->category->name }}</span>
        @endif
        @if ($post->state)
            <span class="text-xs bg-green-100 text-green-700 px-1 py-0.5 rounded">{{ $post->state->name }}</span>
        @endif
    </div>
    
    <p class="text-gray-600 text-xs mb-0.5 line-clamp-1">{{ Str::limit($post->short_description, 60) }}</p>
    
    <div class="flex justify-between items-center text-gray-500 mb-0.5">
        <span class="text-2xs">{{ $post->created_at->format('M d') }}</span>
        <span class="text-2xs">👁️ {{ $post->view_count }}</span>
    </div>
    
    <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" class="inline-block text-red-500 hover:text-red-700 font-semibold text-xs">
        Read More →
    </a>
</div>
