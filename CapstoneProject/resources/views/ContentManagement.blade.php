@extends('layout')

@section('WebpageTitle')
    <title>Web Content Management</title>
@endsection

@section('scripts')

<script src="/js/ContentManagement.js" type="text/javascript"></script>
<script src="/js/input-validator.js" type="text/javascript"></script>

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
                        @foreach($HomePageContents as $Content)
                        <h4 class="text-primary">Home Page</h4>
                        <br>
                        <form method="post" action="/Utilities/Web/HomePage" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Header Image</h5>
                                    <img src="{{$Content->strHeaderImage}}" alt="Rounded Image" id="HomePagePicture" class="img-rounded img-responsive RoomTypeImage">
                                    <br>
                                    <input type="file" id="HomePageHeader" name="HomePageHeader" class="ContentImage" style="display:none">
                                    <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs" onclick="ShowInputFile('HomePageHeader')">Replace</button>
                                </div>
                                <div class="col-md-5">
                                    <h5>Header Description</h5>
                                    <div class="form-group">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Header Description</label>
                                            <textarea class="form-control" rows="5" rel="tooltip" title="Default description will be saved if this is submitted empty" id="HomePageHeaderDesc" name="HomePageHeaderDesc">{{$Content->strHeaderDescription}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @foreach($HomePagePictures as $Picture)
                            <br><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <h5>Body Image 1</h5>
                                    <img src="{{$Picture->HomeBodyImage1}}" alt="Rounded Image" id="HomeBodyPicture1" class="img-rounded img-responsive RoomTypeImage">
                                    <br>
                                    <input type="file" id="HomeBodyImage1" name="HomeBodyImage1" class="ContentImage" style="display:none">
                                    <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs" onclick="ShowInputFile('HomeBodyImage1')">Replace</button>
                                </div>
                                <div class="col-md-4">
                                    <h5>Body Image 2</h5>
                                    <img src="{{$Picture->HomeBodyImage2}}" alt="Rounded Image" id="HomeBodyPicture2" class="img-rounded img-responsive RoomTypeImage">
                                    <br>
                                    <input type="file" id="HomeBodyImage2" name="HomeBodyImage2" class="ContentImage" style="display:none">
                                    <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs" onclick="ShowInputFile('HomeBodyImage2')">Replace</button>
                                </div>
                                <div class="col-md-4">
                                    <h5>Body Image 3</h5>
                                    <img src="{{$Picture->HomeBodyImage3}}" alt="Rounded Image" id="HomeBodyPicture3" class="img-rounded img-responsive RoomTypeImage">
                                    <br>
                                    <input type="file" id="HomeBodyImage3" name="HomeBodyImage3" class="ContentImage" style="display:none">
                                    <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs" onclick="ShowInputFile('HomeBodyImage3')">Replace</button>
                                </div>
                            </div>
                        @endforeach
                            <br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Body Description</h5>
                                    <div class="form-group">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Body Description</label>
                                            <textarea class="form-control" rows="5" name="HomePageBodyDesc" rel="tooltip" title="Default description will be saved if this is submitted empty">{{$Content->strBodyDescription}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success pull-right push-right">Save Changes</button>
                        </form>
                    @endforeach
                    </div>
                    
                    <div class="tab-pane" id="Accommodation">
                        <h4 class="text-primary">Accommodation</h4>
                        <br>
                        <form method="post" action="/Utilities/Web/Accommodation" enctype="multipart/form-data">
                            <div class="row">       
                                {{ csrf_field() }}
                                @foreach($AccommodationContents as $Content)
                                <div class="col-md-6">
                                    <h5>Header Image</h5>
                                    <img src="{{$Content->strHeaderImage}}" alt="Rounded Image" id="AccommodationPicture" class="img-rounded img-responsive RoomTypeImage">
                                    <br>
                                    <input type="file" id="AccommodationHeader" name="AccommodationHeader" class="ContentImage" style="display:none">
                                    <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs" onclick="ShowInputFile('AccommodationHeader')">Replace</button>
                                </div>
                                <div class="col-md-5">
                                    <h5>Header Description</h5>
                                    <div class="form-group">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Header Description</label>
                                            <textarea class="form-control" rows="5" name="AccommodationDescription">{{$Content->strHeaderDescription}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        <button type="submit" class="btn btn-success pull-right push-right">Save Changes</button>
                        </form>
                    </div>

                    <div class="tab-pane" id="Packages">
                        <h5>Packages</h5>
                        <br>
                        <form method="post" action="/Utilities/Web/Packages" enctype="multipart/form-data">
                            <div class="row">       
                                {{ csrf_field() }}
                                @foreach($PackagesContents as $Content)
                                <div class="col-md-6">
                                    <h5>Header Image</h5>
                                    <img src="{{$Content->strHeaderImage}}" alt="Rounded Image" id="PackagesPicture" class="img-rounded img-responsive RoomTypeImage">
                                    <br>
                                    <input type="file" id="PackagesHeader" name="PackagesHeader" class="ContentImage" style="display:none">
                                    <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs" onclick="ShowInputFile('PackagesHeader')">Replace</button>
                                </div>
                                <div class="col-md-5">
                                    <h5>Header Description</h5>
                                    <div class="form-group">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Header Description</label>
                                            <textarea class="form-control" rows="5" name="PackagesDescription">{{$Content->strHeaderDescription}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        <button type="submit" class="btn btn-success pull-right push-right">Save Changes</button>
                        </form>
                    </div>
                    
                    <div class="tab-pane" id="Activities">
                        <h5>Activities</h5>
                        <br>
                        <form method="post" action="/Utilities/Web/Activities" enctype="multipart/form-data">
                            <div class="row">       
                                {{ csrf_field() }}
                                @foreach($ActivitiesContents as $Content)
                                <div class="col-md-6">
                                    <h5>Header Image</h5>
                                    <img src="{{$Content->strHeaderImage}}" alt="Rounded Image" id="ActivitiesPicture" class="img-rounded img-responsive RoomTypeImage">
                                    <br>
                                    <input type="file" id="ActivitiesHeader" name="ActivitiesHeader" class="ContentImage" style="display:none">
                                    <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs" onclick="ShowInputFile('ActivitiesHeader')">Replace</button>
                                </div>
                                <div class="col-md-5">
                                    <h5>Header Description</h5>
                                    <div class="form-group">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Header Description</label>
                                            <textarea class="form-control" rows="5" name="ActivitiesDescription">{{$Content->strHeaderDescription}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        <button type="submit" class="btn btn-success pull-right push-right">Save Changes</button>
                        </form>
                    </div>

                    <div class="tab-pane" id="Location">
                        <h5>Location</h5>
                        <br>
                        <form method="post" action="/Utilities/Web/Location" enctype="multipart/form-data">
                            <div class="row">       
                                {{ csrf_field() }}
                                @foreach($LocationContents as $Content)
                                <div class="col-md-6">
                                    <h5>Header Image</h5>
                                    <img src="{{$Content->strHeaderImage}}" alt="Rounded Image" id="LocationPicture" class="img-rounded img-responsive RoomTypeImage">
                                    <br>
                                    <input type="file" id="LocationHeader" name="LocationHeader" class="ContentImage" style="display:none">
                                    <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs" onclick="ShowInputFile('LocationHeader')">Replace</button>
                                </div>
                                <div class="col-md-5">
                                    <h5>Header Description</h5>
                                    <div class="form-group">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Header Description</label>
                                            <textarea class="form-control" rows="5" name="LocationDescription">{{$Content->strHeaderDescription}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Body Image</h5>
                                    <img src="{{$Content->strBodyImage}}" alt="Rounded Image" id="LocationBodyPicture" class="img-rounded img-responsive RoomTypeImage">
                                    <br>
                                    <input type="file" id="LocationBody" name="LocationBody" class="ContentImage" style="display:none">
                                    <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs" onclick="ShowInputFile('LocationBody')">Replace</button>
                                </div>
                                <div class="col-md-5">
                                    <h5>Body Description</h5>
                                    <div class="form-group">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Body Description</label>
                                            <textarea class="form-control" rows="5" name="LocationBodyDescription" id="LocationBodyDescription">{{$Content->strBodyDescription}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        <button type="submit" class="btn btn-success pull-right push-right">Save Changes</button>
                        </form>
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
                        <form method="post" action="/Utilities/Web/Contacts" enctype="multipart/form-data">
                            <div class="row">       
                                {{ csrf_field() }}
                                @foreach($ContactsContents as $Content)
                                <div class="col-md-6">
                                    <h5>Header Image</h5>
                                    <img src="{{$Content->strHeaderImage}}" alt="Rounded Image" id="ContactsPicture" class="img-rounded img-responsive RoomTypeImage">
                                    <br>
                                    <input type="file" id="ContactsHeader" name="ContactsHeader" class="ContentImage" style="display:none">
                                    <button type="button" rel="tooltip" title="Replace Image" class="btn btn-success btn-xs" onclick="ShowInputFile('ContactsHeader')">Replace</button>
                                </div>
                                <div class="col-md-5">
                                    <h5>Header Description</h5>
                                    <div class="form-group">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Header Description</label>
                                            <textarea class="form-control" rows="5" name="ContactsDescription">{{$Content->strHeaderDescription}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        <button type="submit" class="btn btn-success pull-right push-right">Save Changes</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

