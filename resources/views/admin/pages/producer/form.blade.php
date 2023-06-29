@extends('admin.main')
@php
    use App\Helper\Form as FormTemplate;
    use App\Helper\Template as Template;
    $formInputAttr = config('myconf.template.form_input');
    $formLabelAttr = config('myconf.template.form_label');
    
    $statusValue = ['default' => '--- Chọn trạng thái ---', 1 => 'Xuất bản', 0 => 'Chưa xuất bản' ];
    $inputHiddenID = Form::hidden('id', @$item['id']);
    $inputHiddenThumb = Form::hidden('thumb_current', @$item['img']);
    $elements = [
        [   
            'label'     => Form::label('name'   , 'Tên nhà cung cấp' , $formLabelAttr),
            'element'   => Form::text('name'    , @$item['name']     , $formInputAttr)
        ],[  
            'label'     => Form::label('code'    , 'Mã code'        , $formLabelAttr),
            'element'   => Form::text('code'     , @$item['code']   , $formInputAttr)
        ],[  
            'label'     => Form::label('keyword'    , 'Từ khóa'         , $formLabelAttr),
            'element'   => Form::text('keyword'     , @$item['keyword'] , $formInputAttr),
            'suggest'   => 'Chú ý: Mỗi từ khóa phân cách bởi một dấu ",". Ví dụ: dienthoai, maytinhbang',
            'type'      => 'keyword'
        ],[   
            'label'     => Form::label('status'    , 'Trạng thái'  , $formLabelAttr),
            'element'   => Form::select('status'  ,$statusValue   , @$item['status']  ,$formInputAttr)
        ],[   
            'element'   => $inputHiddenID . $inputHiddenThumb . Form::submit('Save'   , ['class' => 'btn btn-success']),
            'type'      => 'btn-submit'
        ], 
    ];

@endphp
@section('content')
    @include('admin.templates.page_header', ['pageIndex'=> false])
    @include('admin.templates.error')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Form Add'])
                <div class="x_content">
                    {{ Form::open([
                        'method'            => 'POST',
                        'url'            => route("$controllerName/save"),
                        'accept-charset'    => 'UTF-8',
                        'enctype'           => 'multipart/form-data',
                        'class' => 'form-horizontal form-label-left',
                        'id' => 'main-form']) }}
                       {!! FormTemplate::show($elements) !!}
                    {!! Form::close() !!}
                </div>
                
            </div>
        </div>
    </div>
@endsection