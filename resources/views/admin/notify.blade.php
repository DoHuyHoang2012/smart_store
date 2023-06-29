<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.elements.head')
  
</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <!-- page content -->
            @yield('content')
            <!-- /page content -->
        </div>
    </div>

@include('admin.elements.scripts')
</body>
</html>