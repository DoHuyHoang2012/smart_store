@php
    $userInfo = session('userInfo');
    @$userName = $userInfo['fullname'];
    @$avatar = $userInfo['img'];
    use App\Models\OrderModel;
    $Morder = new OrderModel();
    $approved = $Morder->countItems(null,['task'=> 'header-approved-count-items'])[0]['count'];
    $notApproved = $Morder->countItems(null,['task'=> 'header-not-approved-count-items'])[0]['count'];
@endphp
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        <img src="{{ asset("images/user/$avatar") }}" alt="">{{ $userName }}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="{{ route('user/form',['id'=>$userInfo['id']]) }}"> Profile</a></li>
                        <li><a href="{{ route('auth/logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                       aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green">{{$approved+$notApproved}}</span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li>
                            <a>{{$notApproved}} đơn hàng chưa được duyệt</a>
                        </li>

                        <li>
                            <a>{{$approved}} đơn hàng đang giao</a>
                        </li>
                        <li>
                            <div class="text-center">
                                <a href="{{route('order')}}">
                                    <strong>Xem </strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>