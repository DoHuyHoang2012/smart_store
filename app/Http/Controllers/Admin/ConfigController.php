<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfigModel as MainModel;
use Illuminate\Http\Request;
use App\Http\Requests\ConfigRequest as MainRequest;

class ConfigController extends Controller
{
  private $pathViewController = 'admin.pages.config.'; 
  private $controllerName     = 'config';
  private $model;
  private $params = [];

  public function __construct(){
    $this->model = new MainModel();
    $this->params['pagination']['totalItemsPerPage'] = 5;
    view()->share('controllerName', $this->controllerName);
  }

  public function index(Request $request){

    $item = $this->model->getItem(null, ['task' => 'get-item']);
    
    return view($this->pathViewController. 'index', [
      'item' => $item
    ]);
  }

  

  public function save(MainRequest $request){
    if($request->method() == 'POST'){
      $params = $request->all();
      $notify = 'Cập nhật phần tử thành công';
      
      $this->model->saveItem($params, ['task' => 'edit-item']);
      config([
        'mail.default' => 'smtp',
        'mail.mailers.smtp.host' => 'smtp.gmail.com',
        'mail.mailers.smtp.port' =>  '587',
        'mail.mailers.smtp.encryption' => 'tls',
        'mail.mailers.smtp.username' => $params['mail_smtp'],
        'mail.mailers.smtp.password' => $params['mail_smtp_password'],
        'mail.from.address' => $params['mail_smtp'],  
        'mail.from.name'    => $params['mail_from_name']
      ]);
      return redirect()->route($this->controllerName)->with('vn_notify', $notify);
    }
  }
  
}
