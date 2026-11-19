@if ($paginator->hasPages())
    <nav aria-label="Navigasi halaman riwayat aktivitas" class="sa-pagination-nav">
        <div class="sa-pagination-info">
            Menampilkan {{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }}
            dari {{ $paginator->total() }} aktivitas
        </div>

        <div class="sa-pagination-list">
            {{-- Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span class="sa-page-control is-disabled" aria-disabled="true">‹ Sebelumnya</span>
            @else
                <a class="sa-page-control" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Sebelumnya</a>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="sa-page-ellipsis" aria-disabled="true">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="sa-page-number is-active" aria-current="page">{{ $page }}</span>
                        @else
                            <a class="sa-page-number" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Berikutnya --}}
            @if ($paginator->hasMorePages())
                <a class="sa-page-control" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya ›</a>
            @else
                <span class="sa-page-control is-disabled" aria-disabled="true">Berikutnya ›</span>
            @endif
        </div>
    </nav>
@endif
