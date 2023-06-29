@php
     use App\Helper\URL;
@endphp
@extends('shop.main')
@section('title', $categoryName['name'])
@section('content')
  
<section id="product-all" class="collection">
    @include('shop.templates.banner')
    <div class="slider">
        <div class="container d-flex flex-wrap">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                @include('shop.templates.menu-cat')
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 products-sale-off">
                    @include('shop.pages.category.child-index.sale-prod')
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 product-content">
                <div class="product-wrap">
                    <div class="collection__title">
                        <h1><span>{{ $categoryName['name'] }}</span></h1>
                        @include('shop.pages.category.child-index.sort',['action' => 'category'])
                            <div class="collection-filter" id="list-product">
                                <div class="category-products">
                                    <div class="products-grid d-flex flex-wrap w-100">
                                    @if (count($itemsProduct) > 0)
                                        @foreach ($itemsProduct as $item)
                                            @php
                                                $name  = $item['name'];
                                                $saleOff = $item['sale'];
                                                $price = $item['price'];
                                                $realPrice = round((100 - $saleOff)*$price/100,-3);
                                            @endphp
                                            <div class="col-md-3 col-lg-3 col-xs-6 col-6">
                                                <div class="product-lt">
                                                    <div class="lt-product-group-image">
                                                        <a href="{{ URL::linkProduct($item['id'],$name) }}" title="{{ $name }}">
                                                            <img class="img-p" src="{{ asset('images/product/'.$item['avatar'].'') }}" alt="{{ $name }}" />
                                                        </a>
                                                        @if ($saleOff > 0)
                                                            <div class="sale-percent">
                                                                <span class="text-sale-percent">Giảm {!! $saleOff !!}%</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="lt-product-group-info">
                                                        <a href="{{ URL::linkProduct($item['id'],$name) }}" title="{{ $name }}">
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
                                    @else
                                        <p class="no-products"> Danh mục hiện chưa có sản phẩm nào !</p>
                                    @endif
                                    
                                    </div>
                       
                                <div class="text-center pull-right">
                                    {{ $itemsProduct->appends(request()->input())->links('pagination.pagination_frontend') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
@endsection
