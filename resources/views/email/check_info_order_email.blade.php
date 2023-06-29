<html>
<body>
	<div style="color: #000;">
		<p>Xin chào {{$data['customer']['fullname']}},</p>
		<p>Cảm ơn Quý khách đã đặt hàng tại <strong>Smart Store</strong>!</p>
		<p>Đơn hàng của Quý khách đã được tiếp nhận, chúng tôi sẽ nhanh chóng liên hệ với Quý khách.</p>
		<div>
			<div style="font-size:18px;padding-top:10px"><strong>Thông tin Khách hàng</strong></div>
			<table style="width:100%;">
				<tbody>
					<tr>
						<td style="border-left:1px solid #d7d7d7;border-right:1px solid #d7d7d7;border-bottom:1px solid #d7d7d7;padding:5px 10px">
							<table style="width:100%">
								<tbody>
									<tr>
										<td>Họ tên:</td>
										<td>{{$data['order']['fullname']}}</td>
									</tr>
									<tr>
										<td>Email:</td>
										<td>{{$data['customer']['email']}}</td>
									</tr>
									<tr>
										<td>Điện thoại:</td>
										<td>{{$data['order']['fullname']}}</td>
									</tr>
									<tr>
										<td>Địa chỉ:</td>
										<td>
											{{$data['order']['address']}}, {{$data['district']}}, {{$data['province']}} 
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div>
			<div style="font-size:18px;padding-top:10px"><strong>Thông tin đơn hàng</strong></div>
			<table>
				<tbody>
					<tr>
						<td>Mã đơn hàng: <strong>#{{$data['order']['order_code']}}</strong></td>
						<td style="padding-left:40px">Ngày tạo: {{$data['order']['order_date']}}</td>
					</tr>
				</tbody>
			</table>
			<table style="width:100%;border-collapse:collapse">
				<thead>
					<tr style="border:1px solid #d7d7d7;background-color:#f8f8f8">
						<th style="text-align:left;padding:5px 10px"><strong>Sản phẩm</strong></th>
						<th style="text-align:center;padding:5px 10px"><strong>Số lượng</strong></th>
						<th style="text-align:center;padding:5px 10px"><strong>Đơn giá</strong></th>
						<th style="text-align:right;padding:5px 10px"><strong>Tổng</strong></th>
					</tr>
				</thead>
				<tbody>
                    @php
                        use Illuminate\Support\Facades\DB;
                        $row=DB::table('order_detail')->where('order_id',$data['order']['id'])->first();
                        
                        $products = json_decode($row->products);
                        $prices = json_decode($row->prices);
                        $quantities = json_decode($row->quantities);
                        $total = 0;
                        
                    @endphp
					@foreach($products as $key => $item)
                        @php
                            $name = DB::table('product')->where('id',$item)->first()->name;
                            $total +=  $prices[$key]*$quantities[$key];
                        @endphp
						<tr style="border:1px solid #d7d7d7">
							<td>{{$name}}</td>
							<td style="text-align:center;padding:5px 10px">{{$quantities[$key]}}</td>
							<td style="padding:5px 10px;text-align:center;">{{number_format($prices[$key]) }} VNĐ</td>
							<td style="padding:5px 10px;text-align:right">
								{{number_format($prices[$key]*$quantities[$key])}}
							VNĐ</td>
						</tr>

                    @endforeach
					<tr style="border:1px solid #d7d7d7">
						<td colspan="2">&nbsp;</td>
						<td colspan="2">
							<table style="width:100%">
								<tbody>
									<tr>
										<td><strong>Tổng cộng:</strong></td>
										<td style="text-align:right">{{number_format($total)}} VNĐ</td>
									</tr>
									<tr>
										<td><strong>Phí vận chuyển:</strong></td>
										<td style="text-align:right">{{ $data['order']['price_ship'] }} VNĐ</td>
									</tr>
                                    @if ($data['order']['coupon']>0)
                                        <tr>
                                            <td><strong>Voucher :</strong></td>
                                            <td style="text-align:right">- {{number_format($data['order']['coupon'])}} VNĐ</td>
                                        </tr>
                                    @endif
									
									<tr>
										<td><strong>Tổng thành tiền</strong></td>
										<td style="text-align:right color: red; font-size: 19px;">{{number_format($total+$data['order']['price_ship']+$data['order']['coupon'])}} VNĐ</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<p><strong>Hình thức thanh toán: </strong>Thanh toán khi giao hàng (COD)</p>
	</div>
</div>
</body>
</html>