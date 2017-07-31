@extends('layout')

@section('WebpageTitle')
    <title>Accomodation</title>
@endsection

@section('scripts')

@endsection

@section('content')
<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('/img/header-2.jpg');">
    </div>
    <div class="container">
        <div class="content-center brand">
            <h1 class="h1-seo">Il Sogno</h1>
            <h3>Accomodation</h3>
        </div>
    </div>
</div>

<div class="main">
            
    <!-- End .section-navbars  -->
            <div class="section section-tabs">
                <div class="container">
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2 text-center">
                            <h2 class="title">Accomodation</h2>
                            <h5 class="description">Sed at tortor ut eros suscipit tincidunt. Sed blandit massa arcu, nec mattis mi commodo sit amet.</h5>
                        </div>
                    </div>
                    
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
                                        @if($RoomType -> intRoomTCategory == 'Room')
                                        <img src="/img/Rooms/Room1.jpg" alt="Raised Image" class="rounded img-raised med-image">
                                        @else
                                        <img src="/img/Rooms/Cottage1.jpg" alt="Raised Image" class="rounded img-raised med-image">
                                        @endif
                                    </div>                         
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="title">{{$RoomType -> strRoomType}}</h4>
                                        <p class="category text-primary">{{$RoomType -> intRoomTCategory}}</p>
                                        <p class="description">Sed at tortor ut eros suscipit tincidunt. Sed blandit massa arcu, nec mattis mi commodo sit amet.</p>
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