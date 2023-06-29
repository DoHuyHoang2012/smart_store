@extends('shop.main')
@section('title','Giỏ hàng')
@section('content')

<div class="content-cart container">
    @include('shop.pages.cart.child-index.cart-component')
</div>


@endsection
