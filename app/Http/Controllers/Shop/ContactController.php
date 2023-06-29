<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ContactModel as MainModel;

class ContactController extends Controller
{
   private $pathViewController = 'shop.pages.contact.'; 
   private $controllerName     = 'contact';

   public function __construct()
   {
          $this->model = new MainModel();
          view()->share('controllerName', $this->controllerName);
   }

   public function index()
   { 
     
     return view($this->pathViewController. 'index', [
          
     ]);
   }

   public function postEmail(Request $req){
     if($req->method() == 'POST'){
       $req->validate([
         'fullname' => 'required',
         'email' => 'bail|required|email',
         'phone' => 'required',
         'title' => 'required',
         'content' => 'required'
       ],[
         'email.email' => 'Vui lòng nhập địa chỉ email hợp lệ',
         'phone.required' => 'Vui lòng nhập số điện thoại',
         'fullname.required' => 'Vui lòng nhập họ và tên',
         'title.required' => 'Vui lòng nhập tiêu đề',
         'content.required' => 'Vui lòng nhập nội dung',
         'email.required' => 'Vui lòng nhập địa chỉ email',
       ]);
       $params = $req->all();
       $this->model->saveItem($params, ['task'=> 'add-item']);
       
       return back()->with('yes', 'Tin nhắn của bạn đã được gửi thành công!');
     }
    
 
   }
}
