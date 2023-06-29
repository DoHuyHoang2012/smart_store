@php
     use App\Helper\URL;
@endphp
@extends('shop.main')
@section('title', $item['title'])
@section('content')
  
<section id="content">
    @include('shop.templates.banner')
	<div class="slider">
		<div class="container d-flex flex-wrap">
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                @include('shop.templates.menu-cat')
                <div class="clearfix"></div>
                @include('shop.pages.news.child-index.newest-news')
			</div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 product-content" id="list-content">
                <div class="product-wrap" id="info-content">
                    <div class="content-ct">
                        <div class="fs-ne2-it clearfix" style="padding-top: 5px;">
                            <div class="fs-ne2-it clearfix">
                                <div class="entry-title">
                                    <h2>{{$item['title']}}</h2>
                                </div>
                                <ul class="entry-meta clearfix">
                                    <li><i class="fa fa-calendar" style="margin-right: 5px;"></i>{{$item['created']}}</li>
                                </ul>
                            </div>
                            <div class="introtext">
                                <p>{{$item['intro_text']}}</p>
                            </div>
                            <div class="entry-content">
                                {!!$item['full_text']!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
  </section>
@endsection
