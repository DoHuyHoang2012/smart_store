<?php

namespace App\Http\Controllers\Shop;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CustomerModel as MainModel;
use App\Models\CouponModel;
use App\Models\OrderModel;
use App\Http\Requests\AuthRequest as MainRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use App\Mail\RegisterMail;

class CustomerController extends Controller
{
   private $pathViewController = 'shop.pages.customer.'; 
   private $controllerName     = 'customer';
   private $model;
   private $Morder;
   public function __construct()
   {
      $this->Morder = new OrderModel();
      $this->model = new MainModel();
        view()->share('controllerName', $this->controllerName);
   }

   public function register()
   { 
     return view($this->pathViewController. 'register');
   }

   public function postRegister(MainRequest $request)
   { 
     if($request->method() == 'POST'){
      $params = $request->all();
      $token = strtoupper(Str::random(10));
      $params['token'] = $token;
      
      $checkRegister = $this->model->saveItem($params, ['task' => 'add-item']);
      
      
      $customer =  $this->model->where('token',$params['token'])->first();
      Mail::send('email.active_account',compact('customer'),function ($email) use ($customer){
        $email->subject('Smart Store - Kích hoạt tài khoản');
        $email->to($customer->email, $customer->fullname);
      });

      
     
      return redirect()->route($this->controllerName.'/register')->with('notify', 'Đăng ký thành công! Vui lòng xác nhận tài khoản của bạn qua email.');
    }
   }

   public function active(MainModel $customer, $token){
    if($customer->token === $token){
      $customer->where('token',$token)->update(['status'=> 1, 'token'=>null]);
      $today = date('Y-m-d');
      // giới hạn mã giảm giá mới có hạn 30 ngày từ khi đăng ký tài khoản
      $todaylimit = strtotime(date("Y-m-d", strtotime($today)) . " +1 month");
      $todaylimit = strftime("%Y-%m-%d", $todaylimit);
      $newcoupon = [
        'code' =>  strtoupper(Str::random(12)),
        'discount' => '100000',
        'limit_number' => '1',
        'number_used' => '0',
        'payment_limit' => '0',
        'expiration_date' => $todaylimit,
        'description' => 'Mã giảm giá 100.000 đ tự động khi đăng ký thành công',
      ];
      
      // Lưu tt mã và ngày giới hạn để gửi mail
      $mailData = [ 
      'tempcoupon' => $newcoupon['code'],
      'tempdatelimit' => $newcoupon['expiration_date']
      ];
      
     
      // tao mã giảm giá random
      $coupon = new CouponModel();
      $coupon->saveItem($newcoupon, ['task'=> 'add-item']);
      Mail::to($customer->email,$customer->fullname)->send(new RegisterMail($mailData));
      return redirect()->route($this->controllerName.'/login')->with('yes','Xác nhận tài khoản thành công. Bạn đã nhận được 1 mã giảm giá cho thành viên mới, vui lòng kiểm tra email !!');
    }else{
      return redirect()->route($this->controllerName.'/login')->with('no','Mã xác nhận bạn gửi không hợp lệ');
    }
   }

   public function login()
   { 
     return view($this->pathViewController. 'login');
   }

   public function postLogin(MainRequest $request){ 
     if($request->method() == 'POST'){
      $params = $request->all();
      $customerInfo = $this->model->where('email',$request->email)->orWhere('username',$request->username)->first();
      if($customerInfo){
        if($customerInfo->status == 0){
          if($request->session()->has('customerInfo')) $request->session()->pull('customerInfo');
          return redirect()->route($this->controllerName.'/login')->with('no', 'Tài khoản của bạn chưa được kích hoạt, vui lòng nhấn vào <a style="color: blue" href="'.route('customer/getActive').'">đây để kích hoạt</a>');
        }
        $request->session()->put('customerInfo', $customerInfo);
        return redirect()->route('home');
      } 
      return redirect()->route($this->controllerName.'/login')->with('notify', 'Tài khoản hoặc mật khẩu không chính xác, vui lòng nhập lại !');
    }
  }

    public function logout(Request $request){ 
      if($request->session()->has('customerInfo')) $request->session()->pull('customerInfo');
      return redirect()->route('home');
   }

   public function account(Request $req){ 
    if(!$req->session()->has('customerInfo')) return redirect()->route($this->controllerName.'/login');
    $customer = $req->session()->get('customerInfo');
    $orderNon = $this->Morder->listItems(['id'=>$customer['id']], ['task'=> 'list-order-not-approved-yet']);
    $order    = $this->Morder->listItems(['id'=>$customer['id']], ['task'=> 'list-order-approved']);
    return view($this->pathViewController. 'account-info/index',[
      'orderNon' => $orderNon,
      'order' => $order
    ]);
  }

  public function forgetPass(){
    return view($this->pathViewController.'forgetPassword');
  }

  public function postForgetPass(Request $req){
    if($req->method() == 'POST'){
      $req->validate([
        'email' => 'required|exists:customer'
      ],[
        'required' => 'Vui lòng nhập địa chỉ email hợp lệ',
        'exists'   => 'Email này không tồn tại trong hệ thống'
      ]);
      $token = strtoupper(Str::random(10));
      $this->model->where('email',$req->email)->update(['token'=>$token]);
      $customer = $this->model->where('email',$req->email)->first();
      
      Mail::send('email.check_email_forget',compact('customer'),function ($email) use ($customer){
        $email->subject('Smart Store - Lấy lại mật khẩu');
        $email->to($customer->email, $customer->name);
      });
      return redirect()->route('customer/login')->with('notify', 'Vui lòng check email để thực hiện thay đổi mật khẩu !');
    }
   

  }

  public function getPass(MainModel $customer, $token){
    if($customer->token == $token) {
      return view($this->pathViewController.'resetPassword',['customer'=>$customer]);
    }
    return abort(404);
  }

  public function postGetPass(MainModel $customer, $token, Request $req){
    if($req->method() == 'POST'){
      $req->validate([
        'password'=> 'required',
        'password_confirmation' => 'required|same:password'
       ]);
       $password_h = md5($req->password);
      
       $this->model->where('token',$token)->update(['password'=>$password_h, 'token'=>null]);
       return redirect()->route('customer/login')->with('notify', 'Đặt lại mật khẩu thành công !');
    }
  }

  public function getActive(){
    return view($this->pathViewController.'getActive');
  }

  public function postGetActive(Request $req){
    if($req->method() == 'POST'){
      $req->validate([
        'email' => 'required|exists:customer'
      ],[
        'required' => 'Vui lòng nhập địa chỉ email hợp lệ',
        'exists'   => 'Email này không tồn tại trong hệ thống'
      ]);
      $token = strtoupper(Str::random(10));
      $this->model->where('email',$req->email)->update(['token'=>$token]);
      $customer = $this->model->where('email',$req->email)->first();
      
      Mail::send('email.active_account',compact('customer'),function ($email) use ($customer){
        $email->subject('Smart Store - Kích hoạt tài khoản');
        $email->to($customer->email, $customer->fullname);
      });
      return redirect()->route('customer/login')->with('notify', 'Vui lòng check email để thực hiện thay đổi mật khẩu!');
    }
   

  }

}
