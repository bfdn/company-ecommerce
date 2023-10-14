@if ($paginator->hasPages())
    <nav aria-label="Page navigation pagination--one" class="pagination-wrapper">
        <ul class="pagination justify-content-center d-sm-none">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item pagination-item disabled" aria-disabled="true">
                    <a class="page-link pagination-link" href="#" tabindex="-1">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.91663 1.16634L1.08329 6.99967L6.91663 12.833" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
            @else
                <li class="page-item pagination-item">
                    <a class="page-link pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><svg
                            width="8" height="14" viewBox="0 0 8 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.91663 1.16634L1.08329 6.99967L6.91663 12.833" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg></a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item pagination-item">
                    <a class="page-link pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><svg
                            width="8" height="14" viewBox="0 0 8 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.08337 1.16634L6.91671 6.99967L1.08337 12.833" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg></a>
                </li>
            @else
                <li class="page-item pagination-item disabled" aria-disabled="true">
                    {{-- <span class="page-link">@lang('pagination.next')</span> --}}
                    <a class="page-link pagination-link" href="#">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.08337 1.16634L6.91671 6.99967L1.08337 12.833" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
            @endif
        </ul>

        <ul class="pagination justify-content-center d-none d-sm-flex">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item pagination-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    {{-- <span class="page-link" aria-hidden="true">&lsaquo;</span> --}}
                    <a class="page-link pagination-link" href="#" tabindex="-1">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.91663 1.16634L1.08329 6.99967L6.91663 12.833" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
            @else
                <li class="page-item pagination-item">
                    <a class="page-link pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="@lang('pagination.previous')">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.91663 1.16634L1.08329 6.99967L6.91663 12.833" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item pagination-item disabled" aria-disabled="true">
                        <a href="#" class="page-link pagination-link">{{ $element }}</a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item pagination-item" aria-current="page">
                                <a href="#" class="page-link pagination-link active">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item pagination-item">
                                <a class="page-link pagination-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item pagination-item">
                    <a class="page-link pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="@lang('pagination.next')">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.08337 1.16634L6.91671 6.99967L1.08337 12.833" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
            @else
                <li class="page-item pagination-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    {{-- <span class="page-link" aria-hidden="true">&rsaquo;</span> --}}
                    <a class="page-link pagination-link" href="#">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.08337 1.16634L6.91671 6.99967L1.08337 12.833" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
            @endif
        </ul>
        {{-- </div> --}}
        {{-- </div> --}}
    </nav>
@endif
