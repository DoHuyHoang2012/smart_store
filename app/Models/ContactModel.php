<?php
namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use DB;


class ContactModel extends AdminModel 
{
    public function __construct()
    {
        $this->table               = 'contact';
        $this->folderUpload        = 'contact';
        $this->fieldSearchAccepted = ['id', 'fullname','email'];
        $this->crudNotAccepted     = ['_token'];
    }

    public function listItems($params = null, $options = null){
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id','title','fullname','created_at','email')            
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
            $query = $this->select('id','title','img','created','created_by')->where('trash', '=', 1);
        
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
        if ($options['task'] == 'restore-item') {
            self::where('id', $params['id'])
                ->update(['trash' => '0']);
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
            $result = self::select('id','title','fullname','created_at','email','phone','content')->where('id', $params['id'])->first();
        }

        return $result;
    }

}
