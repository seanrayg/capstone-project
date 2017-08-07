@extends('layout')

@section('WebpageTitle')
    <title>Il Sogno</title>
@endsection

@section('scripts')
    <script>


    </script>
@endsection

@section('content')
<h5 id="TitlePage">Reports</h5>

<div class="row">
                        
    <div class="col-lg-4">
        <div class="card card-stats" rel="tooltip" title="Maintain physical rooms and cottages in the resort">
            <a href="/Maintenance/Room">
                <div class="card-header" data-background-color="red">
                    <i class="material-icons">local_hotel</i>
                </div>
                <div class="card-content">
                    <p class="category"></p>
                    <h4 class="title">Rooms &amp; Cottages</h4>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons text-danger"></i><a href="#pablo"></a>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-stats">
            <a href="/Maintenance/RoomType" rel="tooltip" title="Maintain descriptions of rooms and cottages in the resort">
                <div class="card-header" data-background-color="green">
                    <i class="material-icons">home</i>
                </div>
                <div class="card-content">
                    <p class="category"></p>
                    <h4 class="title">Accomodation</h4>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons text-danger"></i><a href="#pablo"></a>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-stats" rel="tooltip" title="Maintain boats used in the resort">
            <a href="/Maintenance/Boat">
                <div class="card-header" data-background-color="dark-blue">
                    <i class="material-icons">directions_boat</i>
                </div>
                <div class="card-content">
                    <p class="category"></p>
                    <h4 class="title">Boats</h4>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons text-danger"></i><a href="#pablo"></a>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
</div>

@endsection