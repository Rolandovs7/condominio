@if ($paginator->hasPages())
<nav class="d-flex align-items-center justify-content-between" aria-label="Paginación">
    <div style="font-size:.78rem;color:#64748b;">
        Mostrando <strong style="color:#94a3b8;">{{ $paginator->firstItem() }}</strong>
        — <strong style="color:#94a3b8;">{{ $paginator->lastItem() }}</strong>
        de <strong style="color:#94a3b8;">{{ $paginator->total() }}</strong> resultados
    </div>
    <ul class="pagination mb-0">
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link" aria-hidden="true">&#8249;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Anterior">&#8249;</a>
            </li>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">{{ $element }}</span>
                </li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Siguiente">&#8250;</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link" aria-hidden="true">&#8250;</span>
            </li>
        @endif
    </ul>
</nav>
@endif
