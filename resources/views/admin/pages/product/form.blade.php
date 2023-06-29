@extends('admin.main')
@php
    use App\Helper\Form as FormTemplate;
    use App\Helper\Template as Template;
    $formInputAttr = config('myconf.template.form_input');
    $formLabelAttr = config('myconf.template.form_label');
    $formCkeditor = config('myconf.template.form_ckeditor');
    $categoryArr[] ='--- Chọn Danh Mục ---';
    foreach($categoryItems as $key => $val){
        $categoryArr[$key] = $val;
    }

    $producerArr[] ='--- Chọn nhà cung cấp ---';
    foreach($producerItems as $key => $val){
        $producerArr[$key] = $val;
    }

    $statusValue = ['default' => '--- Chọn Trạng Thái ---', 1=> 'Kinh doanh', 0 => 'Ngừng kinh doanh'];
    $inputHiddenID = Form::hidden('id', @$item['id']);
    $inputHiddenThumb = Form::hidden('avatar_current', @$item['avatar']);
    $inputHiddenImages = Form::hidden('images_current', @$item['image']);
    $elements = [
        [   
            'label'     => Form::label('name'   , 'Tên sản phẩm'                       , $formLabelAttr),
            'element'   => Form::text('name'    , @$item['name']                 , $formInputAttr)
        ],[   
            'label'     => Form::label('cat_id'    , 'Loại sản phẩm'         , $formLabelAttr),
            'element'   => Form::select('cat_id'  ,$categoryArr   , @$item['cat_id']  , $formInputAttr)
        ],[   
            'label'     => Form::label('producer_id'    , 'Nhà cung cấp'         , $formLabelAttr),
            'element'   => Form::select('producer_id'  ,$producerArr   , @$item['producer_id']  , $formInputAttr)
        ],[   
            'label'     => Form::label('shortDesc'    , 'Mô tả ngắn'         , $formLabelAttr),
            'element'   => Form::textArea('shortDesc'     , @$item['shortDesc']   , $formInputAttr)
        ],[   
            'label'     => Form::label('detail'    , 'Chi tiết sản phẩm'         , $formLabelAttr),
            'element'   => Form::textArea('detail'     , @$item['detail']   , $formCkeditor)
        ], [   
            'label'     => Form::label('price'    , 'Giá bán'         , $formLabelAttr),
            'element'   => Form::number('price'     , $item['price']?? '0'   , $formInputAttr)
        ],[   
            'label'     => Form::label('sale'    , 'Khuyến mãi (%)'         , $formLabelAttr),
            'element'   => Form::number('sale'     , 0   , $formInputAttr)
        ],[   
            'label'     => Form::label('quantity'    , 'Số lượng'         , $formLabelAttr),
            'element'   => Form::number('quantity'     , $item['quantity'] ?? '1'  , $formInputAttr)
        ],[   
            'label'     => Form::label('avatar'    , 'Hình đại diện'         , $formLabelAttr),
            'element'   => Form::file('avatar'   , ['class' => $formInputAttr]),
            'thumb'     => (!empty($item['id']))? Template::showItemThumb($controllerName, $item['avatar'], $item['name']) : null,
            'type'      => 'img'
        ],[   
            'label'     => Form::label('images[]'    , 'Hình ảnh sản phẩm'         , $formLabelAttr),
            'element'   => Form::file('images[]'   , ['class' => $formInputAttr, 'multiple' => true]),
            'thumb'     => (!empty($item['id']))? Template::showItemThumb($controllerName, $item['image'], $item['name']) : null,
            'type'      => 'img'
        ],[   
            'label'     => Form::label('status'    , 'Trạng thái'         , $formLabelAttr),
            'element'   => Form::select('status'  ,$statusValue   , @$item['status']  , $formInputAttr)
        ],[   
            'element'   => $inputHiddenID . $inputHiddenThumb . Form::submit('Save'   , ['class' => 'btn btn-success']),
            'type'      => 'btn-submit'
        ],
    ];
    if(@$item['id'] != null){
        $elements = [
            [   
                'label'     => Form::label('name'   , 'Tên sản phẩm'                       , $formLabelAttr),
                'element'   => Form::text('name'    , $item['name']                 , $formInputAttr)
            ],[   
                'label'     => Form::label('cat_id'    , 'Loại sản phẩm'         , $formLabelAttr),
                'element'   => Form::select('cat_id'  ,$categoryArr   , $item['cat_id']  , $formInputAttr)
            ],[   
                'label'     => Form::label('producer_id'    , 'Nhà cung cấp'         , $formLabelAttr),
                'element'   => Form::select('producer_id'  ,$producerArr   , $item['producer_id']  , $formInputAttr)
            ],[   
                'label'     => Form::label('shortDesc'    , 'Mô tả ngắn'         , $formLabelAttr),
                'element'   => Form::textArea('shortDesc'     , $item['shortDesc']   , $formInputAttr)
            ],[   
                'label'     => Form::label('detail'    , 'Chi tiết sản phẩm'         , $formLabelAttr),
                'element'   => Form::textArea('detail'     , $item['detail']   , $formCkeditor)
            ], [   
                'label'     => Form::label('price'    , 'Giá bán'         , $formLabelAttr),
                'element'   => Form::number('price'     , $item['price']?? '0'   , $formInputAttr)
            ],[   
                'label'     => Form::label('sale'    , 'Khuyến mãi (%)'         , $formLabelAttr),
                'element'   => Form::number('sale'     , $item['sale']   , $formInputAttr)
            ],[   
                'label'     => Form::label('quantity'    , 'Số lượng tồn kho'         , $formLabelAttr),
                'element'   => Form::number('quantity'     , $item['quantity']  , ['class' => $formInputAttr, 'readonly' => 'true'])
            ],[   
                'label'     => Form::label('avatar'    , 'Hình đại diện'         , $formLabelAttr),
                'element'   => Form::file('avatar'   , ['class' => $formInputAttr]),
                'thumb'     => (!empty($item['id']))? Template::showItemThumb($controllerName, $item['avatar'], $item['name']) : null,
                'type'      => 'img'
            ],[   
                'label'     => Form::label('images[]'    , 'Hình ảnh sản phẩm'         , $formLabelAttr),
                'element'   => Form::file('images[]'   , ['class' => $formInputAttr, 'multiple' => true]),
                'thumb'     => (!empty($item['id']))? Template::showItemThumb($controllerName, $item['image'], $item['name']) : null,
                'type'      => 'img'
            ],[   
                'label'     => Form::label('status'    , 'Trạng thái'         , $formLabelAttr),
                'element'   => Form::select('status'  ,$statusValue   , $item['status']  , $formInputAttr)
            ],[   
                'element'   => $inputHiddenID . $inputHiddenThumb . Form::submit('Save'   , ['class' => 'btn btn-success']),
                'type'      => 'btn-submit'
            ],
        ];
    }
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