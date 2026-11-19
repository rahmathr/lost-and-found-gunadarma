@if ($paginator->hasPages())
<style>
.lf-pagination{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;margin-top:18px;font-size:13px;color:#555}
.lf-pagination__info{margin:0}
.lf-pagination__nav{display:flex;flex-wrap:wrap;align-items:center;gap:5px}
.lf-pagination .lf-pagination__link{display:inline-flex;align-items:center;justify-content:center;min-width:34px;min-height:34px;padding:6px 10px;border:1px solid #d5d0dc;border-radius:5px;background:#fff;color:#514064;text-decoration:none}
.lf-pagination .lf-pagination__link:hover{background:#f5f0f8;border-color:#bdaaca}
.lf-pagination .lf-pagination__link[aria-current="page"]{background:#5b3480;border-color:#5b3480;color:#fff;font-weight:700}
.lf-pagination .lf-pagination__link[aria-disabled="true"]{color:#aaa;background:#fafafa;pointer-events:none}
.lf-pagination__dots{padding:0 5px;color:#777}
@media(max-width:600px){.lf-pagination{align-items:flex-start;flex-direction:column}.lf-pagination__nav{max-width:100%}}
</style>
<nav class="lf-pagination" aria-label="Navigasi halaman">
    <p class="lf-pagination__info">Menampilkan {{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }} data</p>
    <div class="lf-pagination__nav">
        @if ($paginator->onFirstPage())
            <span class="lf-pagination__link" aria-disabled="true">‹ Sebelumnya</span>
        @else
            <a class="lf-pagination__link" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Sebelumnya</a>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))<span class="lf-pagination__dots">{{ $element }}</span>@endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="lf-pagination__link" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="lf-pagination__link" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <a class="lf-pagination__link" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya ›</a>
        @else
            <span class="lf-pagination__link" aria-disabled="true">Berikutnya ›</span>
        @endif
    </div>
</nav>
@endif
