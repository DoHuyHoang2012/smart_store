<?php
namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use DB;


class CustomerModel extends AdminModel 
{   
    protected $fillable = ['title'];
    public function __construct()
    {
        $this->table               = 'customer';
        $this->folderUpload        = 'customer';
        $this->fieldSearchAccepted = ['id', 'username', 'fullname','email', 'phone','address'];
        $this->crudNotAccepted     = ['_token','form_type', 'password_confirmation'];
    }

    public function listItems($params = null, $options = null){
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id','email','fullname','phone','status')         
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
            $params['created']  = date('Y-m-d H:m:s');
            $params['password']  = md5($params['password']);
            self::insert($this->prepareParams($params)); 
        }

        if ($options['task'] == 'add-item-customer') {
            $params['created']  = date('Y-m-d H:m:s');
            $params['username'] = '';
            $params['password'] = '';
            $params['status'] = 1;
            self::insert($this->prepareParams($params)); 
        }

        if ($options['task'] == 'edit-item') {
           $params['email'] = empty($params['email']) ? '' : $params['email']; 
            
            self::where('id', $params['id'])->update($this->prepareParams($params)); 
        }

        if ($options['task'] == 'update-email-customer-empty') {    
            self::where('email', $params['email'])->update(['email'=>'']); 
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
           
            self::where('id', $params['id'])->delete();
        }    
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = self::select('id', 'fullname', 'username','email','phone', 'status')->where('id', $params['id'])->where('trash', '=',0)->first();
        }

        if ($options['task'] == 'get-item-email') {
            $result = self::select('id', 'fullname', 'username','email','phone')->where('email', $params['email'])
            ->where('trash', 0)->first();
        }

        if ($options['task'] == 'auth-login') {
            $query = self::select('id', 'username', 'email', 'fullname', 'phone','status')
            ->where('status', 1)
            ->where('password', md5($params['password']));
            $query->where(function($query) use ($params){
                $query->where('username', $params['username'])
                        ->orWhere('email', $params['username']);      
            });
            if($query->first()) $result = $query->first()->toArray();
        }

        return $result;
    }

}
