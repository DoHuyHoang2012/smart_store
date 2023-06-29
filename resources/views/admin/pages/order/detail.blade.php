@extends('admin.main')
@php
    use Illuminate\Support\Facades\DB;
    $district = DB::table('district')->where('id',$order['district'])->first()->name;
    $province = DB::table('province')->where('id',$order['province'])->first()->name;
@endphp
@section('content')
    @include('admin.templates.page_header', ['pageIndex'=> false])
    @include('admin.templates.error')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Chi tiết đơn hàng'])
                <div class="x_content">
                    <div class="box-body">
                        <!--ND-->
                        <div id="view">
                            <form action="admin/orders/detail/75" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                <h1 class="text-center" style="color: red;">CHI TIẾT ĐƠN HÀNG</h1>
                                <h4>Tên khách hàng: <b>{{$order['fullname']}}</b></h4>
                                <h4>Điện thoại: <i>{{$order['phone']}}</i></h4>
                                <h4>Thời gian đặt hàng: <i>{{$order['order_date']}}</i></h4>
                                <h4>Địa chỉ: {{$order['address']}}, {{$district}}, {{$province}}</h4>
                                <h4>Mã đơn hàng: <b>{{$order['order_code']}}</b></h4>
                                <br />
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">STT</th>
                                                <th>Tên sản phẩm</th>
                                                <th class="text-center" style="width:100px">Số lượng</th>
                                                <th style="width:120px">Giá bán</th>
                                                <th class="text-right" style="width:120px">Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $products = json_decode($orderDetail['products']);
                                                $prices = json_decode($orderDetail['prices']);
                                                $quantities = json_decode($orderDetail['quantities']);
                                                $total = 0;
                                                $i = 0;
                                            @endphp
                                            @foreach ($products as $key => $item)
                                                @php
                                                    $name = DB::table('product')->where('id',$item)->first()->name;
                                                    $total +=  $prices[$key]*$quantities[$key];
                                                    $i++;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{$i}}</td>
                                                    <td>{{$name}}</td>
                                                    <td class="text-center">{{$quantities[$key]}}</td>
                                                    <td>{{number_format($prices[$key])}}₫</td>
                                                    <td class="text-right">
                                                        {{number_format($prices[$key]*$quantities[$key])}}₫
                                                    </td>
                                                </tr>
                                               
                                            @endforeach
                                           
                                            <tr>
                                                <td colspan="6" class="text-right" style="border: none; font-size: 1.1em;">Tổng cộng: {{number_format($total)}}₫</td>
                                            </tr>
                                            @if ($order['coupon'] > 0)
                                                <tr>
                                                    <td colspan="6" class="text-right" style="border: none; font-size: 1.1em;">Voucher giảm giá : {{number_format($order['coupon'])}}₫</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="6" class="text-right" style="border: none; font-size: 0.9em;">
                                                    <i>Phí vận chuyển: </i>
                                                    {{number_format($order['price_ship'])}}₫
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right" style="border: none; color: red; font-size: 1.3em;">Thành tiền: {{number_format($order['money'])}}₫</td>
                                            </tr>
                    
                                            <tr>
                                                <td class="text-right" colspan="6">
                                                    <a class="btn btn-primary btn-md" role="button" onclick="window.print()"> <span class="glyphicon glyphicon-print"></span> In đơn hàng </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <ul class="pagination"></ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--/.ND-->
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
@endsection