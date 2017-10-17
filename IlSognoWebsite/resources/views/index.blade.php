@extends('layout')

@section('WebpageTitle')
    <title>Il Sogno</title>
@endsection

@section('scripts')

@endsection

@section('content')
@foreach($HomePageContents as $Content)
<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('{{$Content->strHeaderImage}}');">
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
                    <h5 class="description">{{$Content->strHeaderDescription}}</h5>
                </div>
            </div>
@endforeach
            <div class="separator separator-primary"></div>
            <div class="section-story-overview">
                @foreach($HomePagePictures as $Picture)
                <div class="row">
                    <div class="col-md-6">
                        <div class="image-container image-left">
                            <!-- First image on the left side -->
                            <img src="{{$Picture->HomeBodyImage1}}" alt="" class="rounded img-fluid img-raised" style="max-height: 400px; max-width: 700px">

                        </div>
                        <div class="col-md-12">
                        <!-- Second image on the left side of the article -->
                        <div class="image-container image-right">
                            <img src="{{$Picture->HomeBodyImage2}}" alt="" class="img-fluid rounded img-raised" style="max-height: 400px; max-width: 700px">
                        </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <!-- First image on the right side, above the article -->
                        <div class="image-container image-right">
                            <img src="{{$Picture->HomeBodyImage3}}" alt="" class="rounded img-fluid img-raised" style="max-height: 400px; max-width: 700px">
                        </div>
                @endforeach
                        <div class="card text-center place-on-top">
                            <div class="description-center">
                                <h3>Il Sogno Beach Resort...</h3>
                                @foreach($HomePageContents as $Content)
                                <p>{{$Content->strBodyDescription}}</p>
                                @endforeach
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