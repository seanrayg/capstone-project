@extends('layout')

@section('WebpageTitle')
    <title>Package Maintenance</title>
@endsection

@section('scripts')

<script src="/js/PackageMaintenance.js" type="text/javascript"></script>

@endsection

@section('content')

@if(Session::has('flash_message'))
    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            <div class="alert alert-success hide-automatic">
                <div class="container-fluid">
                  <div class="alert-icon">
                    <i class="material-icons">check</i>
                  </div>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                  </button>
                  {{ Session::get('flash_message') }}
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::has('error_message'))
    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            <div class="alert alert-danger">
                <div class="container-fluid">
                  <div class="alert-icon">
                    <i class="material-icons">clear</i>
                  </div>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                  </button>
                  {{ Session::get('error_message') }}
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-3 dropdown">
        <a href="#" class="btn-simple dropdown-toggle" data-toggle="dropdown">
        <h5 id="TitlePage">Package Maintenance</h5>
        <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/Maintenance/Room">Room &amp; Cottage Maintenance</a></li>
            <li><a href="/Maintenance/RoomType">Accomodation Maintenance</a></li>
            <li><a href="/Maintenance/Boat">Boat Maintenance</a></li>
            <li><a href="/Maintenance/Item">Item Maintenance</a></li>
            <li><a href="/Maintenance/Activity">Activity Maintenance</a></li>
            <li><a href="/Maintenance/Operations">Operations Maintenance</a></li>
            <li><a href="/Maintenance/Fee">Fee Maintenance</a></li>

        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Search Packages</label>
            <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('PackageTable' ,'1')">
        </div>
    </div>
    <div class="col-md-6">
        <button type="button" class="btn btn-danger pull-right" onclick="ShowModalDeletePackage()"><i class="material-icons">delete</i> Delete</button>
        <button type="button" class="btn btn-info pull-right" onclick="showEditWebpage()"><i class="material-icons">create</i> Edit</button>
        <a href="/Maintenance/Package/Add"><button type="button" class="btn btn-success pull-right" onclick="#"><i class="material-icons">add</i> Add</button></a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Packages</h4>
                <p class="category"></p>
            </div>
            <div class="card-content table-responsive" onclick="run(event)">
                <table class="table" id="PackageTable">
                    <thead class="text-primary">
                        <th onclick="sortTable(0, 'PackageTable', 'string')">ID</th>
                        <th onclick="sortTable(1, 'PackageTable', 'string')">Name</th>
                        <th onclick="sortTable(2, 'PackageTable', 'string')">Status</th>
                        <th onclick="sortTable(3, 'PackageTable', 'double')">Price</th>
                        <th onclick="sortTable(4, 'PackageTable', 'int')">Pax</th>
                        <th onclick="sortTable(5, 'PackageTable', 'int')">Duration</th>
                        <th onclick="sortTable(6, 'PackageTable', 'string')">Entrance Fee</th>
                        <th onclick="sortTable(7, 'PackageTable', 'string')">Description</th>
                    </thead>
                    <tbody>
                        @foreach ($Packages as $Package)
                        <tr onclick="HighlightRow(this)">
                            <td>{{$Package -> strPackageID}}</td>
                            <td>{{$Package -> strPackageName}}</td>
                            <td>{{$Package -> strPackageStatus}}</td>
                            <td>{{$Package -> dblPackagePrice}}</td>
                            <td>{{$Package -> intPackagePax}}</td>
                            <td>{{$Package -> intPackageDuration}}</td>
                            <td>{{$Package -> intBoatFee}}</td>
                            <td>{{$Package -> strPackageDescription}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>





<div class="row">

    <div class="col-sm-6">
        <div class="card card-stats">

                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">local_hotel</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Package</p>
                        <h5 class="title">Included Rooms</h5>
                    </div>
                    <div class="card-footer">
                        <table class="table" id="tblIncludedRooms">
                            <thead class="text-success">
                                <th onclick="sortTable(0, 'tblIncludedRooms', 'string')">Room</th>
                                <th onclick="sortTable(1, 'tblIncludedRooms', 'int')">Quantity</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>

        </div>
    </div>

    <div class="col-sm-6">
        <div class="card card-stats">

                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">local_offer</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Package</p>
                        <h5 class="title">Included Items</h5>
                    </div>
                    <div class="card-footer">
                        <table class="table" id="tblIncludedItems">
                            <thead class="text-success">
                                <th onclick="sortTable(0, 'tblIncludedItems', 'string')">Item</th>
                                <th onclick="sortTable(1, 'tblIncludedItems', 'int')">Quantity</th>
                                <th onclick="sortTable(2, 'tblIncludedItems', 'int')">Duration(hours)</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-6">
        <div class="card card-stats">

                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">map</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Package</p>
                        <h5 class="title">Included Activities</h5>
                    </div>
                    <div class="card-footer">
                        <table class="table" id="tblIncludedActivities">
                            <thead class="text-success">
                                <th onclick="sortTable(0, 'tblIncludedActivities', 'string')">Activity</th>
                                <th onclick="sortTable(1, 'tblIncludedActivities', 'int')">Quantity</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

        </div>
    </div>

    <div class="col-sm-6">
        <div class="card card-stats">

                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">local_atm</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Package</p>
                        <h5 class="title">Included Fees</h5>
                    </div>
                    <div class="card-footer">
                        <table class="table" id="tblIncludedFees">
                            <thead class="text-success">
                                <th onclick="sortTable(0, 'tblIncludedFees', 'string')">Fee</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

        </div>
    </div>

</div>


@endsection

@section('modals')
<div id="DivModalDeletePackage" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="red">
                            <i class="material-icons">delete</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title">Delete Package?<span class="close" onclick="HideModalDeletePackage()">X</span></h3>
                            <form method="post" action="/Maintenance/Package/Delete">
                                {{ csrf_field() }}
                                <input type="hidden" name="DeletePackageID" id="DeletePackageID" value="">
                                <button type="submit" class="btn btn-info btn-sm pull-right" onclick="HideModalDeletePackage()">Cancel</button>
                                <button type="submit" class="btn btn-danger btn-sm pull-right">Delete</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection