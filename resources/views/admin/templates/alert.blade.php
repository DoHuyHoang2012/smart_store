@if (session('auth_notify'))
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-lable="Close"><span aria-hidden="true"></span></button>
        <strong>{{ session('auth_notify') }}</strong>
    </div>
@endif