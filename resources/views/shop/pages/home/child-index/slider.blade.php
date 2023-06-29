@if (count($itemsSlider) > 0)
<div class="slider">
    <div class="container d-flex">
        <div class="col-md-3 col-lg-3 list-menu hidden-xs">
            <img style="width: 100%; height: auto;" src="{{ asset("images/blog_banner_1.jpg")}}">
            <img style="width: 100%; height: auto;" src="{{ asset("images/blog_banner_2.jpg")}}">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 slider-main">

            <div class="owl-carousel owl-carousel-slider owl-theme">
                @foreach ($itemsSlider as $val)
                    @php
                        $name = $val['name'];
                        $img  = $val['img'];
                    @endphp
                    <div class="item"><img src="{{ asset("images/slider/$img")}}" alt="{{$name}}"/></div>
                @endforeach             
        </div>
    </div>
</div>
@endif
