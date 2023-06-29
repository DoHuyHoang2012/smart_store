<?php
    use App\Helper\URL;
?>
<div class="list-menu pull-left col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="widget" style="margin: 0px; min-height: 0px;">
        <p>Danh mục sản phẩm</p>
    </div>

    <ul class="main-ul">
        @foreach ($itemsCategory as $item)
            <li>
                <a href="{{ URL::linkCategory($item['id'],$item['name']) }}" title=" {{$item['name']}}">{{$item['name']}}
                    <i class="fa fa-angle-right pull-right" aria-hidden="true"></i>
                </a>
                <ul class="sub">
                    @foreach ($item['sub_category'] as $val)
                        <li><a href="{{ URL::linkCategory($val['id'],$val['name']) }}" title="{{$val['name']}}"> {{$val['name']}}</a></li>
                    @endforeach
                </ul>
            </li>
        @endforeach
        
    </ul>
</div>