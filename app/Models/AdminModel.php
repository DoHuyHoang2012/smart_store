<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class AdminModel extends Model
{
    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    
    protected $table            = '';
    protected $folderUpload     = '' ;
    protected $fieldSearchAccepted   = [
        'id',
        'name'
    ]; 

    protected $crudNotAccepted = [
        '_token',
        'thumb_current',
    ];

    public function deleteThumb($thumbName){
        Storage::disk('vn_storage_image')->delete($this->folderUpload.'/'.$thumbName); 

    }

    public function deleteThumbs($thumbNames){
        $thumbNames = explode('#', $thumbNames);
        
        foreach($thumbNames as $val){
            Storage::disk('vn_storage_image')->delete($this->folderUpload.'/'.$val);
        }
    }

    public function uploadThumb($thumbObj){
        $thumbName = Str::random(10).'.'.$thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $thumbName, 'vn_storage_image');
        return $thumbName;
    }

    public function uploadThumbs($thumbObjs){
        foreach($thumbObjs as $img){
            $thumbName = Str::random(10).'.'.$img->clientExtension();
            $thumbNames[] =  $thumbName;
            $img->storeAs($this->folderUpload, $thumbName, 'vn_storage_image');
        }
        $thumbNames = implode('#', $thumbNames);
        
        return $thumbNames;
    }


    public function prepareParams($params){
        return  array_diff_key($params,array_flip($this->crudNotAccepted));
    }
}
