@extends('admin.main')
@php
    use App\Helper\Form as FormTemplate;
    use App\Helper\Template as Template;
    $formInputAttr = config('myconf.template.form_input');
    $formLabelAttr = config('myconf.template.form_label');
    $formCkeditor = config('myconf.template.form_ckeditor');
    $statusValue = ['default' => '--- Select Status ---', '1'=> config('myconf.template.status.1.name'), '0' => config('myconf.template.status.0.name') ];
    $inputHiddenID = Form::hidden('id', @$item['id']);
    $inputHiddenThumb = Form::hidden('thumb_current', @$item['img']);
    $elements = [
        [   
            'label'     => Form::label('title'   , 'Tiêu đề bài viết'                       , $formLabelAttr),
            'element'   => Form::text('title'    , @$item['title']                 , $formInputAttr)
        ],[   
            'label'     => Form::label('intro_text'    , 'Mô tả ngắn'         , $formLabelAttr),
            'element'   => Form::text('intro_text'     , @$item['intro_text']   , $formInputAttr)
        ],[   
            'label'     => Form::label('full_text'    , 'Chi tiết sản phẩm'         , $formLabelAttr),
            'element'   => Form::textArea('full_text'     , @$item['full_text']   , $formCkeditor)
        ],[   
            'label'     => Form::label('status'    , 'Trạng thái'         , $formLabelAttr),
            'element'   => Form::select('status'  ,$statusValue   , @$item['status']  , $formInputAttr)
        ],[   
            'label'     => Form::label('img'    , 'Hình đại diện'         , $formLabelAttr),
            'element'   => Form::file('img'   , $formInputAttr),
            'thumb'     => (!empty($item['id']))? Template::showItemThumb($controllerName, $item['img'], $item['name']) : null,
            'type'      => 'img'
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
                @include('admin.templates.x_title', ['title' => 'Form'])
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