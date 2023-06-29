@php
    use App\Helper\Template as Template;
    use App\Helper\Highlight as Highlight;
@endphp
<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Fullname</th>
                    <th class="column-title">Email</th>
                    <th class="column-title">Phone</th>
                    <th class="column-title">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php
                            $index              = $key + 1;
                            $class              = ($index % 2 ==0)? 'even' : 'odd';
                            $id                 = $val['id'];
                            $fullName           = Highlight::show($val['fullname'], $params['search'], 'fullname');
                            $email              = Highlight::show(empty($val['email'])? 'Khách vãng lai' : $val['email'], $params['search'], 'email');
                            $phone              = Highlight::show($val['phone'], $params['search'], 'phone');
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td>{!! $fullName !!}</td>
                            <td>{!! $email !!}</td>
                            <td>{!! $phone !!}</td>
                            
                            </td><td class="last">
                                <a href="{{route($controllerName.'/form',['id'=>$id])}}" type="button" class="btn btn-round btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Xem"> <i class="fa fa-eye"></i> Xem</a>
                                <a href="{{route($controllerName.'/trash',['id' => $id])}}" type="button" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Xóa"><i class="fa fa-trash"></i>Xóa</a></div>
                            </td>
                        </tr>
                    @endforeach
                @else
                   @include('admin.templates.list_empty', ['colspan' => 5])
                @endif
            </tbody>
        </table>
    </div>
</div>