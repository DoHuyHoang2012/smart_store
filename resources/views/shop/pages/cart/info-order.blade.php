@extends('shop.main')
@section('title','Thông tin đơn hàng')
@section('content')
@php
    use Illuminate\Support\Facades\DB;
   $onlyread = (session('customerInfo'))?'readonly' : '';
@endphp
<form action="{{route('cart/postInfoOrder')}}" method="post" accept-charset="utf-8">
    @csrf
	<section id="checkout-cart">
		<div class="container">
			<div class="col-md-12">
				<div class="wrapper">
                    @if (!session('customerInfo'))
                        <div style="font-size: 16px; padding-top: 10px; color: #ccc;">
                            Bạn có tài khoản?
                            <a href="dang-nhap" style="color: ">Ấn vào đây để đăng nhập</a>
                        </div>
                    @endif
                    <div class="row">   
                        <div class="col-xs-12 col-sm-12 col-md-8 col-login-checkout checkout-content" style="margin-bottom: 20px">
                            <p class="text-center">Địa chỉ giao hàng của quý khách</p>
                            <div class="wrap-info" style="width: 100%; min-height: 1px; overflow: hidden; padding: 10px;">
                                <table class="table tinfo" style="width: 80%;">
                                    <tbody>
                                        <tr>
                                            <td class="width30 text-right td-right-order">Khách hàng: <span class="require_symbol">* </span></td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Họ và tên" name="fullname" value="{{ $user['fullname']?? ''}}" {{$onlyread}}/>
                                                <div class="error"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width30 text-right td-right-order">Email: <span class="require_symbol">* </span></td>
                                            <td>
                                                <input type="text" class="form-control" name="email" value="{{ $user['email']?? ''}}" placeholder="Email" {{$onlyread}}/>
                                                <div class="error"></div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="width30 text-right td-right-order">Số điện thoại: <span class="require_symbol">* </span></td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Số điện thoại" name="phone" value="{{ $user['email']?? ''}}" {{$onlyread}}/>
                                                <div class="error"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width30 text-right td-right-order">Tỉnh/Thành phố: <span class="require_symbol">* </span></td>
                                            <td>
                                                <select name="city" id="province" onchange="renderDistrict()" data-url="{{route('cart/district')}}" class="form-control next-select">
                                                    <option value="">--- Chọn tỉnh thành ---</option>
                                                    @foreach ($provinces as $province)
                                                        <option value="{{$province->id}}">{{$province->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="error"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width30 text-right td-right-order">Quận/Huyện: <span class="require_symbol">* </span></td>
                                            <td>
                                                <select name="DistrictId" id="district" class="form-control next-select">
                                                    <option value="">--- Chọn quận huyện ---</option>
                                                </select>
                                                <div class="error"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width30 text-right td-right-order">Địa chỉ giao hàng: <span class="require_symbol">* </span></td>
                                            <td>
                                                <textarea name="address" placeholder="Địa chỉ giao hàng:" class="form-control" rows="4" ="" ="" style="height: auto !important;" value=""></textarea>
                                                <div class="error"></div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="width30 text-right td-right-order">Mã giảm giá (nếu có):</td>
                                            <td>
                                                <input id="coupon" style="border-radius: 5px; border-color: #0f9ed8;" type="text" class="form-control" placeholder="Mã giảm giá" name="coupon" />
                                                <div class="error" id="result_coupon"></div>
                                            </td>
                                            <td colspan="1">
                                                <a class="check-coupon" id="check-coupon" title="mã giảm giá" onclick="checkCoupon()" data-url="{{route('cart/coupon')}}">Sử dụng</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;"></td>
                                            <td style="border: none;">
                                                <div class="btn-checkout frame-100-1 overflow-hidden border-pri" style="float: right;">
                                                    <button type="submit" style="width: 300px" class="bg-pri border-pri col-fff" name="dathang">Đặt hàng</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                        <div class="col-xs-12 col-sm-12 col-md-4 products-detail" id="order-info">
                            @include('shop.pages.cart.component.order_info')
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</section>
</form>

@endsection
