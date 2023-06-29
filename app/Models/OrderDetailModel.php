<?php
namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;


class OrderDetailModel extends AdminModel 
{
    public function __construct()
    {
        $this->table               = 'order_detail';
        $this->folderUpload        = 'order_detail';
        $this->fieldSearchAccepted = [];
        $this->crudNotAccepted     = ['_token'];
    }
   

    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = self::select('id', 'order_id', 'products', 'prices', 'quantities')
            ->where('order_id', $params['id'])->first();
        }

        return $result;
    }

}
