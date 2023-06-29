<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
   private $pathViewController = 'shop.pages.about.'; 
   private $controllerName     = 'about';
   
   public function __construct()
   {
        view()->share('controllerName', $this->controllerName);
   }

   public function index()
   { 
    
     return view($this->pathViewController. 'index');
   }
}
