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
                    <th class="column-title">Tên</th>
                    <th class="column-title">Ngày gửi</th>
                    <th class="column-title">Địa chỉ Email</th>
                    <th class="column-title">Tiêu đề</th>
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
                            $email          = Highlight::show($val['email'], $params['search'], 'email');
                            $title          = $val['title'];
                            $sendDate     = date(Config::get('myconf.format.short_time'),strtotime($val['created_at']));
                            $listBtnAction      = Template::showButtonAction($controllerName, $id);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td>{!! $name !!}</td>
                            <td>{!! $sendDate !!}</td>
                            <td>{!! $email !!}</td>
                            <td>{!! $title !!}</td>
                            <td class="last">{!! $listBtnAction !!}</td>
                        </tr>
                    @endforeach
                @else
                   @include('admin.templates.list_empty', ['colspan' => 6])
                @endif
            </tbody>
        </table>
    </div>
</div>