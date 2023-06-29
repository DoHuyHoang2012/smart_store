@extends('shop.main')
@section('title', $itemProduct['name'])
@section('content')
@php
    use App\Helper\URL;
    $images = explode('#',$itemProduct['image']);
    $saleOff = $itemProduct['sale'];
    $price = $itemProduct['price'];
    $realPrice = round((100 - $saleOff)*$price/100,-3);

@endphp
<section id="product-detail">
	<div class="container">
		<div class="products-wrap">
			<form action="" method="post" id="ProductDetailsForm">
				<div class="breadcrumbs">
					<ul>
						<li class="home">
							<a href="{{ route('home')}}" title="Go to Home Page">Trang chủ</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li class="category3">
							<a href="{{ URL::linkCategory($itemProduct['cat_id'],$itemProduct['category_name']) }}" title="{{$itemProduct['category_name']}}">{{$itemProduct['category_name']}}</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li class="product">{{$itemProduct['name']}}</li>
					</ul>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 listimg-desc-product float-start">

					<div class="flexslider">
						<div class="clearfix"></div>
                        <ul class="slides">
                            @foreach ($images as $item)
                                <li data-thumb="{{ asset('images/product/'.$item.'') }}">
                                    <div class="thumb-image"><img src="{{ asset('images/product/'.$item.'') }}"/></div>
                                </li>
                            @endforeach
                        </ul>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 float-start">
					<div class="product-view-content">
						<div class="product-view-name">
							<h1>{{$itemProduct['name']}}</h1>
						</div>
						<div class="product-view-price">
							<div class="pull-left">
								<span class="price-label">Giá bán:</span>
								<span class="price"> {{number_format($realPrice)}}₫</span>
							</div>
                            @if ($saleOff > 0)
                                <div class="product-view-price-old">
                                    <span class="price">{{number_format($price)}}₫</span>
                                    <span class="sale-flag">{{$saleOff}}%</span>
                                </div>
                            @endif
						</div>
						<div class="product-status">
							<p style=" float: left;margin-right: 10px;">Thương hiệu: {{$itemProduct['category_name']}}</p>
                            @if ($itemProduct['quantity'] > 0)
                                <p>| Tình trạng: Còn hàng</p>
                            @else
                                <p>| Tình trạng: Hết hàng</p>
                            @endif
							
						</div>
						<div class="product-view-desc">
							<h4>Mô tả:</h4>
							<p>{{$itemProduct['shortDesc']}}</p>
						</div>
						<div class="actions-qty">
							@if ($itemProduct['quantity'] == 0 || $itemProduct['status'] == 0)
                                <h2 style="color: red; font-size:26px">Ngừng kinh doanh</h2>
                            @else
							<div class="actions-qty__button">
								<button class="button btn-cart add_to_cart_detail detail-button" title="Mua ngay" type="button" aria-label="Mua ngay"
								 data-url="{{ route('cart/addCart')}}" data-id="{{$itemProduct['id']}}">Mua ngay</button>
							</div>
                            @endif
							
						</div>
						<div style="margin-top: 20px;">
							<b>Tình trạng</b>
							<br />
							<span>Sản phẩm đã được kiểm chứng đầy đủ. Đảm bảo an toàn</span>
						</div>
						<div style="margin-top: 20px;">
							<b>Bảo hành</b>
							<br />
							<span>Bảo hành 30 ngày kể từ ngày mua hàng. 1 đổi 1 trong 7 ngày nếu có lỗi nhà sản xuất.</span><a href="#" style="color:red"> (Chi tiết)</a>
						</div>
					</div>
				</div>
                <div class="clearfix"></div>
				<div class="product-v-desc col-md-10 col-12 col-xs-12">
					<h3>Đặc điểm nổi bật</h3>
					{!! $itemProduct['detail'] !!}
				</div>
				<div class="product-comment product-v-desc">
					<h3>Bình luận</h3>
					
					<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
						<div id="fb-root"></div>
						<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0&appId=711560867408266&autoLogAppEvents=1" nonce="UiFW8NeP"></script>
						<div class="fb-comments" data-href="{{ URL::linkProduct($itemProduct['id'],$itemProduct['name']) }}" data-width="100%" data-numposts="5"></div>
					</div>
				</div>
				<div class="product-comment product-v-desc product">
					<h3>Sản phẩm liên quan</h3>
					<div class="product-container">
						<div class="owl-carousel-related-prod owl-carousel owl-theme owl-loaded owl-drag">
							<div class="owl-stage-outer">
								<div class="owl-stage" style="left: 0px; width: 380px;">
									@foreach ($productsRelated as $item)
										@php
											$name = $item['name'];
											$image = asset('images/product/'.$item['avatar']);
											$saleOff = $item['sale'];
											$price = $item['price'];
											$realPrice = (100 - $saleOff)*$price/100;
										@endphp		
										<div class="owl-item active" style="width: 179.6px; margin-right: 10px;">
											<div class="item">
												<div class="product-lt">
													<div class="lt-product-group-image">
														<a href="{{ URL::linkProduct($item['id'],$name) }}" title="{{$name}}">
															<img class="img-p" src="{{$image}}" alt="{{$name}}" />
														</a>
														@if ($saleOff > 0)
															<div class="sale-percent">
																<span class="text-sale-percent">Giảm {{$saleOff}}%</span>
															</div>
														@endif
														
													</div>

													<div class="lt-product-group-info">
														<a href="{{ URL::linkProduct($item['id'],$name) }}" title="{{$name}}" style="text-align: left;">
															<h3>{{$name}}</h3>
														</a>
														<div class="price-box">
															@if ($saleOff > 0)
																<p class="old-price">
																	<span class="price">{{number_format($price)}}₫</span>
																</p>
															@endif
															
															<p class="special-price">
																<span class="price">{{number_format($realPrice)}}₫</span>
															</p>
														</div>
														<div class="clear"></div>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection