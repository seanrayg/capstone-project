@extends('layout')

@section('WebpageTitle')
    <title>Maintenance</title>
@endsection

@section('content')
<h5 id="TitlePage">Maintenance</h5>
<div class="row">
                        
    <div class="col-lg-4">
        <div class="card card-stats">
            <a href="/Maintenance/Room">
                <div class="card-header" data-background-color="red">
                    <i class="material-icons">local_hotel</i>
                </div>
                <div class="card-content">
                    <p class="category"></p>
                    <h4 class="title">Rooms</h4>
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
            <a href="/Maintenance/RoomType">
                <div class="card-header" data-background-color="green">
                    <i class="material-icons">home</i>
                </div>
                <div class="card-content">
                    <p class="category"></p>
                    <h4 class="title">Room Type</h4>
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

<div class="row">

    <div class="col-lg-4">
        <div class="card card-stats">
            <a href="/Maintenance/Fee">
                <div class="card-header" data-background-color="teal">
                    <i class="material-icons">local_atm</i>
                </div>
                <div class="card-content">
                    <p class="category"></p>
                    <h4 class="title">Fees</h4>
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
            <a href="/Maintenance/Package">
                <div class="card-header" data-background-color="orange">
                    <i class="material-icons">pages</i>
                </div>
                <div class="card-content">
                    <p class="category"></p>
                    <h4 class="title">Package</h4>
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
            <a href="/Maintenance/Activity">
                <div class="card-header" data-background-color="pink">
                    <i class="material-icons">map</i>
                </div>
                <div class="card-content">
                    <p class="category"></p>
                    <h4 class="title">Activities</h4>
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

<div class="row">
    <div class="col-lg-4">
        <div class="card card-stats">
            <a href="/Maintenance/Item">
                <div class="card-header" data-background-color="purple">
                    <i class="material-icons">local_offer</i>
                </div>
                <div class="card-content">
                    <p class="category"></p>
                    <h4 class="title">Items</h4>
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
            <a href="/Maintenance/Operations">
                <div class="card-header" data-background-color="blue">
                    <i class="material-icons">today</i>
                </div>
                <div class="card-content">
                    <p class="category"></p>
                    <h4 class="title">Operation</h4>
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
            <a href="/Maintenance/BoatPersonnel">
                <div class="card-header" data-background-color="yellow">
                    <i class="material-icons">rowing</i>
                </div>
                <div class="card-content">
                    <p class="category"></p>
                    <h4 class="title">Boat Personnel</h4>
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