@extends('layout')

@section('WebpageTitle')
    <title>Location</title>
@endsection

@section('scripts')

@endsection

@section('content')
@foreach($LocationContents as $Content)
<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('{{$Content->strHeaderImage}}');">
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
                    <h5 class="description">{{$Content->strHeaderDescription}}</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <img src="{{$Content->strBodyImage}}" alt="Raised Image" class="rounded img-raised lrg-image">
                </div>
                
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-block">
                            <div class="row">
                                    <div class="description-center">
                                        <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                                        <p>{{$Content->strBodyDescription}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

          
        </div>
            
    </div>

</div>
@endforeach
@include('layouts.ReservationSection')



@endsection