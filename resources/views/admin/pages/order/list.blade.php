@php
    use App\Models\CategoryModel;
    use App\Helper\Template as Template;
    use App\Helper\Highlight as Highlight;
@endphp
<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Code</th>
                    <th class="column-title">Khách hàng</th>
                    <th class="column-title">Điện thoại</th>
                    <th class="column-title">Tổng tiền</th>
                    <th class="column-title">Ngày tạo hóa đơn</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Xử lý đơn</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php
                            $index          = $key + 1;
                            $class          = ($index % 2 ==0)? 'even' : 'odd';
                            $id             = $val['id'];
                            $name           = Highlight::show($val['fullname'], $params['search'], 'fullname');
                            $code          = Highlight::show($val['order_code'], $params['search'], 'code');
                            $phone          = Highlight::show($val['phone'], $params['search'], 'phone');
                            $money          = number_format($val['money']).'đ';
                            switch ($val['status']) {
                                case '0':
                                $status = 'Đang chờ duyệt';
                                break;
                                case '1':
                                $status = 'Đang giao hàng';
                                break;
                                case '2':
                                $status = 'Đã giao';
                                break;
                                case '3':
                                $status = 'Khách hàng đã hủy';
                                break;
                                case '4':
                                $status = 'Nhân viên đã hủy';
                                break;
							}
                            $orderHandle = Template::showButtonHandle($controllerName,$id, $val['status']);
                            $createdHistory     = date(Config::get('myconf.format.long_time'),strtotime($val['order_date']));
                            
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td>{!! $code !!}</td>
                            <td>{!! $name !!}</td>
                            <td>{!! $phone !!}</td>
                            <td>{!! $money !!}</td>
                            <td>{!! $createdHistory !!}</td>
                            <td>{!! $status !!}</td>
                            <td class="order-handle">{!! $orderHandle !!}</td>
                            <td class="last">
                                <a href="{{route($controllerName.'/detail',['id'=>$id])}}" type="button" class="btn btn-round btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Xem đơn hàng"> <i class="fa fa-eye"></i> Xem</a>
                                <a href="{{route($controllerName.'/trash',['id' => $id])}}" type="button" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Lưu đơn hàng">Lưu đơn</a></div>
                            </td>
                        </tr>
                    @endforeach
                @else
                   @include('admin.templates.list_empty', ['colspan' => 9])
                @endif
            </tbody>
        </table>
    </div>
</div>