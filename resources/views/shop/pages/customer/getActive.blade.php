@extends('shop.main')
@section('title', 'Kích hoạt tài khoản')
@section('content')



<div class="container">
    <div class="products-wrap">
        <div class="container d-flex justify-content-center">
            <div id="login" class="col-md-6 col-sm-9 col-xs-12">
                <div class="acctitle acctitlec">Kích hoạt tài khoản</div>
                @include('shop.templates.error')
                @include('shop.templates.alert')
                <div class="acc_content clearfix" style="display: block;">
                    {!! Form::open([
                        'method'            => 'POST',
                        'url'               => route("$controllerName/postGetActive"),
                        'id'                => 'customer_login',
                        'accept-charset'    => 'UTF-8'
                    ]) !!}
                    
                    <div class="col_full">
                        {!! Form::label('email', 'Email:') !!}<span class="require_symbol">* </span>
                        {!! Form::text('email', null, ['class' => 'form-control', 'required'=> true,'autofocus'=>true, 'placeholder'=> 'Nhập lại email mà bạn đã đăng ký tài khoản trong hệ thống của chúng tôi..']) !!}
                    </div>
                    
                    <div class="col_full nobottommargin">
                        <button class="button button-3d button-black nomargin pull-left" id="login-form-submit" type="submit" value="login">Tiếp tục</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
