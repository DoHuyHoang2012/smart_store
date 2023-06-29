<div class="row">               
    <div class="col-md-7 col-sm-7 col-xs-8">
        {{ $items->appends(request()->input())->links('pagination.pagination_backend') }}
    </div>
</div>                                                   