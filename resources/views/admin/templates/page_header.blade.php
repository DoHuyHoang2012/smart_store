@php
    $role = session('userInfo')['role'];
    $pageTitle = 'Quản lý '. $controllerName;
    $pageButton = sprintf('<a href="%s" class="btn btn-success"><i class="fa %s"></i> %s</a>', route($controllerName), 'fa-arrow-left', 'Quay về');
    $noAdd = $noAdd ?? false;
    if($pageIndex == true){
        $pageButton = '';
        if ($role == 'admin' && $noAdd == false) {
            $pageButton .= sprintf('<a href="%s" class="btn btn-success"><i class="fa %s"></i> %s</a>', route($controllerName . '/form'), 'fa-plus-circle', 'Thêm mới');
        }
        $pageButton .= sprintf('<a href="%s" class="btn btn-success"><i class="fa %s"></i> %s</a>', route($controllerName . '/recycleBin'), 'fa-trash', 'Thùng rác('.$itemsCount[0]['count'].')');
    }
@endphp

<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>{{ $pageTitle }}</h3>
    </div>
    <div class="zvn-add-new pull-right">
        {!! $pageButton !!}
    </div>
</div>