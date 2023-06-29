@extends('admin.main')
@php
    use App\Helper\Form as FormTemplate;
    use App\Helper\Template as Template;
    $formInputAttr = config('myconf.template.form_input');
    $formLabelAttr = config('myconf.template.form_label');
  
    $inputHiddenID = Form::hidden('id', @$item['id']);
    $elements = [
        [   
            'label'     => Form::label('mail_smtp'   , 'Mail smtp (*)'                 , $formLabelAttr),
            'element'   => Form::text('mail_smtp'    , @$item['mail_smtp']                 , $formInputAttr)
        ],
        [   
            'label'     => Form::label('mail_smtp_password'    , 'Password mail smtp '         , $formLabelAttr),
            'element'   => Form::text('mail_smtp_password'  ,@$item['mail_smtp_password']   , $formInputAttr)
        ],
        [   
            'label'     => Form::label('mail_from_name'    , 'Mail from name '         , $formLabelAttr),
            'element'   => Form::text('mail_from_name'  ,@$item['mail_from_name']   , $formInputAttr)
        ],
        [   
            'label'     => Form::label('priceShip'    , 'Phí giao hàng'         , $formLabelAttr),
            'element'   => Form::text('priceShip'  , @$item['priceShip']  , $formInputAttr)
        ], 
        [   
            'label'     => Form::label('title'    , 'Tiêu đề'         , $formLabelAttr),
            'element'   => Form::text('title'     , @$item['title']  , $formInputAttr)
        ], 
        [   
            'element'   => $inputHiddenID  . Form::submit('Save'   , ['class' => 'btn btn-success']),
            'type'      => 'btn-submit'
        ], 
    ];

@endphp
@section('content')
    @include('admin.templates.vn_notify')
    @include('admin.templates.error')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Cấu hình hệ thống'])
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
