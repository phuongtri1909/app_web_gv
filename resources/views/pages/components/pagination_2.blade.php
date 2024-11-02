<style>
    .pagination_2 {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        margin: 20px 0;
        list-style: none;
        padding: 0;
        font-family: 'Inter', sans-serif;
        flex-wrap: wrap;
    }

    .pagination_2 .page-item {
        display: inline-flex;
        align-items: center;
    }

    .pagination_2 .page-link {
        padding: 6px 12px;
        background: #ffffff;
        color: #333333;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
        min-width: 35px;
        text-align: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .pagination_2 .page-link:hover {
        background: #f5f5f5;
        border-color: #d0d0d0;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .pagination_2 .page-item.active .page-link {
        background: #333333;
        color: #ffffff;
        border-color: #333333;
    }

    .pagination_2 .page-item.disabled .page-link {
        background: #fafafa;
        color: #999999;
        border-color: #eeeeee;
        cursor: not-allowed;
        pointer-events: none;
    }

    @media (max-width: 768px) {
        .pagination_2 {
            gap: 4px;
        }

        .pagination_2 .page-link {
            padding: 4px 8px;
            min-width: 30px;
            font-size: 13px;
        }
    }

    @media (max-width: 480px) {
        .pagination_2 {
            gap: 3px;
        }

        .pagination_2 .page-link {
            padding: 3px 6px;
            min-width: 28px;
            font-size: 12px;
        }
    }
</style>


@if ($paginator->hasPages())
    <nav>
        <ul class="pagination_2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Numbered Pages --}}
            @php
                $start = max(1, $paginator->currentPage() - 2);
                $end = min($paginator->lastPage(), $paginator->currentPage() + 2);
            @endphp

            @if($start > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                </li>
                @if($start > 2)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if($end < $paginator->lastPage())
                @if($end < $paginator->lastPage() - 1)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif


