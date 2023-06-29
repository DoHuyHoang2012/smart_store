<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use App\Models\CategoryModel as MainModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   private $pathViewController = 'shop.pages.category.'; 
   private $controllerName     = 'category';
   private $model;
   private $params = [];

   public function __construct(){      

     $this->model = new MainModel();
     $this->params['pagination']['totalItemsPerPage'] = 12;
     view()->share('controllerName', $this->controllerName);
   }

   public function index(Request $request){ 
     $this->params['filter']['sort_by'] = $request->input('sort_by','created-desc');
     $this->params['search']['value'] = $request->input('search','');
     $productModel = new ProductModel();
     
     $itemsProduct = $productModel->listItems($this->params, ['task' => 'shop-list-items']);
     $itemsSaleHot = $productModel->listItems(['limit' => 4], ['task' => 'shop-list-items-sale-hot']);
    
     $itemsCategory   = $this->model->listItems(null, ['task'=>'shop-list-items']);
     foreach($itemsCategory as $key => $val){
          $itemsCategory[$key]['sub_category'] = $this->model->listItems(['parent_id'=> $val['id']], ['task'=>'shop-list-items-sub-category']);
     }
    
     return view($this->pathViewController. 'index', [
          'params'       => $this->params,
          'itemsSaleHot' => $itemsSaleHot,
          'itemsProduct' => $itemsProduct,
          'itemsCategory' => $itemsCategory,
     ]);
   }

   public function category(Request $request){ 
     $this->params['filter']['sort_by'] = $request->input('sort_by','created-desc');
     $this->params['search']['value'] = $request->input('search','');
     $this->params['category_id'] = $request->category_id;
     $this->params['category_name'] = $request->category_name;
     $productModel = new ProductModel();
     
     $itemsSaleHot = $productModel->listItems(['limit' => 4], ['task' => 'shop-list-items-sale-hot']);
     $categoryName = $this->model->getItem($this->params, ['task'=> 'category-name']);
     $itemsCategory   = $this->model->listItems($this->params, ['task'=>'shop-list-items']);
     foreach($itemsCategory as $key => $val){
          $itemsCategory[$key]['sub_category'] = $this->model->listItems(['parent_id'=> $val['id']], ['task'=>'shop-list-items-sub-category']);
     }
      
     $checkCategory = $this->model->listItems(['parent_id'=> $this->params['category_id']], ['task'=>'shop-list-items-sub-category']);
     $this->params['arrCat'] = $checkCategory;
     if(count($checkCategory)>0){
          $itemsProduct = $productModel->listItems($this->params, ['task'=>'shop-list-items-in-cat-parent']);  
     }else{
          $itemsProduct = $productModel->listItems($this->params, ['task'=>'shop-list-items-in-category']);
     }

     
     return view($this->pathViewController. 'category', [
          'params'       => $this->params,
          'itemsSaleHot' => $itemsSaleHot,
          'itemsProduct' => $itemsProduct,
          'itemsCategory' => $itemsCategory,
          'categoryName' => $categoryName,
     ]);
   }
}
