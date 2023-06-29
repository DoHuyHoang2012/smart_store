@if (session('vn_notify'))
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-info alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-lable="Close"><span aria-hidden="true">x</span></button>
                <strong>{{ session('vn_notify') }}</strong>
            </div>
        </div>
    </div>
@endif