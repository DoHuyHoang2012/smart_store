<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
   private $pathViewController = 'admin.pages.dashboard.'; 
   private $controllerName     = 'dashboard';

   public function __construct()
   {
     View()->share('controllerName', $this->controllerName);
   }

   public function index()
   {    
        
        $product = DB::table('product')->where('trash', 0)->get()->toArray();
        $news = DB::table('news')->where('trash', 0)->get()->toArray();
        $order =  DB::table('order')->where('trash', 0)->get()->toArray();
        $contact =  DB::table('contact')->where('trash', 0)->get()->toArray();
        return view($this->pathViewController. 'index',[
          'product' => $product,
          'news' => $news,
          'order' => $order,
          'contact' => $contact,
        ]);
   }
}
