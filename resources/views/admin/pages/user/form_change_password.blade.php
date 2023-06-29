@php
    use App\Helper\Form as FormTemplate;
    use App\Helper\Template as Template;
    $formInputAttr = config('myconf.template.form_input');
    $formLabelAttr = config('myconf.template.form_label_edit');
    
    $inputHiddenID = Form::hidden('id', @$item['id']);
    $inputHiddenTask = Form::hidden('task', 'change-password');
    $elements = [
        [   
            'label'     => Form::label('password'    , 'Mật khẩu'         , $formLabelAttr),
            'element'   => Form::password('password'     ,  $formInputAttr)
        ],[   
            'label'     => Form::label('password_confirmation'    , 'Xác nhận mật khẩu'         ,$formLabelAttr),
            'element'   => Form::password('password_confirmation'   , $formInputAttr)
        ],[   
            'element'   => $inputHiddenID . $inputHiddenTask . Form::submit('Save'   , ['class' => 'btn btn-success']),
            'type'      => 'btn-submit-edit'
        ], 
    ];

@endphp

<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title', ['title' => 'Form Change Password'])
        <div class="x_content">
            {{ Form::open([
                'method'            => 'POST',
                'url'            => route("$controllerName/change-password"),
                'accept-charset'    => 'UTF-8',
                'enctype'           => 'multipart/form-data',
                'class' => 'form-horizontal form-label-left',
                'id' => 'main-form']) }}
                {!! FormTemplate::show($elements) !!}
            {!! Form::close() !!}

        </div>
    </div>
</div>
