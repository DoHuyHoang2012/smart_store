@extends('shop.main')
@section('title', 'Đặt lại mật khẩu')
@section('content')



<div class="container">
    <div class="products-wrap">
        <div class="container d-flex justify-content-center">
            <div id="login" class="col-md-6 col-sm-9 col-xs-12">
                <div class="acctitle acctitlec">Đặt lại mật khẩu</div>
                <div class="acc_content clearfix" style="display: block;">
                    {!! Form::open([
                        'method'            => 'POST',
                        'url'               => route("$controllerName/postGetPass",['customer'=>$customer->id,'token'=>$customer->token]),
                        'id'                => 'customer_login',
                        'accept-charset'    => 'UTF-8'
                    ]) !!}
                    
                    <div class="col_full">
                        {!! Form::label('password', 'Mật khẩu:') !!}<span class="require_symbol">*</span>                               
                        {!! Form::password('password', ['class'=> 'form-control', 'placeholder' => 'Mật khẩu mới' ]) !!}
                    </div>
                    <div class="col_full">
                        {!! Form::label('password_confirmation', 'Nhập lại mật khẩu:') !!}<span class="require_symbol">*</span> 
                        {!! Form::password('password_confirmation', [ 'class'=> 'form-control', 'placeholder' => 'Nhập lại mật khẩu' ]) !!}
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
