@extends('admin.main')
@php
    use App\Helper\Template as Template;
   
    $xhtmlButtonFilter = Template::showButtonFilter($controllerName, $itemsStatusCount, $params['filter']['status'], $params['search']);
    $xhtmlAreaSearch   = Template::showAreaSearch($controllerName, $params['search']);
   
@endphp
@section('content')
<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>{{ 'Quản lý '. $controllerName; }}</h3>
    </div>
    <div class="zvn-add-new pull-right">
        <a href="{{route('order/recycleBin')}}" class="btn btn-success"><i class="fa fa-check-square"></i>&nbsp;&nbsp;Đơn hàng đã lưu({{$itemsCount[0]['count']}})</a>
    </div>
</div>
@include('admin.templates.vn_notify')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title'=> 'Bộ lọc'])
            <div class="x_content">
                <div class="row">
                    <div class="col-md-7">{!! $xhtmlButtonFilter !!}</div>
                    <div class="col-md-5">{!! $xhtmlAreaSearch !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--box-lists-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title'=> 'Danh sách'])
            @include('admin.pages.order.list')
            
            <!--box-pagination-->
            @if (count($items) > 0)
            @include('admin.templates.pagination')  
            <!--end-box-pagination-->
            @endif
            
        </div>
    </div>
</div>
<!--end-box-lists-->

@endsection
