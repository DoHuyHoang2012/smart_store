<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Http\Requests\AdminLoginRequest as MainRequest;

class AuthController extends Controller
{
  private $pathViewController = 'admin.pages.auth.'; 
  private $controllerName     = 'auth';
  private $model;
  private $params = [];

  public function __construct(){
   
    view()->share('controllerName', $this->controllerName);
  }

  public function login(Request $request){
    return view($this->pathViewController.'login');
  }

  public function postLogin(MainRequest $request)
  {
    if($request->method() == 'POST'){
      $params = $request->all();
      $userModel = new UserModel();
      $userInfo = $userModel->getItem($params, ['task' => 'auth-login']);
      if(!$userInfo) return redirect()->route($this->controllerName.'/login')->with('auth_notify', 'Tài khoản hoặc mật khẩu không chính xác vui lòng nhập lại!');
      $request->session()->put('userInfo', $userInfo);
      return redirect()->route('dashboard');
    }
  }

  public function logout(Request $request){
    if($request->session()->has('userInfo')) $request->session()->pull('userInfo');
    return redirect()->route('auth/login');
  }
}
