<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\NewsModel as MainModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;

class NewsController extends Controller
{
   private $pathViewController = 'shop.pages.news.'; 
   private $controllerName     = 'news';
   private $model;
   private $params = [];

   public function __construct(){      

     $this->model = new MainModel();
     $this->params['pagination']['totalItemsPerPage'] = 6;
     view()->share('controllerName', $this->controllerName);
   }

   public function index(Request $request){ 
     $Mcategory = new CategoryModel();
     $itemsCategory   = $Mcategory->listItems(null, ['task'=>'shop-list-items']);
     foreach($itemsCategory as $key => $val){
          $itemsCategory[$key]['sub_category'] = $Mcategory->listItems(['parent_id'=> $val['id']], ['task'=>'shop-list-items-sub-category']);
     }
     $itemsArticle = $this->model->listItems($this->params, ['task'=>'shop-list-items']);
     $newArticle = $this->model->listItems(['limit'=> 5],['task'=>'shop-list-items-new']);
     return view($this->pathViewController. 'index', [
          'itemsCategory' => $itemsCategory,
          'itemsArticle' =>  $itemsArticle,
          'newArticle'   => $newArticle
     ]);
   }

   public function detail(Request $request)
   { 
     $this->params['id'] = $request->id;
     $Mcategory = new CategoryModel();
     $itemsCategory   = $Mcategory->listItems(null, ['task'=>'shop-list-items']);
     foreach($itemsCategory as $key => $val){
          $itemsCategory[$key]['sub_category'] = $Mcategory->listItems(['parent_id'=> $val['id']], ['task'=>'shop-list-items-sub-category']);
     }
     $itemsArticle = $this->model->getItem($this->params, ['task'=>'get-item']);
     $newArticle = $this->model->listItems(['limit'=> 5],['task'=>'shop-list-items-new']);
     return view($this->pathViewController. 'detail', [
          'item' => $itemsArticle,
          'itemsCategory' => $itemsCategory,
          'newArticle'   => $newArticle
     ]);
   }
}
