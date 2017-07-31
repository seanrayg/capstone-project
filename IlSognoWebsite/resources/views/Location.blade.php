@extends('layout')

@section('WebpageTitle')
    <title>Location</title>
@endsection

@section('scripts')

@endsection

@section('content')
<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('/img/header-3.jpg');">
    </div>
    <div class="container">
        <div class="content-center brand">
            <h1 class="h1-seo">Il Sogno</h1>
            <h3>Location</h3>
        </div>
    </div>
</div>

<div class="main">
    
    <div class="section section-tabs">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h2 class="title">Location</h2>
                    <h5 class="description">Sed at tortor ut eros suscipit tincidunt. Sed blandit massa arcu, nec mattis mi commodo sit amet.</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <img src="/img/Map.jpg" alt="Raised Image" class="rounded img-raised lrg-image">
                </div>
                
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-block">
                            <div class="row">
                                    <div class="description-center">
                                        <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ornare, dui eu interdum venenatis, mi purus viverra ex, vitae tincidunt orci urna a nibh. Pellentesque in mattis tellus, iaculis accumsan diam. Cras nec diam vitae orci maximus aliquam at nec dui. Morbi vitae molestie quam. Vivamus vitae eleifend massa, non venenatis risus. Integer commodo a est a ornare. Duis placerat venenatis sem, ac maximus sem varius vel. Aliquam cursus ipsum eu est convallis dignissim. Mauris iaculis sem vitae lacus molestie tempus.
                                        </p>
                                        <p>
                                            Quisque finibus massa quis sollicitudin tincidunt. Mauris sodales imperdiet egestas. Morbi sed augue id orci porta malesuada non nec orci. Ut congue dui sodales odio placerat, quis facilisis sapien sollicitudin. Morbi lobortis ipsum et lorem malesuada, sit amet venenatis tellus varius. Vestibulum at lacus vitae odio ornare lacinia. Aenean viverra mattis sapien. Ut at mi consectetur, feugiat justo sit amet, dictum quam.
                                        </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

          
        </div>
            
    </div>

</div>

@include('layouts.ReservationSection')



@endsection