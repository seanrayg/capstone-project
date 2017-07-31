<!doctype html>
<html lang="en">
<head>
    
	@yield('WebpageTitle')

	@include('layouts.links')
    
    @yield('scripts')
    
</head>
<body class="profile-page">
    @include('layouts.navbar')
    <div class="wrapper">
    
        
    @yield('content')
    
    @include('layouts.footer')
    
    </div>
    @yield('modals')
    
</body>

</html>