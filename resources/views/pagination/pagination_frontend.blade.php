<?php
    $link_limit = 5;
?>

@if ($paginator->lastPage() > 1)
    <ul class="pagination">
        @if ($paginator->currentPage() == 1)
            <li class="disabled hidden-xs">
                <span>Trang đầu</span>
            </li>
            <li class="disabled"><span>Trước</span></li>
        @else
            <li class="hidden-xs">
                <a href="{{ $paginator->url(1) }}">Trang đầu</a>
            </li>
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">Trước</a></li>
        @endif
        
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
            $half_total_links = floor($link_limit / 2);
            $from = $paginator->currentPage() - $half_total_links;
            $to = $paginator->currentPage() + $half_total_links;
            if ($paginator->currentPage() < $half_total_links) {
               $to += $half_total_links - $paginator->currentPage();
            }
            if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
            }
            ?>
            @if ($from < $i && $i < $to)
                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endif
        @endfor
        @if ($paginator->currentPage() == $paginator->lastPage())
            <li class="disabled"><span>Sau</span></li>
            <li class="disabled hidden-xs">
                <span>Trang cuối</span>
            </li>
        @else
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Sau</a></li>
            <li class="hidden-xs">
                <a href="{{ $paginator->url($paginator->lastPage()) }}">Trang cuối</a>
            </li>
        @endif
    </ul>
@endif