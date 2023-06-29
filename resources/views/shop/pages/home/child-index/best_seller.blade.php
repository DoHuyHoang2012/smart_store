@php
     use App\Helper\URL;
@endphp
<div class="container py-4">
    <div class="sale-title"><span>SẢN PHẨM BÁN CHẠY</span></div>
    <div class="owl-carousel owl-carousel-product owl-theme">
        @foreach ($itemsBestSeller as $item)
            @php
                $image = 'images/product/'.$item['avatar'];
                $name  = $item['name'];
                $saleOff = $item['sale'];
                $price = $item['price'];
                $realPrice = round((100 - $saleOff)*$price/100,-3);
            @endphp
            <div class="item" style="margin: 0px;">
                <div class="products-sale">
                    <div class="lt-product-group-image">
                        <a href="{{ URL::linkProduct($item['id'],$name) }}" title="{!! $name !!}">
                            <img class="img-p" src="{!! $image !!}" alt="" />
                        </a>
                        @if ($saleOff > 0)
                            <div class="sale-percent">
                                <span class="text-sale-percent">Giảm {!! $saleOff !!}%</span>
                            </div>
                        @endif
                        
                    </div>
                    <div class="lt-product-group-info">
                        <a href="{{ URL::linkProduct($item['id'],$name) }}" title="{!! $name !!}" style="text-align: left;">
                            <h3>{!! $name !!}</h3>
                        </a>
                        <div class="price-box">
                            @if ($saleOff > 0)
                                <p class="old-price">
                                    <span class="price">{!! number_format($price) !!}₫</span>
                                </p>
                            @endif
                          
                            <p class="special-price">
                                <span class="price">{!! number_format($realPrice) !!}₫</span>
                            </p>
                            
                           
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>