<?php
namespace App\Helper;
use Illuminate\Support\Str;
class URL {
    public static function linkCategory($id, $name){
        return route('category/category',[
            'category_id'=>$id,
            'category_name'=>Str::slug($name)
        ]);
    }

    public static function linkProduct($id, $name){
        return route('product/index',[
            'product_id'=>$id,
            'product_name'=>Str::slug($name)
        ]);
    }

    public static function linkArticle($id, $name){
        return route('news/detail',[
            'id'=>$id,
            'article'=>Str::slug($name)
        ]);
    }
}