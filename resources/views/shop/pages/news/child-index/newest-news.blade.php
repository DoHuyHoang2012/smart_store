@php
     use App\Helper\URL;
@endphp
<div class="widget">
    <p>Bài viết mới nhất</p>
    <div class="tab-container ">
        @foreach ($newArticle as $item)
            <div class="spost clearfix">
                <div class="entry-image e-img">
                    <a href="{{URL::linkArticle($item['id'],$item['title'])}}" class="nobg a-circle">
                        <img class="img-circle-custom" src="{{asset('images/news/'.$item['img'])}}" alt="{{$item['title']}}">
                    </a>
                </div>
                <div class="entry-c">
                    <div class="entry-title e-title">
                        <h4>
                            <a href="{{URL::linkArticle($item['id'],$item['title'])}}">{{$item['title']}}</a>
                        </h4>
                    </div>
                </div>
            </div>
        @endforeach 
    </div>
</div>	