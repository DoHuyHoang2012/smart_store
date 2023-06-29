<?php
namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use DB;


class UserModel extends AdminModel 
{
    public function __construct()
    {
        $this->table               = 'user';
        $this->folderUpload        = 'user';
        $this->fieldSearchAccepted = ['id', 'username', 'fullname','email', 'phone','address'];
        $this->crudNotAccepted     = ['_token','avatar_current', 'password_confirmation', 'task'];
    }

    public function listItems($params = null, $options = null){
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id','email','username','fullname','role','img','address','phone','status')
                            ->where('id', '!=', 1)            
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
            $query = $this->select('id','fullname','email','phone')->where('trash', '=', 1);
        
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

        return $result;
    }

    public function countItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-count-items-group-by-status') {
            $query = $this::groupBy('status')
                            ->select(DB::raw('count(id) as count, status'))->where('id', '!=', 1);

           
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'recycle-bin-count-items') {
            $query = $this::select(DB::raw('count(id) as count'))
                            ->where('trash','=', 1)->where('id', '!=', 1);

           
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

        if ($options['task'] == 'change-role') {
            $role = $params['currentRole'];
            self::where('id', $params['id'])
                ->update(['role' => $role]);
        }

        if ($options['task'] == 'restore-item') {
            self::where('id', $params['id'])
                ->update(['trash' => '0']);
        }

        if ($options['task'] == 'add-item') {
            if(!empty($params['img'])){
                $params['img'] = $this->uploadThumb($params['img']);
                
            }else{
                $params['img'] = 'user.png';
            }
            $userInfo = session('userInfo');
            $params['created_by'] = $userInfo['fullname'];
            $params['created']  = date('Y-m-d');
            $params['password']  = md5($params['password']);
            self::insert($this->prepareParams($params)); 
        }

        if ($options['task'] == 'edit-item') {
            if(!empty($params['img'])){
                $this->deleteThumb($params['avatar_current']);
                $params['img'] = $this->uploadThumb($params['img']);
            }
            
            self::where('id', $params['id'])->update($this->prepareParams($params)); 
        }

        if ($options['task'] == 'change-password') {
            $password = md5($params['password']);
            self::where('id', $params['id'])->update(['password' => $password]);
        }

        if ($options['task'] == 'change-role-post') {
            $role = $params['role'];
            self::where('id', $params['id'])->update(['role' => $role]);
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
            $result = self::select('id', 'fullname', 'username','email','address','gender','phone','role', 'status', 'img')->where('id', $params['id'])->first();
        }

        if ($options['task'] == 'get-thumb') {
            $result = self::select('id', 'img')->where('id', $params['id'])->first();
        }

        if ($options['task'] == 'auth-login') {
            $result = self::select('id', 'username', 'email', 'fullname', 'status', 'img','role','phone','address','gender')
            ->where('status', 1)
            ->where('username', $params['username'])
            ->where('password', md5($params['password']))
            ->first();
            if($result) $result = $result->toArray();
        }

        return $result;
    }

}
