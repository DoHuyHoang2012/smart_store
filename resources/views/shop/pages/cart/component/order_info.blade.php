<div class="no-margin-table col-login-checkout" style="width: 95%;">
    <p>Thông tin đơn hàng</p>
    <table class="table" style="color: #333">
        <tbody>
            <tr class="text-transform font-weight-600">
                <td style="width: 150px;"><h4>Sản phẩm</h4></td>
                <td class="text-center"><h4>Số lượng</h4></td>
                <td class="text-center"><h4>Giá</h4></td>
                <td class="text-center"><h4>Tổng</h4></td>
            </tr>
            @php
                $total = 0;
            @endphp
            @foreach (session('cart') as $item)
                @php
                    $price = $item['price'];
                    if($item['sale']>0){
                        $price = round((100 - $item['sale'])*$item['price']/100,-3);
                    }
                    $total += $price* $item['quantity_cart'];
                @endphp
                <tr>
                    <td>{{$item['name']}}</td>
                    <td class="text-center">{{$item['quantity_cart']}}</td>
                    <td>{{number_format($price)}} VNĐ</td>
                    <td style="float: right;">
                        {{number_format($price* $item['quantity_cart'])}} VNĐ
                    </td>
                </tr>
            @endforeach                                      
            
            <tr>
                <td colspan="3">Tổng cộng :</td>
                <td style="float: right;">{{number_format($total)}} VNĐ</td>
            </tr>

            <tr>
                <td colspan="3">
                    <p style="font-size: 12px;">(Phí giao hàng)</p>
                </td>
                <td style="float: right;">{{number_format($priceShip)}} VNĐ</td>
            </tr>
            @if (session('coupon_price'))
            <tr>
                <td colspan="3">Voucher giảm giá: </td>
                <td>
                    <p style="float:right;"> -{{number_format(session('coupon_price')['discount'])}} VNĐ</p> 
                    <td style="cursor: pointer;"><a id="remove_coupon" onclick="removeCoupon()" data-url="{{route('cart/removeCoupon')}}"><i class="fas fa-times"></i></a></td>
                </td>
            </tr>
            @endif
           
            <tr style="background: #f4f4f4">
                <td colspan="3">
                    <p style="font-size: 15px; color: red;">Thành tiền</p>
                    <span style="font-weight: 300; font-style: italic;">(Tổng số tiền thanh toán)</span>
                </td>

                <td class="text-center">
                    <p style="font-size: 15px; color: red;">
                        <?php 
                            if(session('coupon_price')){
                                $money_pay = ($total + $priceShip) - session('coupon_price')['discount'];
                            }else{
                                $money_pay = $total + $priceShip;
                            }
                       ?> 
                       {{number_format($money_pay)}} VNĐ
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>