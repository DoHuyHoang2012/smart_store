<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

$prefixAdmin = config('myconf.url.prefix_admin');
$prefixShop = config('myconf.url.prefix_shop');

Route::group(['prefix' => $prefixAdmin, 'namespace' => 'Admin'], function(){
    Route::group(['middleware'=> 'admin.session'], function(){
        Route::get('');
        Route::get('/');
        // =============================== DASHBOARD ===================================
        $prefix             = 'dashboard';
        $controllerName     = 'dashboard';
        Route::group(['prefix' => $prefix], function () use ($controllerName){
            $controller = ucfirst($controllerName) . 'Controller@';
            Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']); 
        }); 
        
        // =============================== SLIDER ===================================
        $prefix             = 'slider';
        $controllerName     = 'slider';
        Route::group(['prefix' => $prefix], function () use ($controllerName){
            $controller = ucfirst($controllerName) . 'Controller@';
            Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']);
            Route::get('form/{id?}',                    ['as'=> $controllerName. '/form',           'uses'=> $controller . 'form'])->where('id', '[0-9]+')->middleware('admin.permission');
            Route::post('save',                         ['as'=> $controllerName. '/save',           'uses'=> $controller . 'save']);
            Route::get('delete/{id}',                   ['as'=> $controllerName. '/delete',         'uses'=> $controller . 'delete'])->where('id', '[0-9]+')->middleware('admin.permission');;
            Route::get('trash/{id}',                    ['as'=> $controllerName. '/trash',         'uses'=> $controller . 'trash'])->where('id', '[0-9]+');
            Route::get('restore/{id}',                  ['as'=> $controllerName. '/restore',         'uses'=> $controller . 'restore'])->where('id', '[0-9]+');
            Route::get('change-status-{status}/{id}',   ['as'=> $controllerName. '/status',         'uses'=> $controller . 'status'])->where('id', '[0-9]+');
            Route::get('recycle-bin',                   ['as'=> $controllerName. '/recycleBin',          'uses'=> $controller . 'recycleBin']);
        });

        // =============================== News ===================================
        $prefix             = 'news';
        $controllerName     = 'news';
        Route::group(['prefix' => $prefix], function () use ($controllerName){
            $controller = ucfirst($controllerName) . 'Controller@';
            Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']);
            Route::get('form/{id?}',                    ['as'=> $controllerName. '/form',           'uses'=> $controller . 'form'])->where('id', '[0-9]+')->middleware('admin.permission');
            Route::post('save',                         ['as'=> $controllerName. '/save',           'uses'=> $controller . 'save']);
            Route::get('delete/{id}',                   ['as'=> $controllerName. '/delete',         'uses'=> $controller . 'delete'])->where('id', '[0-9]+')->middleware('admin.permission');
            Route::get('trash/{id}',                    ['as'=> $controllerName. '/trash',         'uses'=> $controller . 'trash'])->where('id', '[0-9]+');
            Route::get('restore/{id}',                  ['as'=> $controllerName. '/restore',         'uses'=> $controller . 'restore'])->where('id', '[0-9]+');
            Route::get('change-status-{status}/{id}',   ['as'=> $controllerName. '/status',         'uses'=> $controller . 'status'])->where('id', '[0-9]+');
            Route::get('recycle-bin',                   ['as'=> $controllerName. '/recycleBin',          'uses'=> $controller . 'recycleBin']);
        });

         // =============================== PRODUCER ===================================
        $prefix             = 'producer';
        $controllerName     = 'producer';
        Route::group(['prefix' => $prefix], function () use ($controllerName){
            $controller = ucfirst($controllerName) . 'Controller@';
            Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']);
            Route::get('form/{id?}',                    ['as'=> $controllerName. '/form',           'uses'=> $controller . 'form'])->where('id', '[0-9]+')->middleware('admin.permission');
            Route::post('save',                         ['as'=> $controllerName. '/save',           'uses'=> $controller . 'save']);
            Route::get('delete/{id}',                   ['as'=> $controllerName. '/delete',         'uses'=> $controller . 'delete'])->where('id', '[0-9]+')->middleware('admin.permission');;
            Route::get('trash/{id}',                    ['as'=> $controllerName. '/trash',         'uses'=> $controller . 'trash'])->where('id', '[0-9]+');
            Route::get('restore/{id}',                  ['as'=> $controllerName. '/restore',         'uses'=> $controller . 'restore'])->where('id', '[0-9]+');
            Route::get('change-status-{status}/{id}',   ['as'=> $controllerName. '/status',         'uses'=> $controller . 'status'])->where('id', '[0-9]+');
            Route::get('recycle-bin',                   ['as'=> $controllerName. '/recycleBin',          'uses'=> $controller . 'recycleBin']);
        });

         // =============================== CATEGORY ===================================
         $prefix             = 'category';
         $controllerName     = 'category';
         Route::group(['prefix' => $prefix], function () use ($controllerName){
             $controller = ucfirst($controllerName) . 'Controller@';
             Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']);
             Route::get('form/{id?}',                    ['as'=> $controllerName. '/form',           'uses'=> $controller . 'form'])->where('id', '[0-9]+')->middleware('admin.permission');
             Route::post('save',                         ['as'=> $controllerName. '/save',           'uses'=> $controller . 'save']);
             Route::get('delete/{id}',                   ['as'=> $controllerName. '/delete',         'uses'=> $controller . 'delete'])->where('id', '[0-9]+')->middleware('admin.permission');;
             Route::get('trash/{id}',                    ['as'=> $controllerName. '/trash',         'uses'=> $controller . 'trash'])->where('id', '[0-9]+');
             Route::get('restore/{id}',                  ['as'=> $controllerName. '/restore',         'uses'=> $controller . 'restore'])->where('id', '[0-9]+');
             Route::get('change-status-{status}/{id}',   ['as'=> $controllerName. '/status',         'uses'=> $controller . 'status'])->where('id', '[0-9]+');
             Route::get('recycle-bin',                   ['as'=> $controllerName. '/recycleBin',          'uses'=> $controller . 'recycleBin']);
         });

         // =============================== ORDER ===================================
         $prefix             = 'order';
         $controllerName     = 'order';
         Route::group(['prefix' => $prefix], function () use ($controllerName){
             $controller = ucfirst($controllerName) . 'Controller@';
             Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']);
             Route::get('form/{id?}',                    ['as'=> $controllerName. '/form',           'uses'=> $controller . 'form']);
             Route::get('detail/{id}',                    ['as'=> $controllerName. '/detail',           'uses'=> $controller . 'detail']);
             Route::post('save',                         ['as'=> $controllerName. '/save',           'uses'=> $controller . 'save']);
             Route::get('delete/{id}',                   ['as'=> $controllerName. '/delete',         'uses'=> $controller . 'delete'])->middleware('admin.permission');;
             Route::get('trash/{id}',                    ['as'=> $controllerName. '/trash',         'uses'=> $controller . 'trash'])->where('id', '[0-9]+');
             Route::get('restore/{id}',                  ['as'=> $controllerName. '/restore',         'uses'=> $controller . 'restore'])->where('id', '[0-9]+');
             Route::get('change-status-{status}/{id}',   ['as'=> $controllerName. '/status',         'uses'=> $controller . 'status'])->where('id', '[0-9]+');
             Route::get('recycle-bin',                   ['as'=> $controllerName. '/recycleBin',          'uses'=> $controller . 'recycleBin']);
             Route::get('cancel/{id}',                   ['as'=> $controllerName. '/cancel',          'uses'=> $controller . 'cancel'])->where('id', '[0-9]+');
         });

          // =============================== COUPON ===================================
          $prefix             = 'coupon';
          $controllerName     = 'coupon';
          Route::group(['prefix' => $prefix], function () use ($controllerName){
              $controller = ucfirst($controllerName) . 'Controller@';
              Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']);
              Route::get('form/{id?}',                    ['as'=> $controllerName. '/form',           'uses'=> $controller . 'form']);  
              Route::post('save',                         ['as'=> $controllerName. '/save',           'uses'=> $controller . 'save']);
              Route::get('delete/{id}',                   ['as'=> $controllerName. '/delete',         'uses'=> $controller . 'delete'])->middleware('admin.permission');;
              Route::get('trash/{id}',                    ['as'=> $controllerName. '/trash',         'uses'=> $controller . 'trash'])->where('id', '[0-9]+');
              Route::get('restore/{id}',                  ['as'=> $controllerName. '/restore',         'uses'=> $controller . 'restore'])->where('id', '[0-9]+');
              Route::get('change-status-{status}/{id}',   ['as'=> $controllerName. '/status',         'uses'=> $controller . 'status'])->where('id', '[0-9]+');
              Route::get('recycle-bin',                   ['as'=> $controllerName. '/recycleBin',          'uses'=> $controller . 'recycleBin']);
          });

         // =============================== PRODUCT ===================================
         $prefix             = 'product';
         $controllerName     = 'product';
         Route::group(['prefix' => $prefix], function () use ($controllerName){
             $controller = ucfirst($controllerName) . 'Controller@';
             Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']);
             Route::get('form/{id?}',                    ['as'=> $controllerName. '/form',           'uses'=> $controller . 'form'])->where('id', '[0-9]+')->middleware('admin.permission');
             Route::post('save',                         ['as'=> $controllerName. '/save',           'uses'=> $controller . 'save']);
             Route::post('store',                        ['as'=> $controllerName. '/store',           'uses'=> $controller . 'store']);
             Route::get('delete/{id}',                   ['as'=> $controllerName. '/delete',         'uses'=> $controller . 'delete'])->where('id', '[0-9]+')->middleware('admin.permission');
             Route::get('trash/{id}',                    ['as'=> $controllerName. '/trash',         'uses'=> $controller . 'trash'])->where('id', '[0-9]+');
             Route::get('restore/{id}',                  ['as'=> $controllerName. '/restore',         'uses'=> $controller . 'restore'])->where('id', '[0-9]+');
             Route::get('change-status-{status}/{id}',   ['as'=> $controllerName. '/status',         'uses'=> $controller . 'status'])->where('id', '[0-9]+');
             Route::get('recycle-bin',                   ['as'=> $controllerName. '/recycleBin',          'uses'=> $controller . 'recycleBin']);
             Route::get('import/{id}',                   ['as'=> $controllerName. '/import',         'uses'=> $controller . 'import'])->where('id', '[0-9]+')->middleware('admin.permission');;
         });

         // =============================== USER ===================================
        $prefix             = 'user';
        $controllerName     = 'user';
        Route::group(['prefix' => $prefix, 'middleware' => 'admin.permission'], function () use ($controllerName){
            $controller = ucfirst($controllerName) . 'Controller@';
            Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']);
            Route::get('form/{id?}',                    ['as'=> $controllerName. '/form',           'uses'=> $controller . 'form'])->where('id', '[0-9]+')->middleware('admin.permission');
            Route::post('save',                         ['as'=> $controllerName. '/save',           'uses'=> $controller . 'save']);
            Route::get('delete/{id}',                   ['as'=> $controllerName. '/delete',         'uses'=> $controller . 'delete'])->where('id', '[0-9]+')->middleware('admin.permission');;
            Route::get('trash/{id}',                    ['as'=> $controllerName. '/trash',         'uses'=> $controller . 'trash'])->where('id', '[0-9]+');
            Route::get('restore/{id}',                  ['as'=> $controllerName. '/restore',         'uses'=> $controller . 'restore'])->where('id', '[0-9]+');
            Route::get('change-status-{status}/{id}',   ['as'=> $controllerName. '/status',         'uses'=> $controller . 'status'])->where('id', '[0-9]+');
            Route::get('change-role-{role}/{id}',       ['as'=> $controllerName. '/role',         'uses'=> $controller . 'role'])->where('id', '[0-9]+');
            Route::get('recycle-bin',                   ['as'=> $controllerName. '/recycleBin',          'uses'=> $controller . 'recycleBin']);
            Route::post('change-password',   ['as'=> $controllerName. '/change-password','uses'=> $controller . 'changePassword']);
            Route::post('change-role',   ['as'=> $controllerName. '/change-role','uses'=> $controller . 'changeRole']);
        });

         // =============================== CUSTOMER ===================================
         $prefix             = 'customer';
         $controllerName     = 'customer';
         Route::group(['prefix' => $prefix], function () use ($controllerName){
             $controller = ucfirst($controllerName) . 'Controller@';
             Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']);
             Route::get('form/{id?}',                    ['as'=> $controllerName. '/form',           'uses'=> $controller . 'form'])->where('id', '[0-9]+');
             Route::post('save',                         ['as'=> $controllerName. '/save',           'uses'=> $controller . 'save']);
             Route::get('delete/{id}',                   ['as'=> $controllerName. '/delete',         'uses'=> $controller . 'delete'])->where('id', '[0-9]+')->middleware('admin.permission');;
             Route::get('trash/{id}',                    ['as'=> $controllerName. '/trash',         'uses'=> $controller . 'trash'])->where('id', '[0-9]+');
             Route::get('restore/{id}',                  ['as'=> $controllerName. '/restore',         'uses'=> $controller . 'restore'])->where('id', '[0-9]+');
             Route::get('change-status-{status}/{id}',   ['as'=> $controllerName. '/status',         'uses'=> $controller . 'status'])->where('id', '[0-9]+');
             Route::get('change-role-{role}/{id}',       ['as'=> $controllerName. '/role',         'uses'=> $controller . 'role'])->where('id', '[0-9]+');
             Route::get('recycle-bin',                   ['as'=> $controllerName. '/recycleBin',          'uses'=> $controller . 'recycleBin']);
             Route::post('change-password',   ['as'=> $controllerName. '/change-password','uses'=> $controller . 'changePassword']);
             Route::post('change-role',   ['as'=> $controllerName. '/change-role','uses'=> $controller . 'changeRole']);
         });
            // =============================== NOTIFY ===================================
        $prefix             = 'notify';
        $controllerName     = 'notify';
        Route::group(['prefix' => $prefix], function () use ($controllerName){
            $controller = ucfirst($controllerName) . 'Controller@';
            Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']);
        });
            // =============================== CONFIG ===================================
        $prefix             = 'config';
        $controllerName     = 'config';
        Route::group(['prefix' => $prefix], function () use ($controllerName){
            $controller = ucfirst($controllerName) . 'Controller@';
            Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']);
            Route::post('save',                         ['as'=> $controllerName. '/save',           'uses'=> $controller . 'save']);
        });

        // =============================== CONTACT ===================================
        $prefix             = 'contact';
        $controllerName     = 'contact';
        Route::group(['prefix' => $prefix], function () use ($controllerName){
            $controller = ucfirst($controllerName) . 'Controller@';
            Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']);
            Route::get('form/{id?}',                    ['as'=> $controllerName. '/form',           'uses'=> $controller . 'form']);  
            Route::post('save',                         ['as'=> $controllerName. '/save',           'uses'=> $controller . 'save']);
            Route::get('delete/{id}',                   ['as'=> $controllerName. '/delete',         'uses'=> $controller . 'delete'])->middleware('admin.permission');;
            Route::get('trash/{id}',                    ['as'=> $controllerName. '/trash',         'uses'=> $controller . 'trash'])->where('id', '[0-9]+');
            Route::get('restore/{id}',                  ['as'=> $controllerName. '/restore',         'uses'=> $controller . 'restore'])->where('id', '[0-9]+');
            Route::get('change-status-{status}/{id}',   ['as'=> $controllerName. '/status',         'uses'=> $controller . 'status'])->where('id', '[0-9]+');
            Route::get('recycle-bin',                   ['as'=> $controllerName. '/recycleBin',          'uses'=> $controller . 'recycleBin']);
        });
    });
   

    $prefix             = '';
    $controllerName     = 'auth';
    Route::group(['prefix' => $prefix], function () use ($controllerName){
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/login',                             ['as'=> $controllerName.'/login',                     'uses'=> $controller . 'login'])->middleware('check.login');
        Route::post('/postLogin',                        ['as'=> $controllerName.'/postLogin',                 'uses'=> $controller . 'postLogin']);
        Route::get('/logout',                            ['as'=> $controllerName.'/logout',                    'uses'=> $controller . 'logout']);
    }); 


});


