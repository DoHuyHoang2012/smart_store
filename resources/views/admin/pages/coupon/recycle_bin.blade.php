@extends('admin.main')
@php
    use App\Helper\Template as Template;
    use App\Helper\Highlight as Highlight;
   
    $xhtmlAreaSearch   = Template::showAreaSearch($controllerName, $params['search']);
@endphp
@section('content')
@include('admin.templates.page_header',['pageIndex' => false, 'itemsCount' => $itemsCount])
@include('admin.templates.vn_notify')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title'=> 'Bộ lọc'])
            <div class="x_content">
                <div class="row">
                    <div class="col-md-7">{!! $xhtmlAreaSearch !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--box-lists-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title'=> 'Thùng rác '.$controllerName])
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">#</th>
                                <th class="column-title">Mã giảm giá</th>
                                <th class="column-title">Số tiền giảm</th>
                                <th class="column-title">Số tiền đơn hàng áp dụng tối thiểu</th>
                                <th class="column-title">Số lần giới hạn nhập</th>
                                <th class="column-title">Hạn nhập</th>
                                <th class="column-title">Trạng thái</th>
                                <th class="column-title">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($items) > 0)
                                @foreach ($items as $key => $val)
                                    @php
                                        $index          = $key + 1;
                                        $class          = ($index % 2 ==0)? 'even' : 'odd';
                                        $id             = $val['id'];
                                        $code           = Highlight::show($val['code'], $params['search'], 'code');
                                        $discount       = number_format($val['discount']).'đ';
                                        $payment_limit  = number_format($val['payment_limit']).'đ';
                                        $limit_number   = $val['limit_number'];
                                        $status             = Template::showItemStatus($controllerName, $id, $val['status']);
                                        $expirationDate     = date(Config::get('myconf.format.long_time'),strtotime($val['expiration_date']));
                                        $listBtnAction      = Template::showButtonAction($controllerName, $id, false);
                                    @endphp
                                    
                                    <tr class="{{ $class }} pointer">
                                        <td>{{ $index }}</td>
                                        <td>{!! $code !!}</td>
                                        <td>{!! $discount !!}</td>
                                        <td>{!! $payment_limit !!}</td>
                                        <td>{!! $limit_number !!}</td>
                                        <td>{!! $expirationDate !!}</td>
                                        <td>{!! $status !!}</td>
                                        <td class="last">{!! $listBtnAction !!}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                               @include('admin.templates.list_empty', ['colspan' => 8])
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
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
