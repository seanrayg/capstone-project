@extends('layout')

@section('WebpageTitle')
    <title>Website Maintenance</title>
@endsection


@section('content')
<div class="row">
    <div class="col-md-3 dropdown">
        <a href="#" class="btn-simple dropdown-toggle" data-toggle="dropdown">
        <h5 id="TitlePage">Website Maintenance</h5>
        <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/Maintenance/Room">Room &amp; Cottage Maintenance</a></li>
            <li><a href="/Maintenance/RoomType">Accomodation Maintenance</a></li>
            <li><a href="/Maintenance/Boat">Boat Maintenance</a></li>
            <li><a href="/Maintenance/Item">Item Maintenance</a></li>
            <li><a href="/Maintenance/Activity">Activity Maintenance</a></li>
            <li><a href="/Maintenance/Operations">Operations Maintenance</a></li>
            <li><a href="/Maintenance/Package">Package Maintenance</a></li>
            <li><a href="/Maintenance/Fee">Fee Maintenance</a></li>
        </ul>
    </div>
</div>



@endsection