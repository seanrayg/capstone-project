@extends('layout')

@section('WebpageTitle')
    <title>About Us</title>
@endsection

@section('scripts')

@endsection

@section('content')
@foreach($AboutContents as $Content)
<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('{{$Content->strHeaderImage}}');">
    </div>
    <div class="container">
        <div class="content-center brand">
            <h1 class="h1-seo">Il Sogno</h1>
            <h3>About Us</h3>
        </div>
    </div>
</div>
@endforeach

<div class="main">
    
    <div class="section section-tabs">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h2 class="title">About Us</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="nav-align-center">
                        <ul class="nav nav-pills nav-pills-primary" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile" role="tablist">
                                    <i class="now-ui-icons design_image"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home" role="tablist">
                                    <i class="now-ui-icons location_world"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#messages" role="tablist">
                                    <i class="now-ui-icons sport_user-run"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @foreach($AboutDescriptions as $Description)
                <!-- Tab panes -->
                <div class="tab-content gallery">
                    <div class="tab-pane active" id="home" role="tabpanel">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="card text-center">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                                                <p>{{$Description->AboutDescription1}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="profile" role="tabpanel">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="card text-center">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                                                <p>{{$Description->AboutDescription2}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="messages" role="tabpanel">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="card text-center">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                                                <p>{{$Description->AboutDescription3}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

          
        </div>
            
    </div>

</div>

@include('layouts.ReservationSection')



@endsection