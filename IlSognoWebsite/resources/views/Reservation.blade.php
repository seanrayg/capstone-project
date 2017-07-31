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
        <div class="section section-tabs">
            <div class="container">
                <!-- End .section-navbars  -->
                
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
                                        <strong><p class="description-text text-primary small-margin">Check In Date:</p></strong> <p class="description-text" id="i-CheckInDate">aaa</p><br>
                                        <strong><p class="description-text text-primary small-margin">Check Out Date:</p></strong> <p class="description-text" id='i-CheckOutDate'>aaa</p><br>
                                        <strong><p class="description-text text-primary small-margin">Time of arrival:</p></strong> <p class="description-text" id='i-ArrivalTime'>aaa</p><br>
                                    </div>
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#ModalReservationDate">Change</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
                                                <th class="text-center">Action</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>Duration</td>
                                                    <td>Pax</td>
                                                    <td><span data-toggle="tooltip" data-placement="top" title="Show more info"><button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#" value="" onclick=""><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>Duration</td>
                                                    <td>Pax</td>
                                                    <td><span data-toggle="tooltip" data-placement="top" title="Show more info"><button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#" value="" onclick=""><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>Duration</td>
                                                    <td>Pax</td>
                                                    <td><span data-toggle="tooltip" data-placement="top" title="Show more info"><button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#" value="" onclick=""><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#ModalReservationRoom">Change</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                
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
                                            <div class="col-md-4">
                                                <label class="small-margin">First Name</label>
                                                <div class="form-group">
                                                    <input type="text" value="" class="form-control" id="FirstName" readonly/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small-margin">Middle Name</label>
                                                <div class="form-group">
                                                    <input type="text" value="" class="form-control" id="MiddleName" readonly/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small-margin">Last Name</label>
                                                <div class="form-group">
                                                    <input type="text" value="" class="form-control" id="LastName" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="small-margin">Address</label>
                                                <div class="form-group">
                                                    <input type="text" value="" class="form-control" id="Address" readonly/>
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="small-margin">Contact Number</label>
                                                <div class="form-group">
                                                    <input type="text" value="" class="form-control" id="ContactNumber" readonly/>
                                                </div>    
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small-margin">Email</label>
                                                <div class="form-group">
                                                    <input type="email" value="" class="form-control" id="Email" readonly/>
                                                </div>    
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small-margin">Nationality</label>
                                                <div class="form-group">
                                                    <input type="text" value="" class="form-control" id="Nationality" readonly/>
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Gender</label>
                                                <div class="selectBox">
                                                    <select id="SelectGender" disabled>
                                                      <option>Male</option>
                                                      <option>Female</option>               
                                                    </select>
                                                </div>   
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small-margin">Date of birth</label>
                                                <div class="form-group">
                                                    <input type="text" value="" class="form-control" id="DateofBirth" readonly/>
                                                </div>   
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#ModalGuestInformation">Change</button>
                                    </div>
                                </div>
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
                                                <input type="text" value="" class="form-control" id="NoOfAdults" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small-margin">Number of kids</label>
                                            <div class="form-group">
                                                <input type="text" value="" class="form-control" id="NoOfKids" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                      
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                        <label class="small-margin">Remarks</label>
                                        <textarea class="form-control" rows="5" id="Remarks" readonly></textarea>
                                        </div>
                                    </div>  
                                  </div>
                                </div><br><br>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#ModalReservationInfo">Change</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
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
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <p class="description-text text-primary small-margin">Please attach a photo of your deposit slip</p><br><br><br>
                                        <input type="file" name="myImage" accept="image/*" />
                                    </div>
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
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
                
                <hr>
                
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="title">Cancel Reservation?</h4>
                        <h5 class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus non nisi sed purus accumsan dictum. Ut eget velit velit. Etiam rhoncus ut mauris vel congue.</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-lg btn-primary">Cancel Reservation</button>
                    </div>  
                </div>    
            
            </div>
        </div>
        @include('layouts.footer')
    </div>
    
    <!--Reservation date modal-->
    <div class="modal fade" id="ModalReservationDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Reservation Date</h4>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label>Check in date</label>
                    <div class="form-group" id="CheckInDateError">
                        <input type="text" data-toggle="tooltip" data-placement="left" title="Please choose a date 7 days or more from today" class="form-control date-picker" id="CheckInDate" data-datepicker-color="">
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Check out date</label>
                    <div class="form-group" id="CheckOutDateError">
                        <input type="text" class="form-control date-picker" id="CheckOutDate" data-datepicker-color="">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <label>Time of arrival</label>
                    <div class="selectBox form-group">
                        <select data-toggle="tooltip" data-placement="top" title="Valid pick up time is between 6AM to 5PM" id="PickUpTime">
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                          <option>6</option>
                          <option>7</option>
                          <option>8</option>
                          <option>9</option>
                          <option>10</option>
                          <option>11</option>
                          <option>12</option>                 
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label style="color: transparent"> .</label>
                    <div class="selectBox">
                        <select data-toggle="tooltip" data-placement="top" title="Valid pick up time is between 6AM to 5PM" id="PickUpMinute">
                          <option>00</option>
                          <option>15</option>
                          <option>30</option>
                          <option>45</option>               
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label style="color: transparent"> .</label>
                    <div class="selectBox">
                        <select data-toggle="tooltip" data-placement="top" title="Valid pick up time is between 6AM to 5PM" id="PickUpMerridean">
                          <option>AM</option>
                          <option>PM</option>                
                        </select>
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
    
    <!--- Reservation Information Modal --->
    <div class="modal fade" id="ModalReservationInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Reservation Info</h4>
          </div>
          <div class="modal-body">
                <div class="row">
                     <div class="col-md-6">
                        <label class="small-margin">Number of adults</label>
                        <div class="form-group">
                            <input type="text" value="" class="form-control" id="EditNoOfAdults" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="small-margin">Number of kids</label>
                        <div class="form-group">
                            <input type="text" value="" class="form-control" id="EditNoOfKids" />
                        </div>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-12">
                    <label class="small-margin">Remarks</label>
                    <textarea class="form-control" rows="3" id="EditRemarks" ></textarea>
                    </div>
                </div>  
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default">Close</button>
            <button type="button" class="btn btn-info">Save</button>
          </div>
        </div>
      </div>
    </div>
    
    <!--- Reservation Room Modal -->
    <div class="modal fade" id="ModalReservationRoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content modal-large">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Room Reservation</h4>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-sm-6">
                    <p class="title text-center">Rooms available</p>
                    <div class="table">
                        <table class="text-center stretch-element" id="tblAvailableRooms" onclick="run(event, 'AvailableRooms')">
                            <thead class="text-primary">
                                <th class="text-center">Room</th>
                                <th class="text-center">Capacity</th>
                                <th class="text-center">Rate per day</th>
                                <th class="text-center">Rooms Left</th>
                                <th class="text-center">Action</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Room</td>
                                    <td>Capacity</td>
                                    <td>Rate per day</td>
                                    <td>Rooms left</td>
                                    <td>
                                        <span data-toggle="tooltip" data-placement="top" title="Show more info">
                                            <button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#" value="" onclick=""><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Room</td>
                                    <td>Capacity</td>
                                    <td>Rate per day</td>
                                    <td>Rooms left</td>
                                    <td>
                                        <span data-toggle="tooltip" data-placement="top" title="Show more info">
                                            <button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#" value="" onclick=""><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Room</td>
                                    <td>Capacity</td>
                                    <td>Rate per day</td>
                                    <td>Rooms left</td>
                                    <td>
                                        <span data-toggle="tooltip" data-placement="top" title="Show more info">
                                            <button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#" value="" onclick=""><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <br>
                    <div class="row">
                            <div class="col-md-8">
                                <label class="small-margin"> Quantity</label>
                                <div class="form-group" id="RoomQuantityError">
                                    <input type="text" value="" placeholder="8 years old and below" class="form-control" onkeyup="CheckQuantity(this, 'int', '#RoomQuantityError')" onchange="CheckQuantity(this, 'int', '#RoomQuantityError')" id="RoomQuantity"/>
                                </div>
                                <p class="description-text text-danger" id="QuantityError"></p>
                            </div>
                            <div class="col-md-4">
                                <label style="color: transparent"> .</label>
                                <div class="form-group">
                                    <button class="btn btn-primary pull-right small-margin" onclick="AddRoom()">Choose</button>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <p class="title text-center">Chosen Rooms</p>
                    <div class="table">
                        <table class="text-center stretch-element" id="tblAvailableRooms" onclick="run(event, 'AvailableRooms')">
                            <thead class="text-primary">
                                <th class="text-center">Room</th>
                                <th class="text-center">Capacity</th>
                                <th class="text-center">Rate per day</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Action</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Room</td>
                                    <td>Capacity</td>
                                    <td>Rate per day</td>
                                    <td>Quantity</td>
                                    <td>
                                        <span data-toggle="tooltip" data-placement="top" title="Remove">
                                            <button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#" value="" onclick=""><i class="fa fa-remove"></i></button>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Room</td>
                                    <td>Capacity</td>
                                    <td>Rate per day</td>
                                    <td>Quantity</td>
                                    <td>
                                        <span data-toggle="tooltip" data-placement="top" title="Remove">
                                            <button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#" value="" onclick=""><i class="fa fa-remove"></i></button>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Room</td>
                                    <td>Capacity</td>
                                    <td>Rate per day</td>
                                    <td>Quantity</td>
                                    <td>
                                        <span data-toggle="tooltip" data-placement="top" title="Remove">
                                            <button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#" value="" onclick=""><i class="fa fa-remove"></i></i></button>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <br><br>
                    </div>
                </div>
            </div>
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