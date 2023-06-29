<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\SliderModel;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\NewsModel;
use Illuminate\Http\Request;
class SearchController extends Controller
{
   private $pathViewController = 'shop.pages.search.'; 
   private $controllerName     = 'search';

   private $model;
   private $params = [];
   public function __construct()
   {
        $this->params['pagination']['totalItemsPerPage'] = 12;
        view()->share('controllerName', $this->controllerName);
   }

   public function index(Request $request)
   {
     if($request->input('search')!= null){
          $productModel = new ProductModel();
          $Mcategory = new CategoryModel();
          $this->params['filter']['sort_by'] = $request->input('sort_by','created-desc');
          $this->params['search']['value'] = $request->input('search','');
           $itemsProduct = $productModel->listItems($this->params, ['task' => 'shop-list-items']);
           $itemsSaleHot = $productModel->listItems(['limit' => 4], ['task' => 'shop-list-items-sale-hot']);
          
           $itemsCategory   = $Mcategory->listItems(null, ['task'=>'shop-list-items']);
           foreach($itemsCategory as $key => $val){
                $itemsCategory[$key]['sub_category'] = $Mcategory->listItems(['parent_id'=> $val['id']], ['task'=>'shop-list-items-sub-category']);
           }
          
           return view($this->pathViewController. 'index', [
                'params'       => $this->params,
                'itemsSaleHot' => $itemsSaleHot,
                'itemsProduct' => $itemsProduct,
                'itemsCategory' => $itemsCategory,
           ]);
     }else {
          return back();
     }
   
   }
}
