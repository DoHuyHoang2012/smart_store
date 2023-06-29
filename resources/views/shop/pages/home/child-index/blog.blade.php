@php
     use App\Helper\URL;
@endphp
<div class="container">
    <div class="row-p">
        <div class="text-center">
            <h2 class="sectin-title title title-blue">Tin tức công nghệ</h2>
        </div>
    </div>
    <div class="blog-content d-flex">
        @foreach ($itemsBlog as $item)
            <div class="col-xs-12 col-12 col-sm-6 col-md-4 col-lg-4" style="margin: 5px;">
                <div class="latest">
                    <a href="{{URL::linkArticle($item['id'],$item['title'])}}">
                        <div class="tempvideo">
                            <img width="98%" src="{{asset('images/news/'.$item['img'])}}">
                        </div>
                        <h3 style="color: #999;">{{$item['title']}}</h3>
                    </a>
                </div>
            </div>
        @endforeach   
    </div>
</div>