<?php
namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 
use DB;


class ProductModel extends AdminModel 
{
    public function __construct()
    {
        $this->table               = 'product';
        $this->folderUpload        = 'product';
        $this->fieldSearchAccepted = ['id', 'name'];
        $this->crudNotAccepted     = ['_token', 'avatar_current','images_current','images','quantity_add'];
    }

    public function listItems($params = null, $options = null){
        if ($options['task'] == 'admin-list-items') {
            $query = self::from($this->table. ' as p' )->select('p.id', 'p.name', 'p.avatar', 'p.quantity', 'p.quantity_buy', 'p.status','c.name as category_name')
                            ->leftJoin('category as c', 'p.cat_id', '=', 'c.id')
                            ->where('p.trash', '=' , 0);
            if ($params['filter']['status'] !== 'all') {
                $query->where('p.status', '=', $params['filter']['status']);
            }

            if($params['search']['value'] !== ""){
                if($params['search']['field'] == 'all'){
                    $query->where(function($query) use ($params){
                        foreach($this->fieldSearchAccepted as $column){
                            $query->orWhere('p.'.$column, 'LIKE', "%{$params['search']['value']}%");
                        }        
                    });
                }else if(in_array($params['search']['field'],$this->fieldSearchAccepted)){
                    $query->where('p.'.$params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }
            
            $result = $query->orderBy('p.id','desc')
                    ->paginate($params['pagination']['totalItemsPerPage']);

        }

        if($options['task'] == 'recycle-bin-list-items'){
            $query = $this->select('id','name','avatar', 'created','created_by')->where('trash', '=', 1);
        
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

        if ($options['task'] == 'shop-list-items-sale-hot') {
            $query = $this->select('id', 'name', 'avatar', 'sale', 'price')
                            ->where('status', '=', 1)
                            ->where('trash', '=', 0)
                            ->orderBy('sale','desc')
                            ->orderBy('modified','desc')
                            ->take($params['limit']);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'shop-list-items-best-seller') {
            $query = $this->select('id', 'name', 'avatar', 'sale', 'price')
                            ->where('status', '=', 1)
                            ->where('trash', '=', 0)
                            ->orderBy('quantity_buy','desc')
                            ->orderBy('modified','desc')
                            ->take(10);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'shop-list-items-related') {
            $query = $this->select('id', 'name', 'avatar', 'sale', 'price')
                            ->where('id', '!=', $params['product_id'])
                            ->where('cat_id', '=', $params['category_id'])
                            ->where('status', '=', 1)
                            ->where('trash', '=', 0)                         
                            ->orderBy('created','desc');
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'shop-list-items') {
            $data = explode('-', $params['filter']['sort_by']);
            $query = $this->select('id', 'name', 'avatar', 'sale', 'price')
                            ->where('status', '=', 1)
                            ->where('trash', '=', 0);
                            if($params['search']['value'] !== ""){
                                $query->where('name', 'LIKE', "%{$params['search']['value']}%");
                            }
                            $query->orderBy($data[0] ,$data[1]);
            $result = $query->paginate($params['pagination']['totalItemsPerPage']);
        }

        if ($options['task'] == 'shop-list-items-featured') {
            $query = $this->select('id', 'name', 'avatar', 'sale', 'price','alias')
                            ->where('status', '=', 1)
                            ->where('trash', '=', 0);
                            $query->where(function($query) use ($params){
                                foreach($params['category_id'] as $val){
                                    $query->orWhere('cat_id', '=', $val['id']);
                                }        
                            });
                            $query->orderBy('modified','desc')
                            ->take(10);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'shop-list-items-in-cat-parent') {
            $data = explode('-', $params['filter']['sort_by']);
            $query = $this->select('id', 'name', 'avatar', 'sale', 'price','alias')
                            ->where('status', '=', 1)
                            ->where('trash', '=', 0);
                            $query->where(function($query) use ($params){
                                foreach($params['arrCat'] as $val){
                                    $query->orWhere('cat_id', '=', $val['id']);
                                }        
                            });
                            $query->orderBy($data[0] ,$data[1]);
            $result = $query->paginate($params['pagination']['totalItemsPerPage']);
        }


        if ($options['task'] == 'shop-list-items-in-category') {
            $data = explode('-', $params['filter']['sort_by']);
            $query = $this->select('id', 'name', 'avatar', 'sale', 'price')
                            ->where('status', '=', 1)
                            ->where('trash', '=', 0)
                            ->where('cat_id', '=', $params['category_id'])                 
                            ->orderBy($data[0] ,$data[1]);
            $result = $query->paginate($params['pagination']['totalItemsPerPage']);
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
        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'change-status') {
            $status = ($params['currentStatus'] == '0')? '1' : '0';
            self::where('id', $params['id'])
                ->update(['status' => $status]);
        }

        if ($options['task'] == 'restore-item') {
            self::where('id', $params['id'])
                ->update(['trash' => '0']);
        }

        if ($options['task'] == 'reduce-product-number') {
            self::where('id', $params['id'])
                ->update([
                    'quantity' => $params['quantity'],
                    'quantity_buy'=>$params['quantity_buy']
                ]);
        }

        if ($options['task'] == 'add-item') {
            $userInfo = session('userInfo');
            $params['created_by'] = $userInfo['fullname'];
            $params['created']  = date('Y-m-d H:m:s');
            $params['modified_by'] = $userInfo['fullname'];
            $params['modified']  = date('Y-m-d H:m:s');
            $params['avatar'] = $this->uploadThumb($params['avatar']);
            $params['image'] = $this->uploadThumbs($params['images']);
            $params['alias']        = Str::slug($params['name']);
            self::insert($this->prepareParams($params)); 
        }

        if ($options['task'] == 'edit-item') {
            $userInfo = session('userInfo');
            $params['modified_by'] = $userInfo['fullname'];
            $params['modified']  = date('Y-m-d H:m:s');
            if(!empty($params['avatar'])){
                $this->deleteThumb($params['avatar_current']);
                $params['avatar'] = $this->uploadThumb($params['avatar']);
            }
            if(!empty($params['image'])){
                $this->deleteThumb($params['images_current']);
                $params['image'] = $this->uploadThumbs($params['image']);
            }
            self::where('id', $params['id'])->update($this->prepareParams($params)); 
        }

        if($options['task'] == 'import-item'){
            $params['quantity']  = $params['quantity'] + $params['quantity_add'];
            
            self::where('id', $params['id'])->update($this->prepareParams($params)); 
        }
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'trash') {
            self::where('id', $params['id'])->update(['trash' => '1']);
        }    

        if ($options['task'] == 'delete-item') {
            $item = self::getItem($params,['task'=>'get-thumb']);
            $this->deleteThumb($item['avatar']);
            self::where('id', $params['id'])->delete();
            $this->deleteThumbs($item['image']);
            self::where('id', $params['id'])->delete();
        }    
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = self::select('id', 'name', 'cat_id','producer_id', 'shortDesc','detail', 'price', 'sale', 'quantity', 'quantity_buy','image', 'avatar', 'status')->where('id', $params['id'])->first();
        }

        if ($options['task'] == 'get-thumb') {
            $result = self::select('id', 'image', 'avatar')->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'get-detail') {
            $result =  self::from($this->table. ' as p' )->select('p.id', 'p.name','p.detail', 'p.shortDesc','p.cat_id', 'p.image', 'p.quantity', 'p.quantity_buy', 'p.sale', 'p.price','p.status','c.name as category_name')
                        ->leftJoin('category as c', 'p.cat_id', '=', 'c.id')
                        ->where('p.id', $params['product_id'])->first();
        }


        return $result;
    }

}
