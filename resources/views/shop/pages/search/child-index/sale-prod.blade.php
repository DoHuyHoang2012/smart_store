@php
     use App\Helper\URL;
@endphp
<div class="widget">
    <p>Sản phẩm khuyến mãi</p>
    <div class="panel-left-body">
        <div id="post-list-footer" class="sidebar_menu">
            @if (count($itemsSaleHot) > 0)
            @foreach ($itemsSaleHot as $item)
                @php
                    $name  = $item['name'];
                    $saleOff = $item['sale'];
                    $price = $item['price'];
                    $realPrice = round((100 - $saleOff)*$price/100,-3);
                @endphp
                <div class="spost clearfix">
                    <div class="entry-image">
                        <a href="{{ URL::linkProduct($item['id'],$name) }}" title=" {{$name}}"><img src="{{ asset('images/product/'.$item['avatar'].'') }}" /></a>
                    </div>
                    <div class="entry-c">
                        <div class="entry-title"><a class="ws-nw overflow ellipsis" href="{{ URL::linkProduct($item['id'],$name) }}" title=" {{$name}}">{{$name}}</a></div>
                        <ul class="entry-meta">
                            <li class="color"><ins>{{ number_format($realPrice) }}₫</ins><del>{!! number_format($price) !!}₫</del></li>
                        </ul>
                    </div>
                </div>
            @endforeach
            @endif
            
        </div>
    </div>
</div>