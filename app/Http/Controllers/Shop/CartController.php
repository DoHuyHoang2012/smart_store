<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use App\Models\CouponModel;
use App\Models\CustomerModel;
use App\Models\OrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Mail;

class CartController extends Controller
{
   private $pathViewController = 'shop.pages.cart.'; 
   private $controllerName     = 'cart';
   private $params= [];
   private $Mproduct;
   private $Mcustomer;
   private $Mcoupon;
   public function __construct(){
     $this->Mproduct = new ProductModel();
     $this->Mcustomer = new CustomerModel();
     $this->Mcoupon = new CouponModel();
     $this->Morder = new OrderModel();
     view()->share('controllerName', $this->controllerName);
   }

   public function index(Request $request) {
    $cart = $request->session()->get('cart');
    return view($this->pathViewController. 'index', [
        'cart' => $cart
    ]);
   }

   public function addCart(Request $request){
        $id= $request->id;
        $product = $this->Mproduct->getItem(['id' => $id], ['task'=> 'get-item']);
        $cart = $request->session()->get('cart');
        if(isset($cart[$id])){
            $cart[$id]['quantity_cart'] = $cart[$id]['quantity_cart'] + 1;
        }else{
            $cart[$id] = [
                'name' => $product['name'],
                'image'=> $product['avatar'],
                'price'=> $product['price'],
                'sale' => $product['sale'],
                'quantity' => $product['quantity'],
                'quantity_cart' => 1
            ];
        }
        $request->session()->put('cart',$cart);
        $cart = $request->session()->get('cart');
        $cartPriceComponent = view('shop.templates.cart-price',compact('cart'))->render();
        $cartMobile = sprintf('<i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <span>(%s)</span>',count($cart));
        return response()->json([
            'cart_price'=> $cartPriceComponent,
            'cart_mobile' => $cartMobile,
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công!',
            'status' => 200
        ],200);
    }

    public function update(Request $request){
        if($request->id && $request->quantity){
            $cart = $request->session()->get('cart');
            $cart[$request->id]['quantity_cart'] = $request->quantity;
            $request->session()->put('cart',$cart);  
            $cart = $request->session()->get('cart');
            $cartPriceComponent = view('shop.templates.cart-price',compact('cart'))->render();
            $cartComponent = view($this->pathViewController.'child-index.cart-component',compact('cart'))->render();
            return response()->json(['cart_component'=> $cartComponent,'cart_price'=> $cartPriceComponent,'code'=> 200],200);
        }
        
        
    }

    

    public function remove(Request $request){
        if($request->id){
            $cart = $request->session()->get('cart');
            unset($cart[$request->id]);
            $request->session()->put('cart',$cart);
            $cart = $request->session()->get('cart');
            $cartPriceComponent = view('shop.templates.cart-price',compact('cart'))->render();
            $cartComponent = view($this->pathViewController.'child-index.cart-component',compact('cart'))->render();
            $cartMobile = sprintf('<i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <span>(%s)</span>',count($cart));
            return response()->json(['cart_component'=> $cartComponent,'cart_price'=> $cartPriceComponent,'cart_mobile' => $cartMobile, 'code' => 200],200);
        }
    }

