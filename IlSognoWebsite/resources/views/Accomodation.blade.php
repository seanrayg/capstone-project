@extends('layout')

@section('WebpageTitle')
    <title>Accommodation</title>
@endsection

@section('scripts')

@endsection

@section('content')
@foreach($AccommodationContents as $Content)
<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('{{$Content->strHeaderImage}}');">
    </div>
    <div class="container">
        <div class="content-center brand">
            <h1 class="h1-seo">Il Sogno</h1>
            <h3>Accommodation</h3>
        </div>
    </div>
</div>

<div class="main">
            
    <!-- End .section-navbars  -->
            <div class="section section-tabs">
                <div class="container">
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2 text-center">
                            <h2 class="title">Accommodation</h2>
                            <h5 class="description">{{$Content->strHeaderDescription}}</h5>
                        </div>
                    </div>
@endforeach
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="h1-seo text-center">Rooms and Cottages</h5>
                        </div>
                    </div>
                    
                    <div class="row">
                    
                    @foreach($RoomTypes as $RoomType)
                    <div class="col-md-6">
                        <div class="card text-center">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <img src="{{$RoomType->RoomImage}}" alt="Raised Image" class="rounded img-raised med-image cursor-pointer" rel="tooltip" title="Click image to see more" onclick="ShowImages('{{$RoomType->strRoomTypeID}}')">
                                    </div>                         
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="title">{{$RoomType -> strRoomType}}</h4>
                                        <p class="category text-primary">{{$RoomType -> intRoomTCategory}}</p>
                                        <p class="description"></p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="text-primary">Capacity:</label> <p class="description-text">{{$RoomType -> intRoomTCapacity}}</p><br>
                                                @if($RoomType -> intRoomTCategory == 'Room')
                                                <label class="text-primary">Number of beds:</label> <p class="description-text">{{$RoomType -> intRoomTNoOfBeds}}</p><br>
                                                <label class="text-primary">Number of Bathrooms:</label> <p class="description-text">{{$RoomType -> intRoomTNoOfBathrooms}}</p><br>
                                                @endif
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="text-primary">Rate per day:</label> <p class="description-text">{{$RoomType -> dblRoomRate}}</p><br>
                                                @if($RoomType -> intRoomTCategory == 'Room')
                                                <label class="text-primary">Aircondition:</label> <p class="description-text">{{$RoomType -> intRoomTAirconditioned}}</p><br>
                                                @endif
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

@include('layouts.ReservationSection')



@endsection