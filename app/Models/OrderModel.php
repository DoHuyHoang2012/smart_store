<?php
namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;


class OrderModel extends AdminModel 
{
    public function __construct()
    {
        $this->table               = 'order';
        $this->folderUpload        = 'order';
        $this->fieldSearchAccepted = ['o.id', 'c.fullname', 'c.phone','o.code_order'];
        $this->crudNotAccepted     = ['_token'];
    }

    public function listItems($params = null, $options = null){
        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = self::from($this->table. ' as o' )->select('o.id', 'o.order_code', 'o.money', 'o.order_date', 'o.status', 'o.status','c.fullname','c.phone')
                            ->leftJoin('customer as c', 'o.customer_id', '=', 'c.id')
                            ->where('o.trash', '=' , 0);
            if ($params['filter']['status'] !== 'all') {
                if($params['filter']['status'] == 'default'){
                    $query->where(function($query) use ($params){
                        foreach($params['status'] as $key => $val){
                            $query->Where('o.status', '!=', $key);
                        }        
                    });
                }else {
                    $query->where('o.status', '=', $params['filter']['status']);
                }
                }
               
            if($params['search']['value'] !== ""){
                if($params['search']['field'] == 'all'){
                    $query->where(function($query) use ($params){
                        foreach($this->fieldSearchAccepted as $column){
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }        
                    });
                }else if(in_array($params['search']['field'],$this->fieldSearchAccepted)){
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }
            $result = $query->orderBy('id','desc')
                    ->paginate($params['pagination']['totalItemsPerPage']);
            
        }

        if($options['task'] == 'recycle-bin-list-items'){
            $query = self::from($this->table. ' as o' )->select('o.id', 'o.order_code', 'o.money', 'o.order_date', 'o.status', 'o.status','c.fullname','c.phone')
                            ->leftJoin('customer as c', 'o.customer_id', '=', 'c.id')
                            ->where('o.trash', '=' , 1);
        
            if($params['search']['value'] !== ""){
                if($params['search']['field'] == 'all'){
                    $query->where(function($query) use ($params){
                        foreach($this->fieldSearchAccepted as $column){
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }        
                    });
                }else if(in_array($params['search']['field'],$this->fieldSearchAccepted)){
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }
            $result = $query->paginate($params['pagination']['totalItemsPerPage']);
            
        }

        
       
        if ($options['task'] == 'list-order-follow-month') {
            $query = self::select('id', 'order_code', 'money', 'order_date', 'status')
            ->where('trash','=', 0)
            ->where('status','=', 2)
            ->whereYear('order_date',$params['year'])
            ->whereMonth('order_date',$params['month']);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'list-order-not-approved-yet') {
            $query = self::select('id', 'order_code', 'money', 'order_date', 'status')
            ->where('customer_id','=', $params['id'])
            ->where('status','=', 0)->orderBy('order_date','desc');
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'list-order-approved') {
            $query = self::select('id', 'order_code', 'money', 'order_date', 'status')
            ->where('customer_id','=', $params['id'])
            ->where('status','!=', 0)->orderBy('order_date','desc');
            $result = $query->get()->toArray();
        }

        return $result;
    }

    public function countItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-count-items-group-by-status') {
            $query = $this::groupBy('status')
                            ->select(DB::raw('count(id) as count, status'))
                            ->where('trash','=',0);

           
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'recycle-bin-count-items') {
            $query = $this::select(DB::raw('count(id) as count'))
                            ->where('trash','=', 1);

           
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'header-not-approved-count-items') {
            $query = $this::select(DB::raw('count(id) as count'))
                            ->where('status', '=', 0)
                            ->where('trash','=', 0);

           
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'header-approved-count-items') {
            $query = $this::select(DB::raw('count(id) as count'))
                            ->where('status', '=', 1)
                            ->where('trash','=', 0);

           
            $result = $query->get()->toArray();
        }
        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'change-status') {
           
            self::where('id', $params['id'])
                ->update(['status' => $params['currentStatus']]);
        }

        if ($options['task'] == 'cancel-order') {
            $status = $params['status'];
            self::where('id', $params['id'])
                ->update(['status' => $status]);
        }

        if ($options['task'] == 'restore-item') {
            self::where('id', $params['id'])
                ->update(['trash' => '0']);
        }

        if ($options['task'] == 'add-item') {
            $params['order_date']  = date('Y-m-d H:m:s');
            self::insert($this->prepareParams($params)); 
        }

        if ($options['task'] == 'edit-item') {
            $userInfo = session('userInfo');
            $params['updated_by'] = $userInfo['fullname'];
            $params['updated_at']  = date('Y-m-d H:m:s');
            
            self::where('id', $params['id'])->update($this->prepareParams($params)); 
        }
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'trash') {
            self::where('id', $params['id'])->update(['trash' => '1']);
        }    

        if ($options['task'] == 'delete-item') {
           
            self::where('id', $params['id'])->delete();
        }    
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = self::from($this->table. ' as o' )->select('o.id', 'o.order_code', 'o.money', 'o.order_date', 'o.status', 'o.address','o.coupon','o.province','o.price_ship', 'o.district', 'c.fullname','c.phone')
            ->leftJoin('customer as c', 'o.customer_id', '=', 'c.id')
            ->where('o.id', $params['id'])->first();
        }

        

        if ($options['task'] == 'get-order-by-code') {
            $result = self::from($this->table. ' as o' )->select('o.id', 'o.order_code', 'o.money', 'o.order_date', 'o.district','o.province', 'o.address','o.price_ship','o.coupon','c.fullname','c.phone')
            ->leftJoin('customer as c', 'o.customer_id', '=', 'c.id')
            ->where('o.order_code', $params['order_code'])->first();
        }

        return $result;
    }

}
