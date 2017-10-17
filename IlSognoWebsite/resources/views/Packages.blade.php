@extends('layout')

@section('WebpageTitle')
    <title>Packages</title>
@endsection

@section('scripts')
    
    <script>
        
        function GetRoomInfo(field){
            $.ajax({
                type:'get',
                url:'/Package/RoomInfo',
                data:{RoomName:field.value},
                success:function(data){
                    console.log('success');
                    document.getElementById("RoomTypeName").innerHTML = field.value;
                    document.getElementById("RoomCategory").innerHTML = data[0].intRoomTCategory;
                    document.getElementById("RoomRate").innerHTML = data[0].dblRoomRate;
                    document.getElementById("RoomCapacity").innerHTML = data[0].intRoomTCapacity;
                    document.getElementById("NoOfBeds").innerHTML = data[0].intRoomTNoOfBeds;
                    document.getElementById("NoOfBathrooms").innerHTML = data[0].intRoomTNoOfBathrooms;
                    document.getElementById("RoomAircondition").innerHTML = data[0].intRoomTAirconditioned;
                    document.getElementById("RoomDescription").innerHTML = data[0].strRoomDescription;
                },
                error:function(response){
                    console.log(response);
                }
            });
        }
        
        function GetActivityInfo(field){
            $.ajax({
                type:'get',
                url:'/Package/ActivityInfo',
                data:{ActivityName:field.value},
                success:function(data){
                    console.log('success');
                    document.getElementById("ActivityName").innerHTML = field.value;
                    document.getElementById("ActivityRate").innerHTML = data[0].dblBeachARate;
                    document.getElementById("ActivityDescription").innerHTML = data[0].strBeachADescription;
     
                },
                error:function(response){
                    console.log(response);
                }
            });
        }
        
        function GetItemInfo(field){
            $.ajax({
                type:'get',
                url:'/Package/ItemInfo',
                data:{ItemName:field.value},
                success:function(data){
                    console.log('success');
                    document.getElementById("ItemName").innerHTML = field.value;
                    document.getElementById("ItemRate").innerHTML = data[0].dblItemRate;
                    document.getElementById("ItemDescription").innerHTML = data[0].strItemDescription;
                },
                error:function(response){
                    console.log(response);
                }
            });
        }
        
    </script>

@endsection

@section('content')
@foreach($PackagesContents as $Content)
<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('{{$Content->strHeaderImage}}');">
    </div>
    <div class="container">
        <div class="content-center brand">
            <h1 class="h1-seo">Il Sogno</h1>
            <h3>Packages</h3>
        </div>
    </div>
</div>

<div class="main">
    
    <div class="section section-tabs">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h2 class="title">Packages</h2>
                    <h5 class="description">{{$Content->strHeaderDescription}}</h5>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <h5 class="h1-seo text-center">Packages Offered</h5>
                </div>
            </div>
