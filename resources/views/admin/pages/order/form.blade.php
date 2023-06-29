@extends('admin.main')
@php
    use App\Helper\Form as FormTemplate;
    use App\Helper\Template as Template;
    $formInputAttr = config('myconf.template.form_input');
    $formLabelAttr = config('myconf.template.form_label');
    $categoryArr['default'] ='--- Chọn Danh Mục ---';
    $categoryArr[0] ='Không';
    if(!empty($categoryItems)){
        foreach($categoryItems as $key => $val){
            $categoryArr[$key] = $val;
        }
    }
    
    $xhtmlSelectOrder = '<select name="orders" class="form-control col-md-6 col-xs-12">';
    $xhtmlSelectOrder .='<option value="default">--- Chọn Vị Trí ---</option>';
    if((@$item['orders']) != 0){
        $xhtmlSelectOrder .= '<option value="0">Đứng đầu</option>';
    }else{
        $xhtmlSelectOrder .= '<option selected value="0" ">Đứng đầu</option>';
    }
    
    if(!empty($items)){
        foreach ($items as $val) {
            if($val['orders'] == (@$item['orders']-1) && $val['parent_id'] == @$item['parent_id']){
                $xhtmlSelectOrder .= sprintf('<option selected value="%s">%s</option>', ($val['orders'] + 1), 'Sau - ' .$val['name']);
            }else{
                $xhtmlSelectOrder .= sprintf('<option value="%s">%s</option>', ($val['orders'] + 1), 'Sau - ' .$val['name']);
            }   
        }
    }
   
    $xhtmlSelectOrder .= '</select>';

    $statusValue = ['default' => '--- Chọn trạng thái ---', '1'=> 'Đang kinh doanh', '0' => 'Ngừng kinh doanh' ];
    $inputHiddenID = Form::hidden('id', @$item['id']);
    $inputHiddenThumb = Form::hidden('thumb_current', @$item['img']);
    $elements = [
        [   
            'label'     => Form::label('name'   , 'Tên danh mục'                 , $formLabelAttr),
            'element'   => Form::text('name'    , @$item['name']                 , $formInputAttr)
        ],
        [   
            'label'     => Form::label('parent_id'    , 'Danh mục cha'         , $formLabelAttr),
            'element'   => Form::select('parent_id'  ,$categoryArr , @$item['parent_id']  , $formInputAttr)
        ],
        [   
            'label'     => Form::label('orders'    , 'Vị trí'         , $formLabelAttr),
            'element'   => $xhtmlSelectOrder,
            'type'      => 'input'
        ], 
        [   
            'label'     => Form::label('status'    , 'Trạng thái'         , $formLabelAttr),
            'element'   => Form::select('status'  ,$statusValue   , @$item['status']  , $formInputAttr)
        ],  
        [   
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