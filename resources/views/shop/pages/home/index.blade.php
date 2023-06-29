@extends('shop.main')
@section('title', 'Trang chủ')
@section('content')
<section id="menu-slider">
	@include('shop.pages.home.child-index.slider')
	@include('shop.pages.home.child-index.sale_hot')
	@include('shop.pages.home.child-index.best_seller')
</section>

<div id="content">
    @include('shop.pages.home.child-index.featured')
</div>

<div class="home-blog">
    @include('shop.pages.home.child-index.blog')
</div>
<div class="adv">
   @include('shop.pages.home.child-index.service')
</div>
@endsection
