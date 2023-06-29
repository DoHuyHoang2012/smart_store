<!DOCTYPE html>
<html lang="en">
<head>
    @include('shop.elements.head')
</head>
<body>

@include('shop.elements.header')

@yield('content')

<!--FOOTER-->
<footer id="footer">
    @include('shop.elements.footer')
</footer>


    
<!-- Scripts -->
@include('shop.elements.script')
@yield('extra-js')
</body>
</html>