@extends('admin.main')
@php
    use App\Helper\Form as FormTemplate;
    use App\Helper\Template as Template;
    $formInputAttr = config('myconf.template.form_input');
    $formLabelAttr = config('myconf.template.form_label');
    
    $statusValue    = ['default' => '--- Trạng thái ---', '1'=> config('myconf.template.status.1.name'), '0' => config('myconf.template.status.0.name') ];
    $inputHiddenID = Form::hidden('id', @$item['id']);
    $elements = [
        [   
            'label'     => Form::label('fullname'    , 'Họ và tên'         ,  $formLabelAttr),
            'element'   => Form::text('fullname'     , @$item['fullname']   ,  $formInputAttr)
        ],[   
            'label'     => Form::label('email'    , 'Email'         ,$formLabelAttr),
            'element'   => Form::text('email'     , @$item['email'], $formInputAttr)
        ],[   
            'label'     => Form::label('phone'    , 'Số điện thoại'         ,$formLabelAttr),
            'element'   => Form::text('phone'     , @$item['phone']   , $formInputAttr)
        ],[   
            'label'     => Form::label('status'    , 'Trạng thái'         , $formLabelAttr),
            'element'   => Form::select('status'  ,$statusValue   , @$item['status']  ,$formInputAttr)
        ],[   
            'element'   => $inputHiddenID  . Form::submit('Save'   , ['class' => 'btn btn-success']),
            'type'      => 'btn-submit'
        ], 
    ];

@endphp
@section('content')
    @include('admin.templates.page_header', ['pageIndex'=> false])
    @include('admin.templates.error')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Form Info'])
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
   
@endsection