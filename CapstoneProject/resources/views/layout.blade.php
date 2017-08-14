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
    
    <div id="DivModalWalkinOptions" class="modal">
        <div class="Modal-contentChoice">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">pages</i>
                        </div>
                        <div class="card-content">
                            <h4><span class="close" onclick="HideModalWalkinOption()" style="color: black; font-family: Roboto Thin">X</span></h4>
                            <h3 class="title">Avail a Package?</h3>
                            <br><br>
                            <div class = "row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <a href="#"><button type="button" class="btn btn-success">Yes</button></a>
                                </div>
                                <div class="col-md-4">
                                    <a href="/Walkin"><button type="button" class="btn btn-success">No</button></a>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

</body>

</html>
