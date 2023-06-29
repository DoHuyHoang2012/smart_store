@extends('shop.main')
@section('title','Chi tiết đơn hàng')
@section('content')
@php
	$customer = session('customerInfo');
@endphp
<div class="container order-page">
	<div class="general__title">
		<h2>Chi tiết đơn hàng</h2>
	</div>
	<div class="table-responsive">
		<fieldset>
			<table class="table table-bordered tb-detail-or">
				<thead>
					<tr class="">
						<th>Sản phẩm</th>
						<th>Giá</th>
						<th>Số lượng</th>
						<th>Thành tiền</th>
					</tr>
				</thead>
				<tbody>
                    @php
                        use Illuminate\Support\Facades\DB;
                        $products = json_decode($orderDetail['products']);
                        $prices = json_decode($orderDetail['prices']);
                        $quantities = json_decode($orderDetail['quantities']);
                        $total = 0;
                    @endphp
					@foreach ($products as $key => $item)
                    @php
                        $name = DB::table('product')->where('id',$item)->first()->name;
                        $total +=  $prices[$key]*$quantities[$key];
                    @endphp
                        <tr>
                            <td><a href="laptop-dell-inspiron-15-3576-70157552">{{$name}}</a></td>
                            <td> {{number_format($prices[$key])}}</td>
                            <td>{{$quantities[$key]}}</td>
                            <td>{{number_format($prices[$key]*$quantities[$key])}} VNĐ</td>
                        </tr>
                    @endforeach
					
				</tbody>
			</table>
		</fieldset>
	</div>
	<div class="or-detail-c">
        <div class="row my-5">
            <div class="col-sm-8">
                <div class="general__title">
                    <h3>Thông tin thanh toán</h3>
                </div>
                <div class="content-order">
                    <p>Mã Đơn hàng: {{$order['order_code']}}</p>
                    <p>Khách hàng:{{$order['fullname']}}</p>
                    <p>Số điện thoại: {{$order['phone']}}</p>
                    <p>Thời gian đặt hàng: {{$order['order_date']}}</p>
                    <p>Địa chỉ giao hàng: {{$order['address']}}, {{$district}}, {{$province}}</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="general__title">
                    <h3>Tổng tiền hóa đơn</h3>
                </div>
                <div class="content-order">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Tổng tiền đơn hàng</td>
                                <td class="text-right"><span>{{number_format($total)}} VNĐ</span></td>
                            </tr>
    
                            <tr>
                                <td>Phí giao hàng:</td>
                                <td class="text-right">{{number_format($order['price_ship'])}} VNĐ</td>
                            </tr>
                            @if ($order['coupon'] > 0)
                            <tr>
                                <td>Voucher :</td>
                                <td class="text-right">-{{number_format($order['coupon'])}} VNĐ</span></td>
                            </tr>
                            @endif
                            <tr>
                                <td>Tổng thanh toán:</td>
                                <td class="text-right"><span style="color: red; font-size: 23px;">{{number_format($order['money'])}} VNĐ</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
		
		<div class="col-xs-12">
			<button class="btn">
				<a href="javascript:;" onclick="window.history.go(-1);" class="viewMore pull-left" style="font-size: 15px;"><i class="fa fa-angle-left" aria-hidden="true"></i> Trở về trang trước</a>
			</button>
		</div>
	</div>
</div>

@endsection
