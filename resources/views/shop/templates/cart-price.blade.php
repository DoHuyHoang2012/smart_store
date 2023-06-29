<strong class="cart_header_count">Giỏ hàng<span>
    @if (session('cart'))
      ({{count(session('cart'))}})
    @else
    (0)
    @endif
  </span></strong>
  
  <span class="cart_price"><p>
    @if (session('cart'))
      @php
          $money = 0;
          foreach(session('cart') as $key => $value){

            
            if($value['sale']>0){
              $price = round((100 - $value['sale'])*$value['price']/100,-3);
              $total = $price*$value['quantity_cart'];
            }else {
              $total = $value['price']*$value['quantity_cart'];
            }
            $money+=$total;
          }
      @endphp
      {{ number_format($money) }} VNĐ
    @else
    0 VNĐ
    @endif
</p></span>