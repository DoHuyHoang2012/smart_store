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
                    <th class="column-title">Code</th>
                    <th class="column-title">Name</th>
                    <th class="column-title">Keyword</th>
                    <th class="column-title">Trạng thái</th>
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
                            $name           = Highlight::show($val['name'], $params['search'], 'name');
                            $code           = Highlight::show($val['code'], $params['search'], 'code');
                            $keyword        = Highlight::show($val['keyword'], $params['search'], 'keyword');
                            $status             = Template::showItemStatus($controllerName, $id, $val['status']);
                            $listBtnAction      = Template::showButtonAction($controllerName, $id);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td>{!! $code !!}</td>
                            <td>{!! $name !!}</td>
                            <td>{!! $keyword !!}</td>
                            <td>{!! $status !!}</td>
                            <td class="last">{!! $listBtnAction !!}</div>
                            </td>
                        </tr>
                    @endforeach
                @else
                   @include('admin.templates.list_empty', ['colspan' => 6])
                @endif
            </tbody>
        </table>
    </div>
</div>