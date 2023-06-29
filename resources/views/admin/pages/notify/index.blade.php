@extends('admin.notify')
@section('content')
<div class="col-md-12">
    <div class="col-middle">
        <div class="text-center text-center">
            <h1 class="error-number">404</h1>
            <h2>Xin lỗi ! Chúng tôi không thể tìm thấy trang này.</h2>
            <p>Trang bạn tìm kiếm không tồn tại.</p>
            <div class="mid_center">
                <a href="{{ route('dashboard') }}">
                    <button class="btn btn-round btn-default" type="button">Quay về trang chủ!</button>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
