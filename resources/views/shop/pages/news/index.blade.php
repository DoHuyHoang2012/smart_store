@php
     use App\Helper\URL;
@endphp
@extends('shop.main')
@section('title', 'Bài viết')
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
                <div class="product-wrap">
                    <div class="fs-newsboxs">
                        @foreach ($itemsArticle as $item)
                            <div class="fs-ne2-it clearfix">
                                <div class="fs-ne2-if">
                                    <a class="fs-ne2-img" href="{{URL::linkArticle($item['id'],$item['title'])}}">
                                        <img src="{{asset('images/news/'.$item['img'])}}" >
                                    </a>
                                    <div class="fs-n2-info">
                                        <h3><a class="fs-ne2-tit" href="{{URL::linkArticle($item['id'],$item['title'])}}" title="">{{$item['title']}}</a></h3>
                                        <div class="fs-ne2-txt">{{$item['intro_text']}}</div>
                                        <p class="fs-ne2-bot">
                                            
                                            <span>{{$item['created']}}</span>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                        

                    </div>
                    <div class="row text-center">
                        <div class="text-center pull-right">
                            {{ $itemsArticle->appends(request()->input())->links('pagination.pagination_frontend') }}
                        </div>
                </div>

            </div>
		</div>
	</div>
</section>
@endsection
