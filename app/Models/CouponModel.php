<?php
namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;


class CouponModel extends AdminModel 
{
    public function __construct()
    {
        $this->table               = 'discount';
        $this->folderUpload        = 'coupon';
        $this->fieldSearchAccepted = ['id', 'name'];
        $this->crudNotAccepted     = ['_token'];
    }

    public function listItems($params = null, $options = null){
        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id','code','discount','payment_limit','limit_number','expiration_date','status')            
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
            $query = $this->select('id','code','discount','payment_limit','limit_number','expiration_date','status')->where('trash', '=', 1);
        
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
            $result = $query->orderBy('id','desc')->paginate($params['pagination']['totalItemsPerPage']);
            
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
            $params['created']  = date('Y-m-d H:m:s');
           $params['number_used'] = 0;
            self::insert($this->prepareParams($params)); 
        }

        if ($options['task'] == 'edit-item') {
            
            self::where('id', $params['id'])->update($this->prepareParams($params)); 
        }

        if ($options['task'] == 'update-number-used') {
            self::where('code', $params['code'])->update(['number_used'=> $params['number_used']]); 
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
            $result = self::select('id','code','discount','payment_limit','limit_number','expiration_date','status','number_used')->where('code', $params['code'])->first();
        }

        if ($options['task'] == 'admin-get-item') {
            $result = self::select('id','code','discount','payment_limit','limit_number','expiration_date','status','number_used','description')->where('id', $params['id'])->first();
        }

        return $result;
    }

}