@endforeach            
            
            <div class="row">
                @foreach($Packages as $Package)
                <div class="col-md-12">
                    <div class="card text-center">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="title">{{$Package->strPackageName}}</h4>
                                    <p class="description"></p>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="text-primary">Package Pax:</label> <p class="description-text">{{$Package->intPackagePax}}</p><br>
                                            <label class="text-primary">Transportation Fee:</label> <p class="description-text">{{$Package->intBoatFee}}</p><br>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="text-primary">Package Duration:</label> <p class="description-text">{{$Package->intPackageDuration}}</p><br>
                                            <label class="text-primary">Package Rate:</label> <p class="description-text">{{$Package->dblPackagePrice}}</p><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            <h6 class="title">Package Inclusion</h6><br>
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <p class="text-muted text-center">Rooms Included</p>
                                    <div class="row">
                                            <table class="table" id="PackageTable">
                                                <thead class="text-primary">
                                                    <th class="text-center">Room</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Action</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($PackageRoomInfo as $Room)
                                                    @if($Room->strPackageRPackageID == $Package->strPackageID)
                                                    <tr>
                                                        <td>{{$Room->strRoomType}}</td>
                                                        <td>{{$Room->intPackageRQuantity}}</td>
                                                        <td><span data-toggle="tooltip" data-placement="top" title="Show more info"><button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#ModalRoomInfo" value="{{$Room->strRoomType}}" onclick="GetRoomInfo(this)"><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button></span></td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>          
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <p class="text-muted text-center">Beach Activities Included</p>
                                    <div class="row">
                                        <table class="table" id="PackageTable">
                                            <thead class="text-primary">
                                                <th class="text-center">Beach Activity</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Action</th>
                                            </thead>
                                            <tbody>
                                                @foreach($PackageActivityInfo as $Activity)
                                                    @if($Activity->strPackageAPackageID == $Package->strPackageID)
                                                    <tr>
                                                        <td>{{$Activity->strBeachAName}}</td>
                                                        <td>{{$Activity->intPackageAQuantity}}</td>
                                                        <td><span data-toggle="tooltip" data-placement="top" title="Show more info"><button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#ModalActivityInfo" value="{{$Activity->strBeachAName}}" onclick="GetActivityInfo(this)"><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button></span></td>
                                                    </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><br>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted text-center">Rental Items Included</p>
                                    <div class="row">
                                        <table class="table" id="PackageTable">
                                            <thead class="text-primary">
                                                <th class="text-center">Rental Item</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Free Hours</th>
                                                <th class="text-center">Action</th>
                                            </thead>
                                            <tbody>
                                                @foreach($PackageItemInfo as $Item)
                                                @if($Item->strPackageIPackageID == $Package->strPackageID)
                                                    <tr>
                                                        <td>{{$Item->strItemName}}</td>
                                                        <td>{{$Item->intPackageIQuantity}}</td>
                                                        <td>{{$Item->flPackageIDuration}}</td>
                                                        <td><span data-toggle="tooltip" data-placement="top" title="Show more info"><button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#ModalItemInfo" value="{{$Item->strItemName}}" onclick="GetItemInfo(this)"><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button></span></td>
                                                    </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <p class="text-muted text-center">Other Fees Included</p>
                                    <div class="row">
                                        <table class="table" id="PackageTable">
                                            <thead class="text-primary">
                                                <th class="text-center">Fee</th>
                                                <th class="text-center">Regular Cost</th>
                                            </thead>
                                            <tbody>
                                                @foreach($PackageFeeInfo as $Fee)
                                                    @if($Fee->strPackageFPackageID == $Package->strPackageID)
                                                        <tr>
                                                            <td>{{$Fee->strFeeName}}</td>
                                                            <td>{{$Fee->dblFeeAmount}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><br>
                            
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

<!--------------MODALS---------------->

@section('modals')

<!--Room Modal-->
<div class="modal fade" id="ModalRoomInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="position: absolute; width: 500px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="RoomTypeName"></h4>
      </div>
      <div class="modal-body">
         <div class="text-center">
            <img src="/img/Rooms/Room1.jpg" alt="Raised Image" class="rounded img-raised med-image"><br> 
         </div>
         <label class="text-primary">Room Category:</label> <p class="description-text" id="RoomCategory"></p><br>
         <label class="text-primary">Room Rate:</label> <p class="description-text" id="RoomRate"></p><br>
         <label class="text-primary">Room Capacity:</label> <p class="description-text" id="RoomCapacity"></p><br>
         <label class="text-primary">Number of Beds:</label> <p class="description-text" id=NoOfBeds></p><br>
         <label class="text-primary">Number of Bathrooms:</label> <p class="description-text" id="NoOfBathrooms"></p><br>
         <label class="text-primary">Aircondition:</label> <p class="description-text" id="RoomAircondition"></p><br>
         <label class="text-primary">Room Description:</label> <p class="description-text" id="RoomDescription"></p><br>
      </div>
    </div>
  </div>
</div>


<!--Activity Modal-->
<div class="modal fade" id="ModalActivityInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="ActivityName"></h4>
      </div>
      <div class="modal-body">
         <label class="text-primary">Activity Rate:</label> <p class="description-text" id="ActivityRate"></p><br>
         <label class="text-primary">Activity Description:</label> <p class="description-text" id="ActivityDescription"></p><br>
      </div>
    </div>
  </div>
</div>


<!--Item Modal-->
<div class="modal fade" id="ModalItemInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="ItemName"></h4>
      </div>
      <div class="modal-body">
         <label class="text-primary">Item Rate:</label> <p class="description-text" id="ItemRate"></p><br>
         <label class="text-primary">Item Description:</label> <p class="description-text" id="ItemDescription"></p><br>
      </div>
    </div>
  </div>
</div>

@endsection