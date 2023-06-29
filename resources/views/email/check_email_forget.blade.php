<div style="width:600px; margin: 0 auto">
    <div style="text-align: center">
        <h3>Xin chào {{$customer->name}}</h3>
        <p>Email để giúp bạn lấy lại mật khẩu tài khoản đã bị quên</p>
        <p>Vui lòng kích vào link bên dưới để đặt lại mật khẩu</p>
        <p>Chú ý: Mã xác nhận trong link chỉ có hiệu lực trong vòng 72 giờ</p>
        <p><a href="{{route($controllerName.'/getPass',['customer'=>$customer->id, 'token'=> $customer->token])}}" 
            style="display: inline-block; background: green; color:#fff; padding: 7px 25px; font-weight: bold">
        Đặt lại mật khẩu</a></p>
    </div>
</div>