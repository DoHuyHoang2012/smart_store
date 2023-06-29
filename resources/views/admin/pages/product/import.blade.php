@extends('admin.main')
@php
    use App\Helper\Form as FormTemplate;
    use App\Helper\Template as Template;
    $formInputAttr = config('myconf.template.form_input');
    $formLabelAttr = config('myconf.template.form_label');
    $categoryArr[] ='--- Chọn Danh Mục ---';
    foreach($categoryItems as $key => $val){
        $categoryArr[$key] = $val;
    }

    $inputHiddenID = Form::hidden('id', $item['id']);
    $elements = [
        [   
            'label'     => Form::label('name'   , 'Tên sản phẩm'                       , $formLabelAttr),
            'element'   => Form::text('name'    , $item['name']                 , ['class' => $formInputAttr, 'disabled' => 'true'])
        ],[   
            'label'     => Form::label('cat_id'    , 'Loại sản phẩm'         , $formLabelAttr),
            'element'   => Form::select('cat_id'  ,$categoryArr   , $item['cat_id']  , ['class' => $formInputAttr, 'disabled' => 'true'])
        ],[   
            'label'     => Form::label('quantity'    , 'Số lượng đã nhập'         , $formLabelAttr),
            'element'   => Form::number('quantity'     , $item['quantity'] , ['class' => $formInputAttr, 'readonly' => 'true'])
        ],[   
            'label'     => Form::label('quantity_rest'    , 'Số lượng còn lại của cửa hàng'         , $formLabelAttr),
            'element'   => Form::number('quantity_rest'     , $item['quantity'], ['class' => $formInputAttr, 'disabled' => 'true'])
        ],[   
            'label'     => Form::label('quantity_add'    , 'Nhập số lượng nhập thêm'         , $formLabelAttr),
            'element'   => Form::number('quantity_add'    ,null  , ['class' => $formInputAttr, 'placeholder' => 'Số lượng'])
        ],[   
            'element'   => $inputHiddenID . Form::submit('Save'   , ['class' => 'btn btn-success']),
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
                        'url'            => route("$controllerName/store"),
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