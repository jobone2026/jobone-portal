<div class="bg-white rounded-lg shadow-md p-1.5 hover:shadow-lg transition-shadow">
    @php
        // Assign colors based on post type
        $typeColors = [
            'jobs' => ['title' => 'text-blue-600', 'badge' => 'bg-blue-100 text-blue-700', 'link' => 'text-blue-600 hover:text-blue-800'],
            'admit_cards' => ['title' => 'text-purple-600', 'badge' => 'bg-purple-100 text-purple-700', 'link' => 'text-purple-600 hover:text-purple-800'],
            'results' => ['title' => 'text-green-600', 'badge' => 'bg-green-100 text-green-700', 'link' => 'text-green-600 hover:text-green-800'],
            'syllabus' => ['title' => 'text-orange-600', 'badge' => 'bg-orange-100 text-orange-700', 'link' => 'text-orange-600 hover:text-orange-800'],
            'blogs' => ['title' => 'text-indigo-600', 'badge' => 'bg-indigo-100 text-indigo-700', 'link' => 'text-indigo-600 hover:text-indigo-800'],
        ];
        $colors = $typeColors[$post->type] ?? ['title' => 'text-gray-600', 'badge' => 'bg-gray-100 text-gray-700', 'link' => 'text-gray-600 hover:text-gray-800'];
    @endphp
    
    <div class="flex justify-between items-start mb-2">
        <h3 class="text-sm font-semibold {{ $colors['title'] }} flex-1">
            <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" class="hover:opacity-80">
                {{ $post->title }}
            </a>
        </h3>
        @if ($post->isNew())
            <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-bold ml-2">NEW</span>
        @endif
    </div>
    
    <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" class="inline-block {{ $colors['link'] }} font-semibold text-xs">
        Read More →
    </a>
</div>