Route::group(['prefix' => $prefixShop],function (){

    // =================================== HOME =========================================
    $prefix             = '';
    $controllerName     = 'home';
    Route::group(['prefix' => $prefix, 'namespace' => 'Shop'], function () use ($controllerName){
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as'=> $controllerName,                    'uses'=> $controller . 'index']); 
    }); 

    // =================================== CATEGORY =========================================
    $prefix             = 'san-pham';
    $controllerName     = 'category';
    Route::group(['prefix' => $prefix, 'namespace' => 'Shop'], function () use ($controllerName){
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                                                                   ['as'=> $controllerName.'/index',                    'uses'=> $controller . 'index']);
        Route::get('/{category_name}-{category_id}.html',                                 ['as'=> $controllerName.'/category',                    'uses'=> $controller . 'category'])
        ->where('category_name', '[0-9a-zA-z_-]+')
        ->where('category_id', '[0-9]+');
       
    }); 

    // =================================== PRODUCT =========================================
    $prefix             = '';
    $controllerName     = 'product';
    Route::group(['prefix' => $prefix, 'namespace' => 'Shop'], function () use ($controllerName){
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/{product_name}-{product_id}.html',                                 ['as'=> $controllerName.'/index',                    'uses'=> $controller . 'index'])
        ->where('product_name', '[0-9a-zA-z_-]+')
        ->where('product_id', '[0-9]+');
       
    }); 

     // =================================== CART =========================================
     $prefix             = '';
     $controllerName     = 'cart';
     Route::group(['prefix' => $prefix, 'namespace' => 'Shop'], function () use ($controllerName){
         $controller = ucfirst($controllerName) . 'Controller@';
         Route::get('/gio-hang',                                 ['as'=> $controllerName.'/index',                    'uses'=> $controller . 'index']);
         Route::get('/info-order',                                 ['as'=> $controllerName.'/infoOrder',                    'uses'=> $controller . 'infoOrder']);
         Route::post('/post-info-order',                                 ['as'=> $controllerName.'/postInfoOrder',                    'uses'=> $controller . 'infoOrder']);
         Route::get('/thank-you',                                 ['as'=> $controllerName.'/thankyou',                    'uses'=> $controller . 'thankyou']);
         Route::get('/add-cart',                                 ['as'=> $controllerName.'/addCart',                    'uses'=> $controller . 'addCart']);
         Route::get('/update-cart',                                 ['as'=> $controllerName.'/update',                    'uses'=> $controller . 'update']);
         Route::get('/check-quantity',                                 ['as'=> $controllerName.'/quantity',                    'uses'=> $controller . 'quantity']);
         Route::get('/remove-cart',                                 ['as'=> $controllerName.'/remove',                    'uses'=> $controller . 'remove']);
         Route::get('/district',                                 ['as'=> $controllerName.'/district',                    'uses'=> $controller . 'district']);
         Route::get('/coupon',                                 ['as'=> $controllerName.'/coupon',                    'uses'=> $controller . 'coupon']);
         Route::get('/removecoupon',                                 ['as'=> $controllerName.'/removeCoupon',                    'uses'=> $controller . 'removeCoupon']);
        
     }); 

    // =================================== CUSTOMER =========================================
    $prefix             = '';
    $controllerName     = 'customer';
    Route::group(['prefix' => $prefix, 'namespace' => 'Shop'], function () use ($controllerName){
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/dang-ki',                             ['as'=> $controllerName.'/register',                    'uses'=> $controller . 'register']); 
        Route::post('/postRegister',                      ['as'=> $controllerName.'/postRegister',                    'uses'=> $controller . 'postRegister']); 
        Route::get('/dang-nhap',                             ['as'=> $controllerName.'/login',                    'uses'=> $controller . 'login']); 
        Route::post('/postLogin',                             ['as'=> $controllerName.'/postLogin',                    'uses'=> $controller . 'postLogin']); 
        Route::get('/logout',                             ['as'=> $controllerName.'/logout',                    'uses'=> $controller . 'logout']); 
        Route::get('/quen-mat-khau',                   ['as'=> $controllerName. '/forgetPass',          'uses'=> $controller . 'forgetPass']);
        Route::post('/quen-mat-khau',                   ['as'=> $controllerName. '/postForgetPass',          'uses'=> $controller . 'postForgetPass']);
        Route::get('/lay-mat-khau/{customer}/{token}',                   ['as'=> $controllerName. '/getPass',          'uses'=> $controller . 'getPass']);
        Route::post('/lay-mat-khau/{customer}/{token}',                   ['as'=> $controllerName. '/postGetPass',          'uses'=> $controller . 'postGetPass']);
        Route::get('/get-active',                   ['as'=> $controllerName. '/getActive',          'uses'=> $controller . 'getActive']);
        Route::post('/get-active',                   ['as'=> $controllerName. '/postGetActive',          'uses'=> $controller . 'postGetActive']);
        Route::get('/kich-hoat/{customer}/{token}',                   ['as'=> $controllerName. '/active',          'uses'=> $controller . 'active']);
    }); 

     // =================================== ACCOUNT =========================================
     $prefix             = '';
     $controllerName     = 'account';
     Route::group(['prefix' => $prefix, 'namespace' => 'Shop'], function () use ($controllerName){
         $controller = ucfirst($controllerName) . 'Controller@';
         Route::get('/thong-tin-khach-hang',           ['as'=> $controllerName.'/index',                    'uses'=> $controller . 'index'])->middleware('customer'); 
         Route::get('/chi-tiet-don-hang/{order}',           ['as'=> $controllerName.'/orderDetail',                    'uses'=> $controller . 'order']);
         Route::get('/doi-mat-khau',           ['as'=> $controllerName.'/changePass',                    'uses'=> $controller . 'changePass']);
         Route::post('/doi-mat-khau/{customer}',           ['as'=> $controllerName.'/updatePass',                    'uses'=> $controller . 'updatePass']);
     }); 

      // =================================== CATEGORY =========================================
    $prefix             = 'tin-tuc';
    $controllerName     = 'news';
    Route::group(['prefix' => $prefix, 'namespace' => 'Shop'], function () use ($controllerName){
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                                                                   ['as'=> $controllerName.'/index',                    'uses'=> $controller . 'index']);
        Route::get('/{article}-{id}.html',                                 ['as'=> $controllerName.'/detail',                    'uses'=> $controller . 'detail'])
        ->where('article', '[0-9a-zA-z_-]+')
        ->where('id', '[0-9]+');
    }); 

     // =================================== CONTACT =========================================
     $prefix             = 'lien-he';
     $controllerName     = 'contact';
     Route::group(['prefix' => $prefix, 'namespace' => 'Shop'], function () use ($controllerName){
         $controller = ucfirst($controllerName) . 'Controller@';
         Route::get('/',                                                                   ['as'=> $controllerName.'/index',                    'uses'=> $controller . 'index']);
         Route::post('/send-email',                                                                   ['as'=> $controllerName.'/postEmail',                    'uses'=> $controller . 'postEmail']);
     }); 

     // =================================== SEARCH =========================================
     $prefix             = 'tim-kiem';
     $controllerName     = 'search';
     Route::group(['prefix' => $prefix, 'namespace' => 'Shop'], function () use ($controllerName){
         $controller = ucfirst($controllerName) . 'Controller@';
         Route::get('/',                                                                   ['as'=> $controllerName.'/index',                    'uses'=> $controller . 'index']);
     }); 

     // =================================== CONTACT =========================================
     $prefix             = 'gioi-thieu';
     $controllerName     = 'about';
     Route::group(['prefix' => $prefix, 'namespace' => 'Shop'], function () use ($controllerName){
         $controller = ucfirst($controllerName) . 'Controller@';
         Route::get('/',                                                                   ['as'=> $controllerName.'/index',                    'uses'=> $controller . 'index']);
     }); 

});