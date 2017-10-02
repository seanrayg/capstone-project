<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Reservation</title>
    @include('layouts.links')
    
    <script src="/js/input-validator.js" type="text/javascript"></script>
    <script src="/js/BookReservation.js" type="text/javascript"></script>
</head>

<body class="profile-page">
    <!-- Navbar -->
    <nav class="navbar navbar-toggleable-md bg-info fixed-top">
        <div class="container">
            <div class="navbar-translate">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <p class="muted-text">Il Sogno Beach Resort</p>
                </a>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navigation" data-nav-image="./assets/img/blurred-image-1.jpg">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/Accomodation">
                            <p>Accomodation</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Packages">
                            <p>Packages</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Activities">
                            <p>Activities</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Location">
                            <p>Location</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/AboutUs">
                            <p>About Us</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ContactUs">
                            <p>Contact Us</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="wrapper">
        <div class="section" filter-color="orange" data-parallax="true" style="background-image: url('/img/book-now3.jpg'); filter: grayscale(50%);">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <br><br>
                        <div class="card" style="opacity: 0.9">
                            <div class="card-block">
                                <div class="team-player">
                                    <h3 class="title">Welcome, user!</h3>
                                    <h5 class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus non nisi sed purus accumsan dictum. Ut eget velit velit. Etiam rhoncus ut mauris vel congue.</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        @if(Session::has('flash_message'))
            <div class="row">
                <div class="col-md-6">
                    <div class="alert alert-success" role="alert">
                        <div class="container">
                            <div class="alert-icon">
                                <i class="now-ui-icons ui-2_like"></i>
                            </div>
                            <strong>Well done!</strong> {{ Session::get('flash_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">
                                    <i class="now-ui-icons ui-1_simple-remove"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="section section-tabs">
            <div class="container">
                <!-- End .section-navbars  -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <ul class="nav nav-tabs nav-tabs-neutral justify-content-center text-center" role="tablist" data-background-color="orange">
                                <li class="nav-item">
                                    <a class="nav-link inactive-link active">
                                        <i class="fa fa-code"></i> Reservation Code
                                    </a>
                                </li>
                            </ul>
                            <div class="card-block" data-toggle="tooltip" data-placement="top" title="Use this to login here in the website">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        @foreach($ReservationInfo as $Info)
                                        <h4 class="title small-margin">{{$Info->strReservationCode}}</h4><br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(sizeof($PackageInfo) > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <ul class="nav nav-tabs nav-tabs-neutral justify-content-center text-center" role="tablist" data-background-color="orange">
                                <li class="nav-item">
                                    <a class="nav-link inactive-link active">
                                        <i class="fa fa-dropbox"></i> Availed Package
                                    </a>
                                </li>
                            </ul>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach($PackageInfo as $Info)
                                        <h5 class="text-primary description-text">Package Availed: </h5><h5 class="description-text">{{$Info->strPackageName}}</h5><br><br>
                                        <p class="description-text text-primary">Package Duration:</p><p class="description-text">{{$Info->intPackageDuration}}</p><br>
                                        <p class="description-text text-primary">Package Pax:</p><p class="description-text">{{$Info->intPackagePax}}</p><br>
                                        <p class="description-text text-primary">Package Rate:</p><p class="description-text">{{$Info->dblPackagePrice}}</p><br>
                                        @endforeach
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-center modal-title">Rooms Included</p>
                                        <div class="table">
                                            <table class="text-center stretch-element" id="tblAvailableRooms" onclick="run(event, 'AvailableRooms')">
                                                <thead class="text-primary">
                                                    <th class="text-center">Room</th>
                                                    <th class="text-center">Quantity Availed</th>
                                                    <th class="text-center">Rate</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($ChosenRooms as $Info)
                                                        <tr>
                                                            <td>{{$Info->strRoomType}}</td>
                                                            <td>{{$Info->TotalRooms}}</td>
                                                            <td>{{$Info->dblRoomRate}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        <br><br>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-center modal-title">Items Included</p>
                                        <div class="table">
                                            <table class="text-center stretch-element" id="tblAvailableRooms" onclick="run(event, 'AvailableRooms')">
                                                <thead class="text-primary">
                                                    <th class="text-center">Item</th>
                                                    <th class="text-center">Free Hours</th>
                                                    <th class="text-center">Quantity</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($PackageItemInfo as $Info)
                                                        <tr>
                                                            <td>{{$Info->strItemName}}</td>
                                                            <td>{{$Info->flPackageIDuration}}</td>
                                                            <td>{{$Info->intPackageIQuantity}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        <br><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-center modal-title">Beach Activities Included</p>
                                        <div class="table">
                                            <table class="text-center stretch-element" id="tblAvailableRooms" onclick="run(event, 'AvailableRooms')">
                                                <thead class="text-primary">
                                                    <th class="text-center">Activity</th>
                                                    <th class="text-center">Quantity</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($PackageActivityInfo as $Info)
                                                        <tr>
                                                            <td>{{$Info->strBeachAName}}</td>
                                                            <td>{{$Info->intPackageAQuantity}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        <br><br>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <p class="text-center modal-title">Fees Included</p>
                                        <div class="table">
                                            <table class="text-center stretch-element" id="tblAvailableRooms" onclick="run(event, 'AvailableRooms')">
                                                <thead class="text-primary">
                                                    <th class="text-center">Fee</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($PackageFeeInfo as $Info)
                                                        <tr>
                                                            <td>{{$Info->strFeeName}}</td>
                                                        </tr>
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        <br><br>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
                @endif

                <h4 class="title text-muted">Reservation Info</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <ul class="nav nav-tabs nav-tabs-neutral justify-content-center text-center" role="tablist" data-background-color="orange">
                                <li class="nav-item">
                                    <a class="nav-link inactive-link active">
                                        <i class="fa fa-calendar-o"></i> Reservation Date
                                    </a>
                                </li>
                            </ul>
                            <div class="card-block">
                                <div class="row">
                                    <div style="margin-left: 20px">
                                        @foreach($ReservationInfo as $Info)
                                        <strong><p class="description-text text-primary small-margin">Check In Date:</p></strong> <p class="description-text" id="i-CheckInDate">{{Carbon\Carbon::parse($Info -> dtmResDArrival)->format('M j, Y')}}</p><br>
                                        <strong><p class="description-text text-primary small-margin">Check Out Date:</p></strong> <p class="description-text" id='i-CheckOutDate'>{{Carbon\Carbon::parse($Info -> dtmResDDeparture)->format('M j, Y')}}</p><br>
                                        <strong><p class="description-text text-primary small-margin">Time of arrival:</p></strong> <p class="description-text" id='i-ArrivalTime'>{{Carbon\Carbon::parse($Info -> dtmResDArrival)->format('h:i A')}}</p><br>
                                        @endforeach
                                    </div>
                                </div>
                                <br><br>
                            </div>
                        </div>
                    </div>
                    @if(sizeof($PackageInfo) == 0)
                    <div class="col-md-8">
                        <div class="card">
                            <ul class="nav nav-tabs nav-tabs-neutral justify-content-center text-center" role="tablist" data-background-color="orange">
                                <li class="nav-item">
                                    <a class="nav-link inactive-link active">
                                        <i class="fa fa-bed"></i> Reserved Rooms
                                    </a>
                                </li>
                            </ul>
                            <div class="card-block">
                                <div class="row">
                                  <div class="table">
                                        <table class="text-center stretch-element" id="tblAvailableRooms" onclick="run(event, 'AvailableRooms')">
                                                <thead class="text-primary">
                                                    <th class="text-center">Room</th>
                                                    <th class="text-center">Quantity Availed</th>
                                                    <th class="text-center">Rate</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($ChosenRooms as $Info)
                                                        <tr>
                                                            <td>{{$Info->strRoomType}}</td>
                                                            <td>{{$Info->TotalRooms}}</td>
                                                            <td>{{$Info->dblRoomRate}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        <br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif 
                </div>
                @foreach($ReservationInfo as $Info)
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <ul class="nav nav-tabs nav-tabs-neutral justify-content-center text-center" role="tablist" data-background-color="orange">
                                <li class="nav-item">
                                    <a class="nav-link inactive-link active">
                                        <i class="fa fa-user-o"></i> Guest Information
                                    </a>
                                </li>
                            </ul>
                            <div class="card-block">
                                <div class="row">
                                    <div style="margin-left: 20px">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="small-margin">Name</label>
                                                <div class="form-group">
                                                    <input type="text" value="{{$Info->Name}}" class="form-control" id="Name" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="small-margin">Address</label>
                                                <div class="form-group">
                                                    <input type="text" value="{{$Info->strCustAddress}}" class="form-control" id="Address" readonly/>
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="small-margin">Contact Number</label>
                                                <div class="form-group">
                                                    <input type="text" value="{{$Info->strCustContact}}" class="form-control" id="ContactNumber" readonly/>
                                                </div>    
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small-margin">Email</label>
                                                <div class="form-group">
                                                    <input type="email" value="{{$Info->strCustEmail}}" class="form-control" id="Email" readonly/>
                                                </div>    
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small-margin">Nationality</label>
                                                <div class="form-group">
                                                    <input type="text" value="{{$Info->strCustNationality}}" class="form-control" id="Nationality" readonly/>
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Gender</label>
                                                <div class="selectBox">
                                                    @if($Info->strCustGender == "M")
                                                    <select id="SelectGender" disabled>
                                                      <option selected>Male</option>
                                                      <option>Female</option>               
                                                    </select>
                                                    @else
                                                    <select id="SelectGender" disabled>
                                                      <option>Male</option>
                                                      <option selected>Female</option>               
                                                    </select>
                                                    @endif
                                                </div>   
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small-margin">Date of birth</label>
                                                <div class="form-group">
                                                    <input type="text" value="{{Carbon\Carbon::parse($Info -> dtmCustBirthday)->format('m/d/Y')}}" class="form-control" id="DateofBirth" readonly/>
                                                </div>   
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <br><br>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="card">
                            <ul class="nav nav-tabs nav-tabs-neutral justify-content-center text-center" role="tablist" data-background-color="orange">
                                <li class="nav-item">
                                    <a class="nav-link inactive-link active">
                                        <i class="fa fa-bed"></i> Reservation Info
                                    </a>
                                </li>
                            </ul>
                            <div class="card-block">
                                <div class="row">
                                  <div style="margin-left: 20px">
                                    <div class="row">
                                         <div class="col-md-6">
                                            <label class="small-margin">Number of adults</label>
                                            <div class="form-group">
                                                <input type="text" value="{{$Info->intResDNoOfAdults}}" class="form-control" id="NoOfAdults" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small-margin">Number of kids</label>
                                            <div class="form-group">
                                                <input type="text" value="{{$Info->intResDNoOfKids}}" class="form-control" id="NoOfKids" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                      
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                        <label class="small-margin">Remarks</label>
                                        <textarea class="form-control" rows="5" id="Remarks" readonly>{{$Info->strResDRemarks}}</textarea>
                                        </div>
                                    </div>  
                                  </div>
                                </div><br><br>
                            </div>
                        </div>
                    </div> 
                </div>

                @endforeach
            </div>
        </div>
        
        <div class="section" filter-color="orange" data-parallax="true" style="background-image: url('/img/book-now3.jpg'); filter: grayscale(50%);">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <br><br>
                        <div class="card" style="opacity: 0.9">
                            <div class="card-block">
                                <div class="team-player">
                                    <h3 class="title">Already paid?</h3>
                                    <h5 class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus non nisi sed purus accumsan dictum. Ut eget velit velit. Etiam rhoncus ut mauris vel congue.</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                
        <div class="section section-tabs">
            <div class="container">
                @foreach($ReservationInfo as $Info)
                    @if($Info->strResDDepositSlip == null)
                        <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                                <div class="card">
                                    <ul class="nav nav-tabs nav-tabs-neutral justify-content-center text-center" role="tablist" data-background-color="orange">
                                        <li class="nav-item">
                                            <a class="nav-link inactive-link active">
                                                <i class="fa fa-calendar-o"></i> Deposit Slip
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="card-block">
                                        <form method="post" action="/Reservation/DepositSlip" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            @foreach($ReservationInfo as $Info)
                                            <input type="hidden" name="DepositReservationID" id="DepositReservationID" value="{{$Info->strReservationID}}">
                                            @endforeach
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <p class="description-text text-primary small-margin">Please attach a photo of your deposit slip</p><br><br><br>
                                                    <input type="file" name="depositSlip" accept="image/*" required/>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="row">
                                                <div class="col-md-12 text-right">
                                                    <button class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <ul class="nav nav-tabs nav-tabs-neutral justify-content-center text-center" role="tablist" data-background-color="orange">
                                        <li class="nav-item">
                                            <a class="nav-link inactive-link active">
                                                <i class="fa fa-calendar-o"></i> Payment Status
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h4 class="title small-margin">Not Paid</h4><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <div class="card">
                                    <ul class="nav nav-tabs nav-tabs-neutral justify-content-center text-center" role="tablist" data-background-color="orange">
                                        <li class="nav-item">
                                            <a class="nav-link inactive-link active">
                                                <i class="fa fa-calendar-o"></i> Deposit Slip
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="card-block">
                                        <img src="{{$Info->strResDDepositSlip}}" data-toggle="tooltip" data-placement="top" title="Please call the resort to confirm your reservation" style="max-width:300px; max-height: 300px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <ul class="nav nav-tabs nav-tabs-neutral justify-content-center text-center" role="tablist" data-background-color="orange">
                                        <li class="nav-item">
                                            <a class="nav-link inactive-link active">
                                                <i class="fa fa-calendar-o"></i> Payment Status
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h4 class="title small-margin" data-toggle="tooltip" data-placement="top" title="Please call the resort to confirm your reservation">Pending</h4><br>
                                                <p class="description-text">Please call the resort to confirm your reservation. To see resort's contact information, please click <a href="/ContactUs" class="text-primary">here</a> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <hr>
                
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="title">Cancel Reservation?</h4>
                        <h5 class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus non nisi sed purus accumsan dictum. Ut eget velit velit. Etiam rhoncus ut mauris vel congue.</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#ModalCancelReservation">Cancel Reservation</button>
                    </div>  
                </div>    
            
            </div>
        </div>
        @include('layouts.footer')
    </div>
    
    <!--Cancel Reservation Modal-->
<div class="modal fade" id="ModalCancelReservation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="position: absolute; width: 500px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-center">Are you sure you want to cancel your reservation?</h4>
      </div>
      <div class="modal-body text-center">
        <p class="description-text">There will be no refund if you already paid your downpayment. We encourage you to reschedule your reservation instead of cancelling.</p><br>
        <form method="POST" action="/Reservation/Cancel">
            {{ csrf_field() }}
            @foreach($ReservationInfo as $Info)
                <input type="hidden" name="CancelReservationID" id="CancelReservationID" value = "{{$Info->strReservationID}}">
            @endforeach
            <br>
            <button type="button" data-dismiss="modal" class="pull-left btn btn-primary">Close This</button>
            <button type="submit" class="pull-right btn btn-primary">Cancel Reservation</button>
         </form>
      </div>
    </div>
  </div>
</div>
    
    
    <!--- Guest Information Modal -->
    <div class="modal fade" id="ModalGuestInformation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="position: absolute; width: 700px; left: -100px;">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Reservation Information</h4>
          </div>
          <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="small-margin">First Name</label>
                            <div class="form-group">
                                <input type="text" value="" class="form-control" id="EditFirstName" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="small-margin">Middle Name</label>
                            <div class="form-group">
                                <input type="text" value="" class="form-control" id="EditMiddleName" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="small-margin">Last Name</label>
                            <div class="form-group">
                                <input type="text" value="" class="form-control" id="EditLastName" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="small-margin">Address</label>
                            <div class="form-group">
                                <input type="text" value="" class="form-control" id="EditAddress" />
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="small-margin">Contact Number</label>
                            <div class="form-group">
                                <input type="text" value="" class="form-control" id="EditContactNumber" />
                            </div>    
                        </div>
                        <div class="col-md-4">
                            <label class="small-margin">Email</label>
                            <div class="form-group">
                                <input type="email" value="" class="form-control" id="EditEmail" />
                            </div>    
                        </div>
                        <div class="col-md-4">
                            <label class="small-margin">Nationality</label>
                            <div class="form-group">
                                <input type="text" value="" class="form-control" id="EditNationality" />
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Gender</label>
                            <div class="selectBox">
                                <select id="EditSelectGender" >
                                  <option>Male</option>
                                  <option>Female</option>               
                                </select>
                            </div>   
                        </div>
                        <div class="col-md-6">
                            <label class="small-margin">Date of birth</label>
                            <div class="form-group">
                                <input type="text" value="" class="form-control" id="EditDateofBirth" />
                            </div>   
                        </div>
                    </div>
            <br><br><br>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default">Close</button>
            <button type="button" class="btn btn-info">Save</button>
          </div>
        </div>
      </div>
    </div>
    
    
</body>


</html>