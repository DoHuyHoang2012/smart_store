<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderModel as MainModel;
use App\Models\OrderDetailModel;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest as MainRequest;

class OrderController extends Controller
{
  private $pathViewController = 'admin.pages.order.'; 
  private $controllerName     = 'order';
  private $model;
  private $params = [];

  public function __construct(){
    $this->model = new MainModel();
    $this->params['pagination']['totalItemsPerPage'] = 5;
    view()->share('controllerName', $this->controllerName);
  }

  public function index(Request $request){
    $this->params['filter']['status'] = $request->input('filter_status', 'all');
    $this->params['status'] = config('myconf.template.status_order');
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
   
    if($request->status == '0'){
      $status = 1;
      session()->flash('vn_notify','Cập nhật đơn hàng thành công !!');
      $confirm = "Xác nhận gói hàng và chuẩn bị giao hàng ?";
    }else if($request->status == '1'){
      $status = 2;
      session()->flash('vn_notify','Cập nhật đơn hàng thành công !!');
      $confirm = "Xác nhận đơn hàng đã giao và thanh toán thành công ?";
    }else {
      session()->flash('vn_notify','Đơn hàng đã giao và thanh toán, không thể chỉnh sửa !');
    }
    if(array_key_exists($status,config('myconf.template.order'))){
      $statusObj = config('myconf.template.order')[$status];
    }else {
      $statusObj = null;
    }
    $link = route($this->controllerName.'/status', ['status' => $status, 'id' => $request->id]);
    $this->params['currentStatus'] = $status;
    $this->model->saveItem($this->params, ['task'=> 'change-status']); 
    return response()->json([
      'statusObj'=> $statusObj,
      'link'  => $link,
      'confirm' => $confirm
    ]);
  }

  public function delete(Request $request){
    $this->params['id'] = $request->id;
    $this->model->deleteItem($this->params, ['task'=> 'delete-item']);
    return redirect()->route($this->controllerName.'/recycleBin')->with('vn_notify', 'Xóa phần tử thành công!');
  }

  public function trash(Request $request){
    $this->params['id'] = $request->id;
    $row=$this->model->getItem($this->params,['task'=>'get-item']);
    $status = $row['status'];
    if($status == 1){
      $notify = 'Đơn hàng '.$row['order_code'].' đang được giao, không thể lưu !';
    }else {
      $notify = 'Lưu đơn hàng '.$row['orderCode'].' thành công !!';
      $this->model->deleteItem($this->params, ['task'=> 'trash']);
    }
    
    return redirect()->route($this->controllerName)->with('vn_notify', $notify);
  }

  public function restore(Request $request){
    $this->params['id'] = $request->id;
    $this->model->saveItem($this->params, ['task'=> 'restore-item']);
    return redirect()->route($this->controllerName.'/recycleBin')->with('vn_notify', 'Khôi phục phần tử thành công!');
  }

  public function cancel(Request $request){
    $params['id'] = $request->id;
    $row=$this->model->getItem($params,['task'=>'get-item']);
    $status = $row['status'];
    if($status == 0 || $status == 1)
    {
      $params['status'] = 4;
      
      $this->model->saveItem($params, ['task' => 'cancel-order']);
      return redirect()->route($this->controllerName)->with('vn_notify', 'Hủy đơn thành công!');
    }
  }

  public function form(Request $request){
    $item = null;
    $categoryItems = $this->model->listItems(null, ['task' => 'admin-list-items-in-selectbox']);
    $items = $this->model->listItems($this->params, ['task' => 'admin-list-order-in-selectbox']);
    if($request->id !== null){
      $params['id'] = $request->id;
      $item = $this->model->getItem($params, ['task' => 'get-item']);

    }
    return view($this->pathViewController. 'form', [
      'item' => $item,
      'items' => $items,
      'categoryItems' => $categoryItems
    ]);
  }

  public function detail(Request $req){
    $order = $this->model->getItem(['id' => $req->id], ['task'=> 'get-item']);
    $ModerDetail = new OrderDetailModel();
    $orderDetail = $ModerDetail->getItem(['id' => $req->id], ['task'=> 'get-item']);
    
    return view($this->pathViewController. 'detail', [
      'order' => $order,
      'orderDetail' => $orderDetail
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
  
}