    public function infoOrder(Request $req){
        if(!$req->session()->has('cart')){
            return redirect()->route('cart/index');
        }else{
            $user = $req->session()->get('customerInfo');
            $provinces = DB::table('province')->orderBy('name', 'asc')->get();
            $getPriceShip = DB::table('config')->where('id',1)->first();
            $priceShip = $getPriceShip->priceShip;
        }
        if($req->method() == 'POST'){
            if(!$req->session()->has('customerInfo')){
                $emailCond = 'bail|required|email|unique:customer';
            }
            $emailCond = 'required';
            $req->validate([
                'email' => $emailCond,
                'phone' => 'required',
                'fullname'=>'bail|required|min:3',
                'address'=> 'required',
                'city'  => 'required',
                'DistrictId' => 'required'
              ],[
                'required' => 'Vui lòng điền thông tin vào trường này',
                'email.email' => 'Vui lòng nhập địa chỉ email hợp lệ',
                'email.unique'   => 'Email này đã tồn tại trong hệ thống',
                'fullname.min'   => 'Họ và tên phải từ 3 ký tự trở lên'
              ]);

            //Tinh tien don hang
            $money=0;
            if($req->session()->has('cart')){
                $data=$req->session()->get('cart');
                foreach ($data as $key => $value) {
                    if ($value['sale'] > 0) {
                        $price = round((100 - $value['sale'])*$value['price']/100,-3);
                    } else {
                        $price = $value['price'];
                    }
                    $money += $price* $value['quantity_cart'];
                }
            }
            $idCustomer=null;
            if(!$req->session()->has('customerInfo')){
                $datacustomer= array(
                    'fullname'=>$req->fullname,
                    'phone'=> $req->phone,
                    'email'=> $req->email,
                );
                $this->Mcustomer->saveItem($datacustomer,['task' => 'add-item-customer']);
                $row = $this->Mcustomer->getItem($datacustomer, ['task' => 'get-item-email']);
                $idCustomer = $row['id']; 
                $req->session()->put('info-customer',$datacustomer);
            }else{
                $idCustomer = $req->session()->get('customerInfo')['id'];
            }
            
            //kt ma giam gia
            if($req->session()->has('coupon_price'))
            {
                $coupon =$req->session()->get('coupon_price');
                $couponPrice = $coupon['discount'];
                $couponItem = $this->Mcoupon->getItem($coupon,['task' => 'get-item']);
                $mycoupon=array(
                    'code'        => $coupon['code'],
                    'number_used' => $couponItem['number_used']+1,
                );
                $this->Mcoupon->saveItem($mycoupon, ['task'=>'update-number-used']);
            }
            else{
                $couponPrice = 0;
            }

            $provinceId = $req->city;
            $districtId = $req->DistrictId;
            $mydata=array(
                'order_code' => Str::random(8),
                'customer_id' => $idCustomer,
                'address' => $req->address,
                'money' => $money + $priceShip -$couponPrice,
                'price_ship' => $priceShip,
                'coupon' => $couponPrice,
                'province' => $provinceId,
                'district' => $districtId,
            );

            // giam so luong san pham da mua
            foreach(session('cart') as $key => $value){
                $product = $this->Mproduct->getItem(['id' => $key], ['task'=>'get-item']);
                $params_prod['id']=$key;
                $params_prod['quantity_buy'] = $product['quantity_buy']+$value['quantity_cart'];
                $params_prod['quantity'] = $product['quantity'] - $value['quantity_cart'];
                $this->Mproduct->saveItem($params_prod, ['task'=>'reduce-product-number']);
            }

            //Insert to tbl_order
            $this->Morder->saveItem($mydata, ['task'=> 'add-item']);
            $req->session()->put('order_info',$mydata);



            // lưu tt đơn hàng và xóa session coupon
            $req->session()->pull('coupon_price');

            //Insert to tbl_orderdetail
            $get_order = $this->Morder->getItem($mydata, ['task' => 'get-order-by-code']);
            $orderid = $get_order['id'];
            $data=[];
            if($req->session()->has('cart')){
                $carts = $req->session()->get('cart');
                foreach ($carts as $key => $value){
                    $row = $this->Mproduct->getItem(['id'=>$key],['task'=>'get-item']);
                    if($row['sale'] > 0){
                        $price = (100-$row['sale'])*$row['price']/100;
                    }else{
                        $price = $row['price'];
                    }
                    $prices[] = round($price,-3);
                    $products[] = $key;
                    $quantities[] = $value['quantity_cart'];
                }
                $arrInfoOrder = [
                    'order_id' => $orderid,
                    'products' => json_encode($products),
                    'prices' => json_encode($prices),
                    'quantities' => json_encode($quantities),
                ];
                DB::table('order_detail')->insert($arrInfoOrder);
            }
            $req->session()->pull('cart');
            return redirect()->route($this->controllerName.'/thankyou');
        }
        return view($this->pathViewController. 'info-order', [
            'user' => $user,
            'provinces' => $provinces,
            'priceShip' => $priceShip
        ]);
    }

