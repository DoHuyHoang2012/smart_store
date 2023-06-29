@extends('admin.main')
@php
    use App\Helper\Template as Template;
    use App\Helper\Highlight as Highlight;
    use App\Models\CategoryModel;
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
                                <th class="column-title">Code</th>
                                <th class="column-title">Khách hàng</th>
                                <th class="column-title">Điện thoại</th>
                                <th class="column-title">Tổng tiền</th>
                                <th class="column-title">Ngày tạo hóa đơn</th>
                                <th class="column-title">Chi tiết</th>
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
                                        $name           = Highlight::show($val['fullname'], $params['search'], 'fullname');
                                        $code          = Highlight::show($val['order_code'], $params['search'], 'code');
                                        $phone          = Highlight::show($val['phone'], $params['search'], 'phone');
                                        $money          = number_format($val['money']).'đ';
                                        switch ($val['status']) {
                                            case '0':
                                            $status = 'Đang chờ duyệt';
                                            break;
                                            case '2':
                                            $status = 'Đã giao';
                                            break;
                                            case '3':
                                            $status = 'Khách hàng đã hủy';
                                            break;
                                            case '4':
                                            $status = 'Nhân viên đã hủy';
                                            break;
                                        }
                                        $orderHandle = Template::showButtonHandle($controllerName,$id, $val['status']);
                                        $createdHistory     = date(Config::get('myconf.format.long_time'),strtotime($val['order_date']));
                                        
                                    @endphp
                                    
                                    <tr class="{{ $class }} pointer">
                                        <td>{{ $index }}</td>
                                        <td>{!! $code !!}</td>
                                        <td>{!! $name !!}</td>
                                        <td>{!! $phone !!}</td>
                                        <td>{!! $money !!}</td>
                                        <td>{!! $createdHistory !!}</td>
                                        <td>{!! $status !!}</td>
                                        <td class="last">
                                            <a href="{{route($controllerName.'/view',['id'=>$id])}}" type="button" class="btn btn-round btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Xem đơn hàng"> <i class="fa fa-eye"></i> Xem</a>
                                            <a href="{{route($controllerName.'/restore',['id'=>$id])}}" type="button" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top"><i class="fa fa-repl"></i> Khôi phục</a></div>
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
