<div style="width:600px margin: 0 auto">
    <div style="text-align: center">
        <h3>Xin chào {{$customer->fullname}}</h3>
        <p>Bạn đã đăng ký tài khoản tại hệ thống của chúng tôi</p>
        <p>Để tiếp tục sử dụng các dịch vụ bạn vui lòng nhấn vào nút kích hoạt bên dưới để kích hoạt tài khoản</p>
        <p><a href="{{route($controllerName.'/active',['customer'=>$customer->id, 'token'=> $customer->token])}}" 
            style="display: inline-block; background: green; color:#fff; padding: 7px 25px; font-weight: bold">
        Đặt lại mật khẩu</a></p>
    </div>
</div>