@extends('shop.main')
@section('title','Đổi mật khẩu')
@section('content')



<div class="container">
    <div class="products-wrap">
        <div class="container d-flex justify-content-center">
            <div id="login" class="col-md-6 col-sm-9 col-xs-12">
                <div class="acctitle acctitlec">Đổi mật khẩu</div>
                @include('shop.templates.error')
                @include('shop.templates.alert')
                <div class="acc_content clearfix" style="display: block;">
                    {!! Form::open([
                        'method'            => 'POST',
                        'url'               => route("$controllerName/updatePass",['customer'=>session('customerInfo')['id']]),
                        'id'                => 'customer_login',
                        'accept-charset'    => 'UTF-8'
                    ]) !!}
                    
                    <div class="col_full">
                        {!! Form::label('old_password', 'Mật khẩu hiện tại:') !!}<span class="require_symbol">*</span>                               
                        {!! Form::password('old_password', ['class'=> 'form-control', 'placeholder' => 'Mật khẩu mới' ]) !!}
                    </div>
                    <div class="col_full">
                        {!! Form::label('password', 'Mật khẩu mới:') !!}<span class="require_symbol">*</span>                               
                        {!! Form::password('new_password', ['class'=> 'form-control', 'placeholder' => 'Mật khẩu mới' ]) !!}
                    </div>
                    <div class="col_full">
                        {!! Form::label('password_confirmation', 'Nhập lại mật khẩu:') !!}<span class="require_symbol">*</span> 
                        {!! Form::password('new_password_confirmation', [ 'class'=> 'form-control', 'placeholder' => 'Nhập lại mật khẩu' ]) !!}
                    </div>
                    
                    <div class="col_full nobottommargin">
                        <button class="button button-3d button-black nomargin pull-left" id="login-form-submit" type="submit" value="login">Đặt lại mật khẩu</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>



@endsection