@extends('admin.main')
@php
    use App\Helper\Form as FormTemplate;
    use App\Helper\Template as Template;
    $formInputAttr = config('myconf.template.form_input');
    $formLabelAttr = config('myconf.template.form_label');
    $genderValue     = ['default' => '--- Chọn giới tính ---', '1'=> config('myconf.template.gender.1.name'), '0' => config('myconf.template.gender.0.name') ];
    $roleValue      = ['default' => '--- Chọn quyền ---', 'admin'=> config('myconf.template.role.admin.name'), 'staff' => config('myconf.template.role.staff.name') ];
    $statusValue    = ['default' => '--- Trạng thái ---', '1'=> config('myconf.template.status.1.name'), '0' => config('myconf.template.status.0.name') ];
    $inputHiddenID = Form::hidden('id', @$item['id']);
    $inputHiddenThumb = Form::hidden('avatar_current', @$item['img']);
    $inputHiddenTask = Form::hidden('task', 'add');
    $elements = [
        [   
            'label'     => Form::label('fullname'   , 'Họ và tên'                , $formLabelAttr),
            'element'   => Form::text('fullname'    , @$item['fullname']         , $formInputAttr)
        ],[   
            'label'     => Form::label('email'    , 'Email'         , $formLabelAttr),
            'element'   => Form::text('email'   , @$item['email']  , $formInputAttr)
        ],[   
            'label'     => Form::label('username'    , 'Tên đăng nhập'         , $formLabelAttr),
            'element'   => Form::text('username'     , @$item['username']   , $formInputAttr)
        ],[   
            'label'     => Form::label('password'    , 'Mật khẩu'         , $formLabelAttr),
            'element'   => Form::password('password'       , $formInputAttr)
        ],[   
            'label'     => Form::label('password_confirmation'    , 'Xác nhận mật khẩu'         ,$formLabelAttr),
            'element'   => Form::password('password_confirmation'   , $formInputAttr)
        ],[   
            'label'     => Form::label('phone'    , 'Số điện thoại'         , $formLabelAttr),
            'element'   => Form::text('phone'     , @$item['phone']   , $formInputAttr)
        ],[   
            'label'     => Form::label('address'    , 'Địa chỉ'         , $formLabelAttr),
            'element'   => Form::text('address'     , @$item['address']   , $formInputAttr)
        ],[   
            'label'     => Form::label('gender'    , 'Giới tính'         , $formLabelAttr),
            'element'   => Form::select('gender'   ,$genderValue, @$item['gender']   , $formInputAttr)
        ],[   
            'label'     => Form::label('role'    , 'Quyền'         , $formLabelAttr),
            'element'   => Form::select('role'   ,$roleValue, @$item['role']   , $formInputAttr)
        ],[   
            'label'     => Form::label('status'   , 'Trạng thái'         , $formLabelAttr),
            'element'   => Form::select('status'   ,$statusValue, @$item['status']   , $formInputAttr)
        ],[   
            'label'     => Form::label('avatar'    , 'Ảnh đại diện'         , $formLabelAttr),
            'element'   => Form::file('img'   , $formInputAttr),
            'avatar'     => (!empty($item['id']))? Template::showItemThumb($controllerName, $item['img'], $item['fullname']) : null,
            'type'      => 'avatar'
        ],[   
            'element'   => $inputHiddenID . $inputHiddenThumb . $inputHiddenTask. Form::submit('Save'   , ['class' => 'btn btn-success']),
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