@extends('shop.main')
@section('title','Tài khoản')
@section('content')
@php
	$customer = session('customerInfo');
@endphp
<section id="content">
	<div class="container account d-flex flex-wrap">
		<aside class="col-right sidebar col-md-3 col-xs-12">
			<div class="block block-account">
				<div class="general__title">
					<h2><span>Thông tin tài khoản</span></h2>
				</div>
				<div class="block-content">
					<p>Tài khoản: <strong>{{$customer['username']}}</strong></p>
					<p>Họ và tên: <strong>{{$customer['fullname']}}</strong></p>
					<p>Email: <strong>{{$customer['email']}}</strong></p>
					<p>Số điện thoại: <strong>{{$customer['phone']}}</strong></p>
				</div>
				<button class="btn"><a href="{{route('account/changePass')}}">Đổi mật khẩu</a></button>
			</div>
		</aside>
		<div class="col-main col-md-9 col-sm-12">
			<div class="my-account">
				@if (!empty($orderNon))
					<div class="general__title">
						<h2><span>Danh sách đơn hàng chưa duyệt</span></h2>
					</div>
					<table style="padding-right: 10px; width: 100%;">
						<thead style="border: 1px solid silver;">
							<tr>
								<th class="text-left" style="width: 85px; padding:5px 10px">Đơn hàng</th>
								<th style="width: 110px; padding:5px 10px">Ngày</th>
								<th style="width: 150px;text-align: center; padding:5px 10px">
									Giá trị đơn hàng
								</th>
								<th style="width: 150px; text-align: center;">Trạng thái đơn hàng</th>
								<th style="text-align: center;" colspan="2">Thao tác</th>
							</tr>
						</thead>
						<tbody style="border: 1px solid silver;">
							@foreach ($orderNon as $item)
								<tr style="border-bottom: 1px solid silver;">
									<td style="padding:5px 10px;">{{$item['order_code']}}</td>
									<td style="padding:5px 10px;">{{$item['order_date']}}</td>
									<td style="text-align: center; padding:5px 10px;"><span class="price-2">{{number_format($item['money'])}} VNĐ</span></td>
									<td style="padding:5px 10px; text-align: center;">
										Đang đợi duyệt
									</td>
									<td width="70">
										<span> <a style="color: #0f9ed8;" href="account/orders/44">Xem chi tiết</a></span>
									</td>
									<td width="70">
										<a style="color: red;" href="thongtin/update/44" onclick="return confirm('Xác nhận hủy đơn hàng này ?')">Hủy đơn hàng</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@endif
				

				<div class="general__title">
					<h2><span>Danh sách đơn hàng</span></h2>
				</div>
				@if (!empty($order))
				<div class="table-order">
					<table style="padding-right: 10px; width: 100%;">
						<thead style="border: 1px solid silver;">
							<tr>
								<th class="text-left" style="width: 85px; padding:5px 10px">Đơn hàng</th>
								<th style="width: 110px; padding:5px 10px">Ngày</th>
								<th style="width: 150px;text-align: center; padding:5px 10px">
									Giá trị đơn hàng
								</th>
								<th style="width: 150px; text-align: center;">Trạng thái đơn hàng</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody style="border: 1px solid silver;">
							@foreach ($order as $item)
								<tr style="border-bottom: 1px solid silver;">
									<td style="padding:5px 10px;">{{$item['order_code']}}</td>
									<td style="padding:5px 10px;">{{$item['order_date']}}</td>
									<td style="text-align: center; padding:5px 10px;"><span class="price-2">{{number_format($item['money'])}} VNĐ</span></td>
									<td style="padding:5px 10px; text-align: center;">
										@switch($item['status'])
											@case(1)
												Đang giao hàng
												@break
											@case(2)
												Đã giao
												@break
											@case(3)
												Khách hàng đã hủy
												@break
											@case(4)
												Nhân viên đã hủy
												@break
											@default
												
										@endswitch
										
									</td>
									<td width="70">
										<span> <a style="color: #0f9ed8;" href="{{route('account/orderDetail',['order'=>$item['id']])}}">Xem chi tiết</a></span>
									</td>
								</tr>
							@endforeach
							
							
						</tbody>
					</table>
				</div>
				@else
					<p class="my-5">Quý khách chưa có đơn hàng nào.</p>
				@endif
				
			</div>
		</div>
	</div>
</section>
@endsection
