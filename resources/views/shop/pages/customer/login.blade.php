@extends('shop.main')
@section('title', 'Đăng nhập')
@section('content')



<div class="container">
    <div class="products-wrap">
        <div class="container d-flex justify-content-center">
            <div id="login" class="col-md-6 col-sm-9 col-xs-12">
                <div class="acctitle acctitlec">Đăng nhập</div>
                @include('shop.templates.error')
                @include('shop.templates.alert')
                <div class="acc_content clearfix" style="display: block;">
                    {!! Form::open([
                        'method'            => 'POST',
                        'url'               => route("$controllerName/postLogin"),
                        'id'                => 'customer_login',
                        'accept-charset'    => 'UTF-8'
                    ]) !!}
                    <div class="col_full">
                        {!! Form::label('username', 'Tài khoản:') !!}<span class="require_symbol">* </span>
                        {!! Form::text('username', null, ['class' => 'form-control', 'required'=> true,'autofocus'=>true, 'placeholder'=> 'Nhập email hoặc tên người dùng...']) !!}
                    </div>
                    <div class="col_full">
                        {!! Form::label('password', 'Mật khẩu:') !!}<span class="require_symbol">* </span>
                        {!! Form::password('password', ['class' => 'form-control', 'required'=> true]) !!}
                    </div>
                    <div class="col_full nobottommargin">
                        <button class="button button-3d button-black nomargin pull-left" id="login-form-submit" type="submit" value="login">Đăng nhập</button>
                        <ul class="pull-right">
                            <li><a href="{{route('customer/forgetPass')}}" class="fright">Quên mật khẩu?</a></li>
                            <li><a href="{{route('customer/register')}}" class="fright">Người dùng mới? Đăng ký tài khoản</a></li>
                        </ul>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
