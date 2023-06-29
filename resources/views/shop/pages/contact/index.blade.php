@extends('shop.main')
@section('title', 'Liên hệ')
@section('content')
<form action="{{route('contact/postEmail')}}" method="post" accept-charset="utf-8">
	@csrf
	<section>
		<div class="contact-form container d-flex flex-wrap">
			<div class="col-lg-7">
				<div class="section-article contactpage">
					<h1 style="color: black">Liên hệ với chúng tôi</h1>
					@include('shop.templates.error')
                	@include('shop.templates.alert')
					<div class="form-comment">
						<div class="row justify-content-between">
							<div class="col-md-4 col-12">
								<div class="form-group" style="width: 200px;">
									<label for="name"><em> Họ tên</em><span class="required">*</span></label>
									<input id="name" name="fullname" type="text" value="" class="form-control" />
								</div>
							</div>
							<div class="col-md-4 col-12">
								<div class="form-group" style="width: 200px;">
									<label for="email"><em> Email</em><span class="required">*</span></label>
									<input id="email" name="email" class="form-control" type="email" value="" />
								</div>
							</div>
							<div class="col-md-4 col-12">
								<div class="form-group" style="width: 200px;">
									<label for="phone"><em> Số điện thoại</em><span class="required">*</span></label>
									<input type="number" id="phone" class="form-control" name="phone" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="message"><em> Tiêu đề</em><span class="required">*</span></label>
							<textarea id="message" name="title" class="form-control custom-control" rows="2"></textarea>
						</div>
						<div class="form-group">
							<label for="message"><em> Lời nhắn</em><span class="required">*</span></label>
							<textarea id="message" name="content" class="form-control custom-control" rows="5"></textarea>
						</div>
						<button type="submit" class="btn-update-order">Gửi nhận xét</button>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div
					class="f-contact"
					style="
			padding-left: 32px;
			"
				>
					<h1 style="color: black">Thông tin liên hệ</h1>
					<ul class="list-unstyled">
						<li class="clearfix">
							<i class="fa fa-map-marker fa-1x" style="color:#0f9ed8; padding: 20px; "></i>
							<span style="color: black"> Đội 13, Vĩnh Ninh, Vĩnh Quỳnh, Hà Nội</span><br />
						</li>
						<li class="clearfix">
							<i class="fa fa-phone fa-1x" style="color:#0f9ed8;padding: 20px;  "></i>
							<span style="color: black">08.335588 - 0981.33557</span>
						</li>
						<li class="clearfix">
							<i class="fa fa-envelope fa-1x" style="color:#0f9ed8; padding: 20px; "></i>
							<span style="color: black"><a href="mailto:sale.24hstore@gmail.com">sale.smartstore@gmail.com</a></span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-12 col-lg-12 col-xs-12 col-12">
				<div style="margin-top: 15px;">
					<iframe 
					src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3726.4734525929966!2d105.8253738751265!3d20.93349368069219!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ad7611f9efc3%3A0xf31609e274f9a73a!2zMTMgxJDGsOG7nW5nIFbEqW5oIE5pbmgsIFbEqW5oIE5pbmgsIFRoYW5oIFRyw6wsIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1687676067917!5m2!1svi!2s" 
					width="100%" 
					height="450" 
					style="border:0;" 
					allowfullscreen="" 
					loading="lazy" 
					referrerpolicy="no-referrer-when-downgrade">
				</iframe>
				</div>
			</div>
		</div>
	</section>
</form>

@endsection
