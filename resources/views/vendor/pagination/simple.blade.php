@if ($paginator->hasPages())
    <nav>
        <div class="pagination-info">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
        <div class="pagination-links">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="disabled">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="dots">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="current">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="disabled">
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
