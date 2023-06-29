<?php
namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use DB;


class SliderModel extends AdminModel 
{
    public function __construct()
    {
        $this->table               = 'slider';
        $this->folderUpload        = 'slider';
        $this->fieldSearchAccepted = ['id', 'name', 'link'];
        $this->crudNotAccepted     = ['_token', 'thumb_current'];
    }

    public function listItems($params = null, $options = null){
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id','name','img','link','created','created_by','modified','modified_by','status')            
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
            $query = $this->select('id','name','img','link')->where('trash', '=', 1);
        
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
            $query = $this->select('id','name','img','link')
                            ->where('status', '=', 1)
                            ->where('trash', '=', 0)
                            ->limit(5);
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
            $params['img'] = $this->uploadThumb($params['img']);
            $params['created_by'] = $userInfo['fullname'];
            $params['created']  = date('Y-m-d');
            self::insert($this->prepareParams($params)); 
        }

        if ($options['task'] == 'edit-item') {
            if(!empty($params['img'])){
                $this->deleteThumb($params['thumb_current']);
                $params['img'] = $this->uploadThumb($params['thumb']);
            }
            $userInfo = session('userInfo');
            $params['modified_by'] = $userInfo['fullname'];
            $params['modified']  = date('Y-m-d');
            
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
            $this->deleteThumb($item['img']);
            self::where('id', $params['id'])->delete();
        }    
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = self::select('id', 'name', 'link', 'status', 'img')->where('id', $params['id'])->first();
        }

        if ($options['task'] == 'get-thumb') {
            $result = self::select('id', 'img')->where('id', $params['id'])->first();
        }

        return $result;
    }

}
