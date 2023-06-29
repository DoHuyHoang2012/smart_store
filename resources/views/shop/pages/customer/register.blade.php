@extends('shop.main')
@section('title', 'Đăng ký')
@section('content')


<section id="product-detail">
    <div class="container d-flex justify-content-center">
        <div class="col-md-6 col-sm-9 col-xs-12">
            <div class="products-wrap">
                <div class="accordion accordion-lg divcenter nobottommargin clearfix" style="max-width: 550px;">
                    <div id="register">
                        <div class="acctitle acctitlec">Đăng ký tài khoản</div>
                        @include('shop.templates.error')
                        @include('shop.templates.alert')
                        <div class="acc_content clearfix" style="display: block;">
                            {!! Form::open([
                                'method'    => 'POST',
                                'url'       => route("$controllerName/postRegister"),
                                'id'        => 'customer_register'
                            ]) !!}
                            {!! Form::hidden('form_type', 'register') !!}
                    
                            <div class="col_full">
                                {!! Form::label('username', 'Tên đăng nhập:') !!}<span class="require_symbol">*</span>
                                {!! Form::text('username', null, ['class'=> 'form-control', 'placeholder' => 'Tên đăng nhập']) !!}
                            </div>
                            <div class="col_full">
                                {!! Form::label('password', 'Mật khẩu:') !!}<span class="require_symbol">*</span>                               
                                {!! Form::password('password', ['class'=> 'form-control', 'placeholder' => 'Mật khẩu' ]) !!}
                            </div>
                            <div class="col_full">
                                {!! Form::label('password_confirmation', 'Nhập lại mật khẩu:') !!}<span class="require_symbol">*</span> 
                                {!! Form::password('password_confirmation', [ 'class'=> 'form-control', 'placeholder' => 'Nhập lại mật khẩu' ]) !!}
                            </div>
                            <div class="col_full">
                                {!! Form::label('fullname', 'Họ tên:') !!}<span class="require_symbol">*</span>
                                {!! Form::text('fullname', null, ['class'=> 'form-control', 'placeholder' => 'Họ tên']) !!}
                            </div>
                            <div class="col_full">
                                {!! Form::label('email', 'Email:') !!}<span class="require_symbol">*</span>
                                {!! Form::text('email', null, ['class'=> 'form-control', 'placeholder' => 'Nhập email']) !!}
                            </div>
                            <div class="col_full">
                                {!! Form::label('phone', 'Số điện thoại:') !!}<span class="require_symbol">*</span>
                                {!! Form::text('phone', null, ['class'=> 'form-control', 'placeholder' => 'Số điện thoại']) !!}
                            </div>
                            <div class="col_full nobottommargin">
                                <button class="button button-3d button-black nomargin" id="register-form-submit" type="submit" style="margin-bottom: 20px">Đăng ký</button>
                                <ul>
                                    <li class="right" style="font-size: 18px;">Nếu đã có tài khoản, hãy <a href="{{route('customer/login')}}" style="font-size: 19px; color: #0f9ed8;">Đăng nhập</a></li>
                                </ul>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
