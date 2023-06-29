@extends('admin.main')
@php
    use App\Helper\Form as FormTemplate;
    use App\Helper\Template as Template;
    $formInputAttr = config('myconf.template.form_input');
    $formLabelAttr = config('myconf.template.form_label');
   

    $statusValue = ['default' => '--- Chọn trạng thái ---', '1'=> 'Có hiệu lực', '0' => 'Vô hiệu lực' ];
    $inputHiddenID = Form::hidden('id', @$item['id']);
    
    $elements = [
        [   
            'label'     => Form::label('code'   , 'Mã giảm giá'                 , $formLabelAttr),
            'element'   => Form::text('code'    , @$item['code']                 , $formInputAttr)
        ],[   
            'label'     => Form::label('discount'    , 'Số tiền giảm giá'         , $formLabelAttr),
            'element'   => Form::text('discount'   , @$item['discount']  , $formInputAttr)
        ],[   
            'label'     => Form::label('limit_number'    , 'Số lần giới hạn nhập'         , $formLabelAttr),
            'element'   => Form::text('limit_number'   , @$item['limit_number']  , $formInputAttr)
        ],[   
            'label'     => Form::label('payment_limit'    , 'Số tiền đơn hàng tối thiểu được áp dụng'         , $formLabelAttr),
            'element'   => Form::text('payment_limit'   , @$item['payment_limit']  , $formInputAttr)
        ],[   
            'label'     => Form::label('expiration_date'    , 'Ngày giới hạn nhập'         , $formLabelAttr),
            'element'   => Form::date('expiration_date', @$item['expiration_date'],$formInputAttr)
        ],[   
            'label'     => Form::label('description'    , 'Mô tả ngắn'         , $formLabelAttr),
            'element'   => Form::textArea('description', @$item['description'],$formInputAttr)
        ],[   
            'label'     => Form::label('status'    , 'Trạng thái'         , $formLabelAttr),
            'element'   => Form::select('status'  ,$statusValue   , @$item['status']  , $formInputAttr)
        ],[   
            'element'   => $inputHiddenID  . Form::submit('Save'   , ['class' => 'btn btn-success']),
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