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
                    <th class="column-title">Hình ảnh</th>
                    <th class="column-title">Tên bài viết</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th>
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
                            $thumb              = Template::showItemThumb($controllerName, $val['img'], $val['name']);
                            $status             = Template::showItemStatus($controllerName, $id, $val['status']);
                            $createdHistory     = Template::showItemHistory($val['created_by'], $val['created']);
                            $modifiedHistory    = Template::showItemHistory($val['modified_by'], $val['modified']);
                            $listBtnAction      = Template::showButtonAction($controllerName, $id);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td width="18%">{!! $thumb !!}</td>
                            <td>{!! $name !!}</td>
                            <td>{!! $status !!}</td>
                            <td>{!! $createdHistory !!}</td>
                            <td>{!! $modifiedHistory !!}</td>
                            <td class="last">{!! $listBtnAction !!}</div>
                            </td>
                        </tr>
                    @endforeach
                @else
                   @include('admin.templates.list_empty', ['colspan' => 7])
                @endif
            </tbody>
        </table>
    </div>
</div>