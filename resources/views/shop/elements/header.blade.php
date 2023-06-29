<section id= btn-login>
  <div class="container">
    <ul class="nav navbar pull-right">
      @if (session('customerInfo'))
        <li><a href="{{route('customer/register')}}">Xin chào: {{session('customerInfo')['fullname']}}</a></li>
        <li><a href="{{route('customer/logout')}}">Thoát</a></li> 
      @else
        <li><a href="{{route('customer/register')}}">Đăng ký</a></li>
        <li><a href="{{route('customer/login')}}">Đăng nhập</a></li> 
      @endif
                     	
    </ul>
  </div>
 
</section>
<div class="clearfix"></div>
<section id="header">
    <div class="container-lg d-flex justify-content-between flex-wrap">
      <div class="col-7 col-sm-5 col-md-4 col-lg-4 logo">
        <a href="{{route('home')}}" class="logo"><i class="fa fa-laptop"></i>Smart store</a>
      </div>
      <div class="col-md-5 col-lg-5 d-md-block  search">
        <div class="contact-row">
          <div class="phone inline"><i class="icon fa fa-phone"></i> (87) 888 888 868</div>
          <div class="contact inline"><i class="icon fa fa-envelope"></i> sale.smart.store.2019@gmail.com</div>
        </div>
        <form action="{{route('search/index')}}" method="get" role="form">
          <div class="input-search">
            <input type="text" class="form-control" id="search_text" name="search" placeholder="Nhập từ khóa để tìm kiếm..." />
            <button id="search-shop"><i class="fa fa-search"></i></button>
          </div>
        </form>
      </div>
      <div class="col-xs-7 col-sm-7 col-md-3 col-lg-3 d-md-block login-cart">
        <!-- Cart -->
        <div class="cart_header">
          <a href="{{route('cart/index')}}" title="Giỏ hàng">
            <span class="cart_header_icon">
              <img src="{{asset('images/cart2.png')}}" alt="Cart" />
            </span>
            <span class="box_text">
             @include('shop.templates.cart-price')
            </span>
          </a>
          <div class="cart_clone_box">
            <div class="cart_box_wrap hidden">
              <div class="cart_item original clearfix">
                <div class="cart_item_image"></div>
                <div class="cart_item_info">
                  <p class="cart_item_title"><a href="" title=""></a></p>
                  <span class="cart_item_quantity"></span>
                  <span class="cart_item_price"></span>
                  <span class="remove"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End Cart -->
        <!-- Account -->
        <div class="user_login">
          <a href="thong-tin-khach-hang" title="Tài khoản">
            <div class="user_login_icon">
              <img src="{{asset('images/user.png')}}" alt="Cart" />
            </div>
            <div class="box_text">
              <strong>Tài khoản</strong>
            </div>
          </a>
        </div>
      </div>
      <div class="col-5 col-sm-7 d-md-none d-flex justify-content-end align-items-center">
        <div class="icon-cart-mobile">
          <a id="cart-mobile" href="gio-hang">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <span>
              @if (session('cart'))
                  ({{count(session('cart'))}})
              @endif(0)</span>
          </a>
        </div>
        <div class="header-offcanvas">
          <button class="nav-header navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span><i class="fa fa-bars" aria-hidden="true"></i></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Smart store</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <form action="{{route('search/index')}}" method="get" role="form">
                <div class="input-search">
                  <input type="text" class="form-control" id="search_text" name="search" placeholder="Nhập từ khóa để tìm kiếm..." />
                  <button><i class="fa fa-search"></i></button>
                </div>
              </form>
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="{{route('home')}}">Trang chủ</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('category/index')}}">Sản phẩm</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('news/index')}}">Tin tức</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('about/index')}}">Giới thiệu</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('contact/index')}}">Liên hệ</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('account/index')}}">Tài khoản</a>
                </li>
                @if (session('customerInfo'))
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('customer/logout')}}">Thoát</a>
                  </li>
                @else
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('customer/register')}}">Đăng kí</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('customer/login')}}">Đăng nhập</a>
                  </li>
                @endif
                
              </ul>
              
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </section>
  
  <section id="menu" class="menu">
    <div class="menu-pri">
        <div class="container-md">
            <div class="panel-left" style="background: #0f9ed8;">
                <!--MOBILE-->
                <nav class="navbar navbar-default d-md-none d-lg-none" role="navigation">
                    <div class="container-fluid" style="background-color: #0f9ed8;">
                        <div class="navbar-header">
                            <button type="button" class="navbar-menu navbar-toggler" data-bs-toggle="collapse" data-bs-target=".navbar-ex1-collapse">
                              <span class="navbar-toggler-icon"></span>
                            </button>
                            <a class="navbar-brand" style="color: #fff;" href="#">Danh mục sản phẩm</a>
                        </div>
                        <div class="collapse navbar-collapse navbar-ex1-collapse d-md-none d-lg-none">
  
                            <ul class="nav navbar-nav">
                                @php
                                  use App\Helper\URL;
                                  use App\Models\CategoryModel;
                                  $Mcategory = new CategoryModel();
                                  $itemsCategory   = $Mcategory->listItems(null, ['task'=>'shop-list-items']);
                                  foreach($itemsCategory as $key => $val){
                                    $itemsCategory[$key]['sub_category'] = $Mcategory->listItems(['parent_id'=> $val['id']], ['task'=>'shop-list-items-sub-category']);
                                  }
                                @endphp
                                @foreach ($itemsCategory as $item)
                                  <li class="nav-item dropdown">
                                    <a href='{{ URL::linkCategory($item['id'],$item['name']) }}' class='nav-link dropdown-toggle' data-bs-toggle='dropdown'>{{$item['name']}}<i class="fa fa-angle-right pull-right" aria-hidden="true"></i></a>
                                    <ul class="dropdown-menu">
                                      @foreach ($item['sub_category'] as $val)
                                        <li><a class="dropdown-item"  href='{{ URL::linkCategory($val['id'],$val['name']) }}'> {{$val['name']}}</a></li>
                                      @endforeach                     
                                    </ul>
                                  </li>
                                @endforeach
                            </ul>  
                        </div><!-- /.navbar-collapse -->
                    </div>
                </nav>
                <!--MD LG-->
            </div>
            <div class="col-md-12 col-lg-12 panel-right text-center hidden-xs" style="background: #0f9ed8;">
                <ul class="menu-right" style="display: inline-block;">
                    <li class="pull-left"><a href="{{route('home')}}">Trang chủ</a></li>
                    <li class="pull-left"><a href="{{route('category/index')}}">Sản phẩm</a></li>
                    <li class="pull-left"><a href='{{route('category/category', ['category_name' =>'dien-thoai', 'category_id'=> 4])}}'>Điện thoại</a></li>
                    <li class="pull-left"><a href='{{route('category/category', ['category_id'=> 7, 'category_name' =>'laptop'])}} '>Laptop</a></li>
                    <li class="pull-left"><a href='{{route('category/category', ['category_id'=> 13, 'category_name' =>'phu-kien'])}} '>Phụ kiện</a></li>                
                    <li class="pull-left"><a href="{{route('news/index')}}">Tin tức</a></li>
                    <li class="pull-left"><a href="{{route('about/index')}}">Giới thiệu</a></li>
                    <li class="pull-left"><a href="{{route('contact/index')}}">Liên hệ</a></li>
                </ul>
            </div>
        </div>
    </div>
  </section>