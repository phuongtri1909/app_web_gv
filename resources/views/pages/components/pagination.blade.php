@if ($questions->hasPages())
    <ul class="pagination box">
        {{-- Trang trước --}}
        @if ($questions->onFirstPage())
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">&laquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $questions->appends(request()->except('page_2'))->previousPageUrl() }}" rel="prev">&laquo;</a>
            </li>
        @endif

        {{-- Liên kết trang --}}
        @foreach ($questions as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Liên kết số trang --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $questions->currentPage())
                        <li class="page-item " aria-current="page"><span class="page-link active">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Trang tiếp theo --}}
        @if ($questions->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $questions->appends(request()->except('page_2'))->nextPageUrl() }}" rel="next">&raquo;</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">&raquo;</span>
            </li>
        @endif
    </ul>
@endif
