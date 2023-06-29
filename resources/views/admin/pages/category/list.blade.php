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
                    <th class="column-title">Tên loại sản phẩm</th>
                    <th class="column-title">Danh mục cha</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Tạo mới</th>
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
                            $model          = new CategoryModel();
                            $parent         = $model->getItem($val, ['task' => 'category-name-parent']);
                            if(!empty($parent)){
                                $parentName         = Highlight::show($parent['name'], $params['search'], 'parent_id');
                            }else {
                                $parentName         = '';
                            }
                            $name           = Highlight::show($val['name'], $params['search'], 'name');
                            
                            $status             = Template::showItemStatus($controllerName, $id, $val['status']);
                            $createdHistory     = Template::showItemHistory($val['created_by'], $val['created_at']);
                            $listBtnAction      = Template::showButtonAction($controllerName, $id);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td>{!! $name !!}</td>
                            <td>{!! $parentName !!}</td>
                            <td>{!! $status !!}</td>
                            <td>{!! $createdHistory !!}</td>
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