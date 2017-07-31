@extends('layout')

@section('WebpageTitle')
    <title>Il Sogno</title>
@endsection

@section('scripts')

@endsection

@section('content')
<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('/img/header-1.jpeg');">
    </div>
    <div class="container">
        <div class="content-center brand">
            <h1 class="h1-seo">Il Sogno</h1>
            <h3>Perfect Budget Getaway</h3>
        </div>
    </div>
</div>

<div class="main">
            
    <div class="section section-about-us">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h2 class="title">Welcome to Il Sogno!</h2>
                    <h5 class="description">Sed at tortor ut eros suscipit tincidunt. Sed blandit massa arcu, nec mattis mi commodo sit amet. Nam at blandit ex. Fusce ex libero, tempus vel tincidunt nec, volutpat ut est. Sed viverra tempor lacus id vulputate.</h5>
                </div>
            </div>
            <div class="separator separator-primary"></div>
            <div class="section-story-overview">
                <div class="row">
                    <div class="col-md-6">
                        <div class="image-container image-left">
                            <!-- First image on the left side -->
                            <img src="/img/filler-1.jpg" alt="" class="rounded img-fluid img-raised">

                        </div>
                        <div class="col-md-12">
                        <!-- Second image on the left side of the article -->
                        <div class="image-container image-right">
                            <img src="/img/filler-2.jpg" alt="" class="img-fluid rounded img-raised">
                        </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <!-- First image on the right side, above the article -->
                        <div class="image-container image-right">
                            <img src="/img/filler-3.jpg" alt="" class="rounded img-fluid img-raised">
                        </div>
                        <div class="card text-center place-on-top">
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

@include('layouts.ReservationSection')



@endsection