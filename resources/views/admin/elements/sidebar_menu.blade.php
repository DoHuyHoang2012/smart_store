<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
        </ul>
    </div>
    <div class="menu_section">
        <h3>Quản lý cửa hàng</h3>
        <ul class="nav side-menu">
            <li><a href="{{ route('news') }}"><i class="fa fa-newspaper-o"></i> Tin tức</a></li>
            <li><a href="{{ route('product') }}"><i class="fa fa-product-hunt"></i> Sản phẩm</a></li>
            <li><a href="{{ route('category') }}"><i class="fa fa-tags"></i> Loại sản phẩm</a></li>
            <li><a href="{{ route('producer') }}"><i class="fa fa-building"></i> Nhà cung cấp</a></li>
            @if (session('userInfo')['role'] == 'admin')
                <li><a href="{{ route('user') }}"><i class="fa fa-group"></i> Nhân viên</a></li>
            @endif
        </ul>
    </div>
    <div class="menu_section">
        <h3>Quản lý bán hàng</h3>
        <ul class="nav side-menu">
            <li><a href="{{ route('coupon') }}"><i class="fa fa-qrcode"></i> Mã giảm giá</a></li>
            <li><a href="{{ route('contact') }}"><i class="fa fa-phone"></i> Liên hệ</a></li>
            <li><a href="{{ route('order') }}"><i class="fa fa-clipboard"></i> Đơn hàng</a></li>
            <li><a href="{{ route('customer') }}"><i class="fa fa-child"></i> Khách hàng</a></li>
            <li><a href="{{ route('slider') }}"><i class="fa fa-sliders"></i> Silders</a></li>
        </ul>
    </div>
</div>
 <!-- /menu footer buttons -->
 <div class="sidebar-footer hidden-small">
    <a href="{{ route('config') }}" data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>
<!-- /menu footer buttons -->