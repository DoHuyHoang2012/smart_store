<?php

namespace App\Http\Controllers\Shop;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CustomerModel as MainModel;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Http\Requests\AuthRequest as MainRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccountController extends Controller
{
   private $pathViewController = 'shop.pages.account.'; 
   private $controllerName     = 'account';
   private $model;
   private $Morder;
   public function __construct()
   {
      $this->Morder = new OrderModel();
      $this->model = new MainModel();
        view()->share('controllerName', $this->controllerName);
   }

   public function index(Request $req){ 
    if(!$req->session()->has('customerInfo')) return redirect()->route($this->controllerName.'/login');
    $customer = $req->session()->get('customerInfo');
    $orderNon = $this->Morder->listItems(['id'=>$customer['id']], ['task'=> 'list-order-not-approved-yet']);
    $order    = $this->Morder->listItems(['id'=>$customer['id']], ['task'=> 'list-order-approved']);
    return view($this->pathViewController. 'index',[
      'orderNon' => $orderNon,
      'order' => $order
    ]);
  }

  public function order(Request $req){
   
    $MorderDetail = new OrderDetailModel();
    $orderDetail = $MorderDetail->getItem(['id'=>$req->order], ['task'=>'get-item']);
    $order = $this->Morder->getItem(['id'=>$req->order], ['task'=>'get-item']);
    $province = DB::table('province')->where('id',$order['province'])->first()->name;
    $district = DB::table('district')->where('id',$order['district'])->first()->name;
    return view($this->pathViewController. 'detail',[
        'orderDetail' => $orderDetail,
        'order'     => $order,
        'province' => $province,
        'district' => $district,
    ]);
}

public function changePass(Request $req){
   
  return view($this->pathViewController. 'reset_password');
}

public function updatePass(Request $request){
  $oldpass = DB::table('customer')->where('id',$request->customer)->first()->password;
 
  $request->validate([
    'old_password' => 'required',
    'new_password' => 'required|confirmed',
]);

if(md5($request->old_password) != $oldpass ){
  return back()->with("no", "Mật khẩu cũ không đúng!");
}
DB::table('customer')->where('id',$request->customer)->update([
  'password' => md5($request->new_password)
]);
return back()->with("yes", "Thay đổi mật khẩu thành công!");
}


}
