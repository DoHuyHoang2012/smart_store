@php
    use App\Helper\Form as FormTemplate;
    use App\Helper\Template as Template;
    $formInputAttr = config('myconf.template.form_input');
    $formLabelAttr = config('myconf.template.form_label');
    $roleValue     = ['default' => '--- Chọn Quyền ---', 'admin'=> config('myconf.template.role.admin.name'), 'staff' => config('myconf.template.role.staff.name') ];
    $inputHiddenID = Form::hidden('id', @$item['id']);
    $inputHiddenTask = Form::hidden('task', 'change-role');
    $elements = [
        [   
            'label'     => Form::label('role'    , 'Quyền'         , $formLabelAttr),
            'element'   => Form::select('role'  ,$roleValue   , @$item['role']  , $formInputAttr)
        ],[   
            'element'   => $inputHiddenID . $inputHiddenTask . Form::submit('Save'   , ['class' => 'btn btn-success']),
            'type'      => 'btn-submit-edit'
        ], 
    ];

@endphp

<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin.templates.x_title', ['title' => 'Form Change Level'])
        <div class="x_content">
            {{ Form::open([
                'method'            => 'POST',
                'url'            => route("$controllerName/change-role"),
                'accept-charset'    => 'UTF-8',
                'enctype'           => 'multipart/form-data',
                'class' => 'form-horizontal form-label-left',
                'id' => 'main-form']) }}
                {!! FormTemplate::show($elements) !!}
            {!! Form::close() !!}

        </div>
    </div>
</div>
