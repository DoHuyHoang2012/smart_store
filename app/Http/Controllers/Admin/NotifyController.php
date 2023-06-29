<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class NotifyController extends Controller
{
  private $pathViewController = 'admin.pages.notify.'; 
  private $controllerName     = 'notify';
  private $model;
  private $params = [];

  public function __construct(){
    view()->share('controllerName', $this->controllerName);
  }

  public function index(){ 
    return view($this->pathViewController. 'index');
  }
  
}
