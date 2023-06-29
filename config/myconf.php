<?php 

return 
[
    'url' => [
        'prefix_admin' => 'admin123',
        'prefix_shop'    =>  '',
    ],

    'format' => [
        'long_time'=> 'd/m/Y H:m:s',
        'short_time'=> 'd/m/Y'
    ],

    'template' => [
        'form_input' => [
            'class' => 'form-control col-md-6 col-xs-12',
        ],

        'form_label' => [
            'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
        ],

        'form_label_edit' => [
            'class' => 'control-label col-md-4 col-sm-3 col-xs-12',
        ],

        'form_ckeditor' => [
            'class' => 'form-control col-md-6 col-xs-12 ckeditor',
        ],

        'status' => [
            'all'       => ['name'=> 'Tất cả', 'class' => 'btn-success'],
            '1'         => ['name'=> 'Kích hoạt', 'class' => 'btn-success'],
            '0'         => ['name'=> 'Chưa kích hoạt', 'class' => 'btn-info'],
            'default'   => ['name'=> 'Chưa xác định', 'class' => 'btn-info']
        ],

        'status_order' => [
            'all'       => ['name'=> 'Tất cả', 'class' => 'btn-success'],
            '1'         => ['name'=> 'Đơn đã duyệt', 'class' => 'btn-success'],
            '0'         => ['name'=> 'Chưa duyệt', 'class' => 'btn-info'],
            'default'   => ['name'=> 'Chưa xác định', 'class' => 'btn-info']
        ],

        'order' => [
            '1'         => ['name'=> 'Xác nhận đơn hàng', 'class' => 'btn-success'],
            '0'         => ['name'=> 'Duyệt đơn đặt hàng', 'class' => 'btn-default'],
            'default'   => ['name'=> 'Chưa xác định', 'class' => 'btn-default']
        ],

        'button' => [
            'edit'      => ['class'=> 'btn-success'             , 'title' => 'Edit'     ,'icon' => 'fa-pencil'  ,'route' => '/form'],
            'trash'     => ['class'=> 'btn-danger btn-delete'   , 'title' => 'Delete'   ,'icon' => 'fa-trash'   ,'route' => '/trash'],
            'delete'    => ['class'=> 'btn-danger btn-delete'   , 'title' => 'Delete'   ,'icon' => 'fa-trash'   ,'route' => '/delete'],
            'restore'   => ['class'=> 'btn-success'   , 'title' => 'Restore'   ,'icon' => 'fa-reply'   ,'route' => '/restore'],
            'import'    => ['class'=> 'btn-info'   , 'title' => 'Nhập hàng'   ,'icon'   => 'fa-truck'   ,'route' => '/import'],
            'view'      => ['class'=> 'btn-success'             , 'title' => 'View'     ,'icon' => 'fa-eye'  ,'route' => '/form'],
        ],

        'search' => [
            'all'           => ['name'=> 'Search by All'],
            'id'            => ['name'=> 'Search by Id'],
            'name'          => ['name'=> 'Search by Name'],
            'username'      => ['name'=> 'Search by Username'],
            'fullname'      => ['name'=> 'Search by Fullname'],
            'email'         => ['name'=> 'Search by Email'],
            'description'   => ['name'=> 'Search by Description'],
            'link'          => ['name'=> 'Search by Link'],
            'content'       => ['name'=> 'Search by Content'],
            'phone'         => ['name'=> 'Search by Phone'],
            'address'       => ['name'=> 'Search by Address'],
            'code'          => ['name'=> 'Search by Code'],
            'keyword'       => ['name'=> 'Search by Keyword'],
            'title'         => ['name'=> 'Search by Title'],
        ],

        'role' => [
            'admin' => ['name' => 'Toàn quyền'],
            'staff' => ['name' => 'Nhân viên']
        ],

        'gender' => [
            '0' => ['name' => 'Nữ'],
            '1' => ['name' => 'Nam']
        ],

        'sort' => [
            'created-desc'      => ['name' => 'Hàng mới nhất'],
            'created-asc'       => ['name' => 'Hàng cũ nhất'],
            'quantity_buy-desc' => ['name' => 'Bán chạy nhất'],
            'name-asc'          => ['name' => 'A -> Z'],
            'name-desc'         => ['name' => 'Z -> A'],
            'price-asc'         => ['name' => 'Giá tăng dần'],
            'price-desc'        => ['name' => 'Giá giảm dần'],
        ],
    
    ],

    'config' => [
        'search' => [
            'default' => ['all','id','name'],
            'slider'  => ['all', 'id', 'name','link'],
            'producer'  => ['all', 'id', 'name','code', 'keyword'],
            'category'  => ['all', 'id', 'name'],
            'product'  => ['all', 'id', 'name'],
            'user'  => ['all', 'username', 'email','fullname','phone','address'],
            'customer'  => ['all', 'email','fullname','phone'],
            'order'  => ['all','fullname','phone','code'],
            'coupon'  => ['all','id','code'],
            'news'  => ['all', 'id', 'title'],
            'contact'  => ['all', 'id', 'fullname','email'],
        ],

        'button' => [
            'default' => ['edit','delete'],
            'recycle_bin' => ['restore','delete'],
            'slider' => ['edit','trash'],
            'news' => ['edit','trash'],
            'producer' => ['edit','trash'],
            'category' => ['edit','trash'],
            'user' => ['edit','trash'],
            'product' => ['import','edit','trash'],
            'customer' => ['edit','trash'],
            'order' => ['edit','trash'],
            'coupon' => ['edit','trash'],
            'contact' => ['view','trash'],
        ],
        
    ]
];

?>