    public function thankyou(Request $req){
        if($req->session()->has('order_info')){
            if($req->session()->has('customerInfo')){
                $customerInfo = $req->session()->get('customerInfo');
            }else{
                $customerInfo = $req->session()->get('info-customer');
            }
            $list = $this->Morder->getItem($req->session()->get('order_info'), ['task'=> 'get-order-by-code']);
            
            $data = array(
                'order' => $list,
                'customer' => $customerInfo,
                'province' => DB::table('province')->where('id',$list['province'])->first()->name,
                'district' => DB::table('district')->where('id',$list['district'])->first()->name,
                'coupon' => $list['coupon'],

            );
            
            Mail::send('email.check_info_order_email',compact('data'),function ($email) use ($customerInfo){
                $email->subject('Smart Store - Thông tin đơn hàng');
                $email->to($customerInfo['email'], $customerInfo['fullname']);
            });
            if($req->session()->has('info-customer')){
                $datax= $req->session()->get('info-customer');
                $this->Mcustomer->saveItem($datax,['task'=>'update-email-customer-empty']);
            }
            
            return view($this->pathViewController.'/thankyou',[
                'customer' => $customerInfo,
                'order'     => $list,
                'province'   => $data['province'],
                'district'  => $data['district']
            ]);
        }   
        
    }

    public function district(Request $request){
        if($request->provinceid){
            $list = DB::table('district')->where('provinceid', $request->provinceid)->get();
            $html="<option value =''>--- Chọn quận huyện ---</option>";
            foreach ($list as $row) 
            {
                $html.='<option value = '.$row->id.'>'.$row->name.'</option>';
            }
            return response()->json(['district_component'=> $html, 'code' => 200],200);
        }
    }

    public function coupon(Request $req){
        $d=getdate();
        $today=$d['year']."-".$d['mon']."-".$d['mday'];
        $html='';
        if($req->session()->has('coupon_price')){
         $html.='<p>Mỗi đơn hàng chỉ áp dụng 1 Mã giảm giá !!</p>';
        }else{
            if(!$req->code){
                $html.='<p>Vui lòng nhập Mã giảm giá nếu có !!</p>';
            }else{
                 // KIỂM TRA SỐ TIỀN TRONG GIỎ HÀNG
                $money = 0;
                $data=$req->session()->get('cart');
                foreach ($data as $key => $value) {
                    if ($value['sale'] > 0) {
                        $price = (100 - $value['sale'])*$value['price']/100;
                    } else {
                        $price = $value['price'];
                    }
                    $money += $price* $value['quantity_cart'];
                }
                // KIỂM TRA MÃ GIẢM GIÁ CÓ TỒN TẠI KO
                $params['code'] = $req->code;
                $getcoupon = $this->Mcoupon->getItem($params, ['task' => 'get-item']);
                if(empty($getcoupon)) {
                $html.='<p>Mã giảm giá không tồn tại!</p>';
                }else{
                    if (strtotime($getcoupon['expiration_date']) <= strtotime($today)){
                        $html.='<p>Mã giảm giá '.$getcoupon['code'].' đã hết hạn sử dụng từ ngày '.$getcoupon['expiration_date'].' !</p>';
                    }else if($getcoupon['limit_number'] -$getcoupon['number_used'] == 0){
                        $html.='<p>Mã giảm giá '.$getcoupon['code'].' đã hết số lần nhập !</p>';
                    }else if($getcoupon['payment_limit'] >= $money ){
                        $html.='<p> Mã giảm giá này chỉ áp dụng cho đơn hàng từ '.number_format($getcoupon['payment_limit']).' đ trở lên !</p>';
                    }else{
                        $html.=' <p>Mã giảm giá '.$getcoupon['code'].' đã được kích hoạt !</p>';
                        $req->session()->put('coupon_price',$getcoupon);
                    }  
                }
            }

        }
        $getPriceShip = DB::table('config')->where('id',1)->first();
        $priceShip = $getPriceShip->priceShip; 
        $orderInfoComponent = view($this->pathViewController.'component.order_info',compact('priceShip'))->render();
        return response()->json([
        'coupon_component'=> $html,
        'orderInfoComponent' => $orderInfoComponent,
        'code' => 200],200);
    }

    public function removeCoupon(Request $req){
        $html='';
        $req->session()->pull('coupon_price');
        $getPriceShip = DB::table('config')->where('id',1)->first();
        $priceShip = $getPriceShip->priceShip; 
        $orderInfoComponent = view($this->pathViewController.'component.order_info',compact('priceShip'))->render();
        return response()->json([
            'coupon_component'=> $html,
            'orderInfoComponent' => $orderInfoComponent,
            'code' => 200],200);
    }
    
}
