<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\ProductModel as MainModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   private $pathViewController = 'shop.pages.product.'; 
   private $controllerName     = 'product';
   private $params= [];
   private $model;
   public function __construct(){
     $this->model = new MainModel();
     view()->share('controllerName', $this->controllerName);
   }

   public function index(Request $request)
   { 
     $this->params['product_id'] = $request->product_id;
     
     $categoryModel = new CategoryModel();
    
     $itemsCategory   = $categoryModel->listItems(null, ['task'=>'shop-list-items']);
     $itemProduct     = $this->model->getItem($this->params, ['task' => 'get-detail']);
     $this->params['category_id'] = $itemProduct['cat_id'];
     $productsRelated = $this->model->listItems($this->params, ['task'=> 'shop-list-items-related']);
     return view($this->pathViewController. 'index', [
          'itemProduct' => $itemProduct,
          'itemsCategory' => $itemsCategory,
          'productsRelated' =>$productsRelated, 
     ]);
   }
}
