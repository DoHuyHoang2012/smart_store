<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserModel as MainModel;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest as MainRequest;

class UserController extends Controller
{
  private $pathViewController = 'admin.pages.user.'; 
  private $controllerName     = 'user';
  private $model;
  private $params = [];

  public function __construct(){
    $this->model = new MainModel();
    $this->params['pagination']['totalItemsPerPage'] = 5;
    view()->share('controllerName', $this->controllerName);
  }

  public function index(Request $request){
    $this->params['filter']['status'] = $request->input('filter_status', 'all');
    $this->params['search']['field'] = $request->input('search_field', '');
    $this->params['search']['value'] = $request->input('search_value', '');
    $items = $this->model->listItems($this->params, ['task' => 'admin-list-items']);
    $itemsStatusCount = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-status']);
    $itemsCount = $this->model->countItems($this->params, ['task' => 'recycle-bin-count-items']);
    
    return view($this->pathViewController. 'index' , [
      'params' => $this->params,
      'items' => $items,
      'itemsStatusCount' => $itemsStatusCount,
      'itemsCount' => $itemsCount,
    ]);
  }

  public function status(Request $request){
    $this->params['id'] = $request->id;
    $this->params['currentStatus'] = $request->status;
    $this->model->saveItem($this->params, ['task'=> 'change-status']);
    $status = ($this->params['currentStatus'] == '1')? '0' : '1';
    $link = route($this->controllerName.'/status', ['status' => $status, 'id' => $request->id]);
    return response()->json([
      'statusObj'=> config('myconf.template.status')[$status],
      'link'  => $link
    ]);
  }

  public function delete(Request $request){
    $this->params['id'] = $request->id;
    $this->model->deleteItem($this->params, ['task'=> 'delete-item']);
    return redirect()->route($this->controllerName.'/recycleBin')->with('vn_notify', 'Xóa phần tử thành công!');
  }

  public function trash(Request $request){
    $this->params['id'] = $request->id;
    $this->model->deleteItem($this->params, ['task'=> 'trash']);
    return redirect()->route($this->controllerName)->with('vn_notify', 'Xóa phần tử thành công!');
  }

  public function restore(Request $request){
    $this->params['id'] = $request->id;
    $this->model->saveItem($this->params, ['task'=> 'restore-item']);
    return redirect()->route($this->controllerName.'/recycleBin')->with('vn_notify', 'Khôi phục phần tử thành công!');
  }

  public function form(Request $request){
    $item = null;
    if($request->id !== null){
      $params['id'] = $request->id;
      $item = $this->model->getItem($params, ['task' => 'get-item']);
    }
    return view($this->pathViewController. 'form', [
      'item' => $item
    ]);
  }

  public function save(MainRequest $request){
    if($request->method() == 'POST'){
      $params = $request->all();
      $task = 'add-item';
      $notify = 'Thêm phần tử thành công!';
      
      if($params['id'] !== null){
        $task = 'edit-item';
        $notify = 'Cập nhật phần tử thành công';
      }
      $this->model->saveItem($params, ['task' => $task]);
      return redirect()->route($this->controllerName)->with('vn_notify', $notify);
    }
  }

  public function changePassword(MainRequest $request){
    if($request->method() == 'POST'){
      $params = $request->all();
      $this->model->saveItem($params, ['task'=> 'change-password']);
      return redirect()->route($this->controllerName)->with('vn_notify', 'Thay đổi mật khẩu thành công!');
    }
  }

  public function changeRole(MainRequest $request){
    if($request->method() == 'POST'){
      $params = $request->all();
      $this->model->saveItem($params, ['task'=> 'change-role-post']);
      return redirect()->route($this->controllerName)->with('vn_notify', 'Thay đổi quyền thành công!');
    }
  }

  public function recycleBin(Request $request) {
    $this->params['search']['field'] = $request->input('search_field', '');
    $this->params['search']['value'] = $request->input('search_value', '');
    $items = $this->model->listItems($this->params, ['task' => 'recycle-bin-list-items']);
    $itemsCount = $this->model->countItems($this->params, ['task' => 'recycle-bin-count-items']);

    return view($this->pathViewController. 'recycle_bin', [
      'params' => $this->params,
      'items' => $items,
      'itemsCount' => $itemsCount,
    ]);
  }

  public function role(Request $request){
    $this->params['id'] = $request->id;
    $this->params['currentRole'] = $request->role;
    $this->model->saveItem($this->params, ['task'=> 'change-role']);
    return response()->json([
      'status' => 'success'
    ]);
  }

  
}
