@if ($paginator->hasPages())
    <div class="pagination-wrapper" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin: 20px 0;">
        <!-- Info Text -->
        <div style="text-align: center; margin-bottom: 15px; color: #666; font-size: 14px;">
            <strong>Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} posts</strong>
        </div>

        <!-- Pagination Buttons -->
        <div style="display: flex; justify-content: center; align-items: center; gap: 8px; flex-wrap: wrap;">
            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
                <span style="padding: 10px 16px; background: #e0e0e0; color: #999; border-radius: 6px; font-weight: 600; cursor: not-allowed;">
                    ← Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" style="padding: 10px 16px; background: #0066cc; color: white; border-radius: 6px; text-decoration: none; font-weight: 600; transition: all 0.3s;">
                    ← Previous
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span style="padding: 10px 16px; color: #666;">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="padding: 10px 16px; background: #0066cc; color: white; border-radius: 6px; font-weight: bold; min-width: 45px; text-align: center;">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" style="padding: 10px 16px; background: #f5f5f5; color: #333; border-radius: 6px; text-decoration: none; font-weight: 600; min-width: 45px; text-align: center; transition: all 0.3s;">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" style="padding: 10px 16px; background: #0066cc; color: white; border-radius: 6px; text-decoration: none; font-weight: 600; transition: all 0.3s;">
                    Next →
                </a>
            @else
                <span style="padding: 10px 16px; background: #e0e0e0; color: #999; border-radius: 6px; font-weight: 600; cursor: not-allowed;">
                    Next →
                </span>
            @endif
        </div>
    </div>

    <style>
        .pagination-wrapper a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,102,204,0.3);
        }
        @media (max-width: 640px) {
            .pagination-wrapper {
                padding: 15px 10px !important;
            }
            .pagination-wrapper > div:last-child {
                gap: 5px !important;
            }
            .pagination-wrapper a, .pagination-wrapper span {
                padding: 8px 12px !important;
                font-size: 13px !important;
            }
        }
    </style>
@endif
