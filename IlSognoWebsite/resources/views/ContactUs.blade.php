@extends('layout')

@section('WebpageTitle')
    <title>Contact Us</title>
@endsection

@section('scripts')

@endsection

@section('content')
<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('/img/header-5.jpg');">
    </div>
    <div class="container">
        <div class="content-center brand">
            <h1 class="h1-seo">Il Sogno</h1>
            <h3>Contact Us</h3>
        </div>
    </div>
</div>

<div class="main">
    
    <div class="section section-tabs">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h2 class="title">Contact Us</h2>
                    <h5 class="description">Sed at tortor ut eros suscipit tincidunt. Sed blandit massa arcu, nec mattis mi commodo sit amet.</h5>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="#button" class="btn btn-primary btn-round btn-lg btn-icon" rel="tooltip" title="Facebook">
                                    <i class="fa fa-facebook"></i>
                                </a><p class="description-text description-center">www.facebook.com/nardsmalabanan</p>     
                            </div>
                            <div class="col-md-6">
                                <a href="#button" class="btn btn-primary btn-round btn-lg btn-icon" rel="tooltip" title="Twitter">
                                    <i class="fa fa-twitter"></i>
                                </a><p class="description-text description-center">@nardmalabanan</p>     
                            </div>

                        </div>
                        <br>
                        <div class="row">  
                            <div class="col-md-6">
                                <a href="#button" class="btn btn-primary btn-round btn-lg btn-icon" rel="tooltip" title="Facebook">
                                    <i class="fa fa-instagram"></i>
                                </a><p class="description-text description-center">@nardmalabanan</p>     
                            </div>
                            <div class="col-md-6">
                                <a href="#button" class="btn btn-primary btn-round btn-lg btn-icon" rel="tooltip" title="Mobile Phone">
                                    <i class="fa fa-mobile-phone"></i>
                                </a><p class="description-text description-center">0969696969</p>     
                            </div>  
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="#button" class="btn btn-primary btn-round btn-lg btn-icon" rel="tooltip" title="Telephone">
                                    <i class="fa fa-phone"></i>
                                </a><p class="description-text description-center">87000</p>     
                            </div>     
                        </div>
                </div>
            </div>
        </div>
            
    </div>

</div>

@include('layouts.ReservationSection')



@endsection