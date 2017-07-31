<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="_token" content="{{ csrf_token() }}" />

	@yield('WebpageTitle')

	@include('layouts.links')
    
    @yield('scripts')
    
</head>

<body>

	<div class="wrapper">

	    @include('layouts.sidebar')

	    <div class="main-panel">
			
            @include('layouts.nav')

			<div class="content">
				<div class="container-fluid">
					@yield('content')
				</div>
			</div>


		</div>
	</div>
    
    @yield('modals')

</body>

</html>
