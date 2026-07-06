@if ($paginator->hasPages())
    <nav>
        <ul class="pagination pagination-simple mb-0">

            {{-- Tombol Previous --}}
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link"
                   href="{{ $paginator->onFirstPage() ? '#' : $paginator->previousPageUrl() }}"
                   aria-label="Previous">
                    <svg width="14" height="14" fill="none" viewBox="0 0 16 16">
                        <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </li>

            {{-- Nomor halaman --}}
            <li class="page-item active">
                <span class="page-link page-current">
                    {{ $paginator->currentPage() }}
                </span>
            </li>

            {{-- Tombol Next --}}
            <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link"
                   href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : '#' }}"
                   aria-label="Next">
                    <svg width="14" height="14" fill="none" viewBox="0 0 16 16">
                        <path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </li>

        </ul>
    </nav>
@endif