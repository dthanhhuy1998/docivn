
<!doctype html>
<html lang="vi">
<head>
    @include('catalog.common.head')
    @yield('style')
</head>
<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v16.0" nonce="SaGpSoS9"></script>
    
    @include('catalog.common.header')
    <div id="content">
        @yield('content')
    </div>
	@include('catalog.common.footer')
</div>
    @include('catalog.common.cart')
    @include('catalog.common.foot')
    @yield('script')
</body>
</html>