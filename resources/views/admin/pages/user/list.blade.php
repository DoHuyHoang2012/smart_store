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
                    <th class="column-title">Avatar</th>
                    <th class="column-title">Username</th>
                    <th class="column-title">Fullname</th>
                    <th class="column-title">Email</th>
                    <th class="column-title">Phone</th>
                    <th class="column-title">Address</th>
                    <th class="column-title">Role</th>
                    <th class="column-title">Status</th>
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
                            $username           = Highlight::show($val['username'], $params['search'], 'username');
                            $fullName           = Highlight::show($val['fullname'], $params['search'], 'fullname');
                            $email              = Highlight::show($val['email'], $params['search'], 'email');
                            $thumb              = Template::showItemThumb($controllerName, $val['img'], $val['fullname']);
                            $status             = Template::showItemStatus($controllerName, $id, $val['status']);
                            $role               = Template::showItemSelect($controllerName, $id, $val['role'], 'role');
                            $phone              = Highlight::show($val['phone'], $params['search'], 'phone');
                            $address            = Highlight::show($val['address'], $params['search'], 'address');
                            $listBtnAction      = Template::showButtonAction($controllerName, $id);
                        @endphp
                        
                        <tr class="{{ $class }} pointer">
                            <td>{{ $index }}</td>
                            <td width="8%">{!! $thumb !!}</td>
                            <td>{!! $username !!}</td>
                            <td>{!! $fullName !!}</td>
                            <td>{!! $email !!}</td>
                            <td>{!! $phone !!}</td>
                            <td>{!! $address !!}</td>
                            <td>{!! $role !!}</td>
                            <td>{!! $status !!}</td>
                            <td class="last">{!! $listBtnAction !!}</div>
                            </td>
                        </tr>
                    @endforeach
                @else
                   @include('admin.templates.list_empty', ['colspan' => 10])
                @endif
            </tbody>
        </table>
    </div>
</div>