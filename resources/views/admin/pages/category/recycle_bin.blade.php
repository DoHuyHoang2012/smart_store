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
                                <th class="column-title">Tên loại sản phẩm</th>
                                <th class="column-title">Đường dẫn</th>
                                <th class="column-title">Tạo mới</th>
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
                                        $name           = Highlight::show($val['name'], $params['search'], 'name');
                                        $link           = Highlight::show($val['link'], $params['search'], 'link');
                                        $createdHistory     = Template::showItemHistory($val['created_by'], $val['created_at']);
                                        $listBtnAction      = Template::showButtonAction($controllerName, $id, false);
                                    @endphp
                                    
                                    <tr class="{{ $class }} pointer">
                                        <td>{{ $index }}</td>
                                        <td>{!! $name !!}</td>
                                        <td>{!! $link !!}</td>
                                        <td>{!! $createdHistory !!}</td>
                                        <td class="last">{!! $listBtnAction !!}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                               @include('admin.templates.list_empty', ['colspan' => 5])
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
