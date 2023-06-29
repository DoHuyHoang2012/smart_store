@if (session('cart'))
        <form action="" method="post" id="cartformpage">
            <div class="cart-index">
                <h2>Chi tiết giỏ hàng</h2>
                <div class="tbody text-center d-flex flex-wrap">
                    <div class="col-xs-12 col-12 col-sm-12 col-md-12 col-lg-8">
                        <table class="table table-list-product">
                            <thead>
                                <tr style="background: #f3f3f3;">
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th class="text-center">Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-center">Thành tiền</th>
                                    <th class="text-center">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($cart as $key=> $item)
                                    <tr>
                                        <td class="img-product-cart">
                                            <a href="samsung-galaxy-s10-white">
                                                <img src="images/product/{{ $item['image'] }}" alt="{{$item['name']}}" />
                                            </a>
                                        </td>
                                        <td>
                                            <a href="samsung-galaxy-s10-white" class="pull-left">{{$item['name']}}</a>
                                        </td>
                                        <td>
                                            @php
                                                if ($item['sale'] > 0) {
                                                    $price = round((100 - $item['sale'])*$item['price']/100,-3);
                                                } else {
                                                    $price = $item['price'];
                                                }
                                                $total += $price* $item['quantity_cart'];
                                            @endphp
                                            <span class="amount"> {{number_format($price)}} VNĐ </span>
                                        </td>
                                        <td>
                                            <div class="quantity clearfix">
                                                @if ($item['quantity'] > $item['quantity_cart'])
                                                    <input name="quantity" id="{{$key}}" class="form-control px-1" type="number" value="{{$item['quantity_cart']}}" min="1" max="1000" onchange="onChangeSL({{$key}})" data-url="{{route('cart/update')}}"/>
                                                @else
                                                    Đã hết
                                                @endif                                                
                                            </div>
                                        </td>
                                        <td>
                                            <span class="amount"> {{number_format($price*$item['quantity_cart'])}} VNĐ </span>
                                        </td>
                                        <td>
                                            <a class="remove" id="remove-{{$key}}" title="Xóa" onclick="onRemoveProduct({{$key}})" data-url="{{route('cart/remove')}}"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        <button class="btn"><a href="{{route('category/index')}}">Tiếp tục mua hàng</a></button>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="clearfix btn-submit" style="padding-left: 10px;margin-top: 20px;">
                            <table class="table total-price" style="border: 1px solid #ececec;">
                                <tbody>
                                    <tr style="background: #f4f4f4;">
                                        <td>Tổng tiền</td>

                                        <td><strong>{{number_format($total)}} VNĐ</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><h4>Mua hàng trực tiếp tại cửa hàng giảm giá 5%</h4></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><h4>Nếu đặt online Bạn hãy đồng ý với điều khoản sử dụng &amp; hướng dẫn hoàn trả.</h4></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <button type="button" onclick="window.location.href='info-order'" class="btn-next-checkout">Đặt hàng</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="cart-info">
            Chưa có sản phẩm nào trong giỏ hàng !
            <br>	
            <button class="btn" onclick="window.location.href='san-pham'"> Tiếp tục mua hàng</button>
        </div>
    @endif

   