@extends('layout')

@section('WebpageTitle')
    <title>Web Content Management</title>
@endsection

@section('scripts')

<script src="/js/ItemRental.js" type="text/javascript"></script>
<script src="/js/input-validator.js" type="text/javascript"></script>
<script src="/js/MainJavascript.js" type="text/javascript"></script>

@endsection

@section('content')
<!-- Add success -->
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

<h5 id="TitlePage">Web Content Management</h5>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="blue">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#HomePage" data-toggle="tab">
                                    Home Page
                                <div class="ripple-container"></div></a>
                            </li>
                            <li>
                                <a href="#Accommodation" data-toggle="tab">
                                    Accommodation
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#Packages" data-toggle="tab">
                                    Packages
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#Activities" data-toggle="tab">
                                    Activities
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#Location" data-toggle="tab">
                                    Location
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#AboutUs" data-toggle="tab">
                                    About Us
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#ContactUs" data-toggle="tab">
                                    Contact Us
                                <div class="ripple-container"></div></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="HomePage">
                        <h4 class="text-primary">Home Page</h4>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Header Image</h5>
                                <img src="/img/header-1.jpeg" alt="Rounded Image" class="img-rounded img-responsive RoomTypeImage">
                                <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs">Replace</button>
                            </div>
                            <div class="col-md-5">
                                <h5>Header Description</h5>
                                <div class="form-group">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Header Description</label>
                                        <textarea class="form-control" rows="5" name="RoomDescription"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <br><br>
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Body Image 1</h5>
                                <img src="/img/DefaultImage.png" alt="Rounded Image" class="img-rounded img-responsive RoomTypeImage">
                                <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs">Replace</button>
                            </div>
                            <div class="col-md-4">
                                <h5>Body Image 2</h5>
                                <img src="/img/DefaultImage.png" alt="Rounded Image" class="img-rounded img-responsive RoomTypeImage">
                                <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs">Replace</button>
                            </div>
                            <div class="col-md-4">
                                <h5>Body Image 3</h5>
                                <img src="/img/DefaultImage.png" alt="Rounded Image" class="img-rounded img-responsive RoomTypeImage">
                                <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs">Replace</button>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Body Description</h5>
                                <div class="form-group">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Body Description</label>
                                        <textarea class="form-control" rows="5" name="RoomDescription"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="tab-pane" id="Accommodation">
                        <h4 class="text-primary">Accommodation</h4>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Header Image</h5>
                                <img src="/img/header-2.jpg" alt="Rounded Image" class="img-rounded img-responsive RoomTypeImage">
                                <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs">Replace</button>
                            </div>
                            <div class="col-md-5">
                                <h5>Header Description</h5>
                                <div class="form-group">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Header Description</label>
                                        <textarea class="form-control" rows="5" name="RoomDescription"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="Packages">
                        <h5>Packages</h5>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Header Image</h5>
                                <img src="/img/header-6.jpg" alt="Rounded Image" class="img-rounded img-responsive RoomTypeImage">
                                <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs">Replace</button>
                            </div>
                            <div class="col-md-5">
                                <h5>Header Description</h5>
                                <div class="form-group">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Header Description</label>
                                        <textarea class="form-control" rows="5" name="RoomDescription"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="Activities">
                        <h5>Activities</h5>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Header Image</h5>
                                <img src="/img/header-7.jpg" alt="Rounded Image" class="img-rounded img-responsive RoomTypeImage">
                                <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs">Replace</button>
                            </div>
                            <div class="col-md-5">
                                <h5>Header Description</h5>
                                <div class="form-group">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Header Description</label>
                                        <textarea class="form-control" rows="5" name="RoomDescription"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="Location">
                        <h5>Location</h5>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Header Image</h5>
                                <img src="/img/header-3.jpg" alt="Rounded Image" class="img-rounded img-responsive RoomTypeImage">
                                <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs">Replace</button>
                            </div>
                            <div class="col-md-5">
                                <h5>Header Description</h5>
                                <div class="form-group">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Header Description</label>
                                        <textarea class="form-control" rows="5" name="RoomDescription"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Body Image</h5>
                                <img src="/img/DefaultImage.png" alt="Rounded Image" class="img-rounded img-responsive RoomTypeImage">
                                <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs">Replace</button>
                            </div>
                            <div class="col-md-5">
                                <h5>Body Description</h5>
                                <div class="form-group">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Header Description</label>
                                        <textarea class="form-control" rows="5" name="RoomDescription"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="AboutUs">
                        <h5>About Us</h5>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Header Image</h5>
                                <img src="/img/header-4.jpg" alt="Rounded Image" class="img-rounded img-responsive RoomTypeImage">
                                <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs">Replace</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Body Description 1</h5>
                                <div class="form-group">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control" rows="5" name="RoomDescription"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5>Body Description 2</h5>
                                <div class="form-group">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control" rows="5" name="RoomDescription"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5>Body Description 3</h5>
                                <div class="form-group">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control" rows="5" name="RoomDescription"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="ContactUs">
                        <h5>Contact Us</h5>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Header Image</h5>
                                <img src="/img/header-5.jpg" alt="Rounded Image" class="img-rounded img-responsive RoomTypeImage">
                                <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs">Replace</button>
                            </div>
                            <div class="col-md-5">
                                <h5>Header Description</h5>
                                <div class="form-group">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Header Description</label>
                                        <textarea class="form-control" rows="5" name="RoomDescription"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

