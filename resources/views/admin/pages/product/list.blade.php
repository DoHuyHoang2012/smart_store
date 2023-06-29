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
                    <th class="column-title">Hình</th>
                    <th class="column-title">Tên sản phẩm</th>
                    <th class="column-title">Số lượng trong kho</th>
                    <th class="column-title">Loại sản phẩm</th>
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
                            $img            = Template::showItemThumb($controllerName, $val['avatar'], $val['name']);
                            $name           = Highlight::show($val['name'], $params['search'], 'name');
                            $quantity       = $val['quantity'] - $val['quantity_buy'];
                            $catName        = $val['category_name'];
                            $status             = Template::showItemStatus($controllerName, $id, $val['status']);
                            $listBtnAction      = Template::showButtonAction($controllerName, $id);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td width="8%">{!! $img !!}</td>
                            <td>{!! $name !!}</td>
                            <td>{!! $quantity !!}</td>
                            <td>{!! $catName !!}</td>
                            <td>{!! $status !!}</td>
                            <td class="last" width="13%">{!! $listBtnAction !!}</div>
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