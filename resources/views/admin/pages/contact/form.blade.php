@extends('admin.main')
@php
    use App\Helper\Form as FormTemplate;
    use App\Helper\Template as Template;
    $formInputAttr = config('myconf.template.form_input');
    $formLabelAttr = config('myconf.template.form_label');
   

    $elements = [
        [   
            'label'     => Form::label('fullname'   , 'Họ và tên'                 , $formLabelAttr),
            'element'   => Form::text('fullname'    , @$item['fullname']                 , $formInputAttr)
        ],[   
            'label'     => Form::label('phone'    , 'Số điện thoại'         , $formLabelAttr),
            'element'   => Form::text('phone'   , @$item['phone']  , $formInputAttr)
        ],[   
            'label'     => Form::label('email'    , 'Email'         , $formLabelAttr),
            'element'   => Form::text('email'   , @$item['email']  , $formInputAttr)
        ],[   
            'label'     => Form::label('title'    , 'Tiêu đề'         , $formLabelAttr),
            'element'   => Form::text('title'   , @$item['title']  , $formInputAttr)
        ],[   
            'label'     => Form::label('content'    , 'Nội dung'         , $formLabelAttr),
            'element'   => Form::textArea('content', @$item['content'],$formInputAttr)
        ],
    ];

@endphp
@section('content')
    @include('admin.templates.page_header', ['pageIndex'=> false])
    @include('admin.templates.error')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Chi tiết liên hệ khách hàng'])
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