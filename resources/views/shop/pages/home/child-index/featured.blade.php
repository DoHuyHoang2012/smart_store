@php
      use App\Helper\URL;
@endphp
<div class="container">
    @foreach ($itemsCategory as $item)
        <div class="list-product">
            <div class="list-header-z">
                <h2><a href="{{ URL::linkCategory($item['id'],$item['name']) }}">{{ $item['name'] }} nổi bật</a></h2>
                <ul class="sub-category">
                    @foreach ($item['sub_category'] as $val)
                        <li><a href="{{ URL::linkCategory($val['id'],$val['name']) }}" title="{{$val['name']}}" class="ws-nw overflow ellipsis"> {{$val['name']}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="product-container">
                @foreach ($item['products'] as $value)
                    @php
                        $image = 'images/product/'.$value['avatar'];
                        $name  = $value['name'];
                        $saleOff = $value['sale'];
                        $price = $value['price'];
                        $realPrice = round((100 - $saleOff)*$price/100,-3);
                        $id = $value['id']
                    @endphp
                    <div class="p-box-5">
                        <div class="product-lt">
                            <div class="lt-product-group-image">
                                <a href="{{ URL::linkProduct($id,$name) }}" title="{{ $name }}">
                                    <img class="img-p" src="{{ $image }}" alt="{{ $name }}" />
                                </a>
                                @if ($saleOff > 0)
                                    <div class="sale-percent">
                                        <span class="text-sale-percent">Giảm {!! $saleOff !!}%</span>
                                    </div>
                                @endif                            
                            </div>

                            <div class="lt-product-group-info">
                                <a href="{{ URL::linkProduct($id,$name) }}" title="{{ $name }}" style="text-align: left;">
                                    <h3>{{ $name }}</h3>
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
    @endforeach
    
</div>
