@if (session('notify'))
    <div class="alert alert-success" role="alert">
        
        <strong>{{ session('notify') }}</strong>
    </div>
@endif

@if (session('no'))
    <div class="alert alert-danger" role="alert">
        
        <strong>{!! session('no') !!}</strong>
    </div>
@endif

@if (session('yes'))
    <div class="alert alert-success" role="alert">
        
        <strong>{{ session('yes') }}</strong>
    </div>
@endif

