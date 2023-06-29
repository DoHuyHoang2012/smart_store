<?php
namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;


class ConfigModel extends AdminModel 
{
    public function __construct()
    {
        $this->table               = 'config';
        $this->folderUpload        = 'config';
        $this->fieldSearchAccepted = ['id', 'name'];
        $this->crudNotAccepted     = ['_token'];
    }

    
    public function saveItem($params = null, $options = null)
    {

        if ($options['task'] == 'edit-item') {
          
            self::where('id', $params['id'])->update($this->prepareParams($params)); 
        }

    }

   

    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = self::select('id','mail_smtp','mail_smtp_password','priceShip','title','mail_from_name')->where('id', 1)->first();
        }

        return $result;
    }

}
