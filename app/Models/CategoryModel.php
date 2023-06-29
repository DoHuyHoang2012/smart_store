<?php
namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;


class CategoryModel extends AdminModel 
{
    public function __construct()
    {
        $this->table               = 'category';
        $this->folderUpload        = 'category';
        $this->fieldSearchAccepted = ['id', 'name', 'parent_id'];
        $this->crudNotAccepted     = ['_token'];
    }

    public function listItems($params = null, $options = null){
        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id','name','parent_id','created_at','created_by','status')            
                            ->where('trash', '=' , 0);
            if ($params['filter']['status'] !== 'all') {
                $query->where('status', '=', $params['filter']['status']);
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
            $query = $this->select('id','name','created_at','created_by','link')->where('trash', '=', 1);
        
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

        
        if ($options['task'] == 'shop-list-items') {
            $query = $this->select('id','name')
                            ->where('status', '=', 1)
                            ->where('trash', '=', 0)
                            ->where('parent_id', '=', 0);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'shop-list-items-sub-category') {
            $query = $this->select('id','name')
                            ->where('status', '=', 1)
                            ->where('trash', '=', 0)
                            ->where('parent_id', '=', $params['parent_id']);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'admin-list-items-in-selectbox') {
            $query = $this->select('id', 'name')
                            ->where('status', '=', 1)
                            ->where('trash', '=', 0)
                            ->orderBy('name', 'asc');
            $result = $query->pluck('name','id')->toArray();
        }

        if ($options['task'] == 'admin-list-order-in-selectbox') {
            $query = $this->select('orders', 'name','parent_id')
                            ->where('status', '=', 1)
                            ->where('trash', '=', 0)
                            ->orderBy('orders', 'asc');
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

        if ($options['task'] == 'add-item') {
            $userInfo = session('userInfo');
            $params['created_by'] = $userInfo['fullname'];
            $params['created_at']  = date('Y-m-d H:m:s');
            $params['link']        = Str::slug($params['name']);
            if($params['parent_id'] == 0){
                $params['level'] = 1;
            }else{
                $result = self::select('level')->where('id', $params['parent_id'])->first();
                $params['level'] =  $result['level'] + 1;
            }
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
            $result = self::select('id', 'name', 'parent_id', 'status', 'orders')->where('id', $params['id'])->first();
        }

        if ($options['task'] == 'category-name-parent') {
            $result = self::select('name')->where('id', $params['parent_id'])->first();
        }

        if ($options['task'] == 'category-name') {
            $result = self::select('name')->where('id', $params['category_id'])->first();
        }

        

        return $result;
    }

}
