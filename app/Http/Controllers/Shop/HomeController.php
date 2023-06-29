<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\SliderModel;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\NewsModel;

class HomeController extends Controller
{
   private $pathViewController = 'shop.pages.home.'; 
   private $controllerName     = 'home';

   public function __construct()
   {
        view()->share('controllerName', $this->controllerName);
   }

   public function index()
   { 
     $sliderModel = new SliderModel();
     $productModel = new ProductModel();
     $categoryModel = new CategoryModel();
     $Mnews = new NewsModel();
     $itemsSlider = $sliderModel->listItems(null, ['task'=>'shop-list-items']);
     $itemsSaleHot = $productModel->listItems(['limit' => 10], ['task' => 'shop-list-items-sale-hot']);
     $itemsBestSeller = $productModel->listItems(null, ['task' => 'shop-list-items-best-seller']);
     $itemsCategory   = $categoryModel->listItems(null, ['task'=>'shop-list-items']);
     foreach($itemsCategory as $key => $val){
          $itemsCategory[$key]['sub_category'] = $categoryModel->listItems(['parent_id'=> $val['id']], ['task'=>'shop-list-items-sub-category']);
     }
     foreach($itemsCategory as $key => $val){
          $itemsCategory[$key]['products'] = $productModel->listItems(['category_id'=> $val['sub_category']], ['task'=>'shop-list-items-featured']);
     }
     $itemsBlog = $Mnews->listItems(['limit'=> 6],['task'=>'shop-list-items-new']);
     return view($this->pathViewController. 'index', [
          'itemsSlider' => $itemsSlider,
          'itemsSaleHot' => $itemsSaleHot,
          'itemsBestSeller' => $itemsBestSeller,
          'itemsCategory' => $itemsCategory,
          'itemsBlog'    => $itemsBlog
     ]);
   }
}
