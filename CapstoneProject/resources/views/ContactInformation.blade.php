@extends('layout')

@section('WebpageTitle')
    <title>Contact Information</title>
@endsection

@section('scripts')
    <script src="/js/ContactInformation.js" type="text/javascript"></script>
    <script src="/js/input-validator.js" type="text/javascript"></script>
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

<!-- Duplicate Error -->
@if(Session::has('duplicate_message'))
    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            <div class="alert alert-danger hide-on-click">
                <div class="container-fluid">
                  <div class="alert-icon">
                    <i class="material-icons">warning</i>
                  </div>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                  </button>
                  {{ Session::get('duplicate_message') }}
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Misc Error -->
@if (count($errors) > 0)
    <div class="row">
            <div class="col-md-5 col-md-offset-7">
                <div class="alert alert-danger hide-on-click">
                    <div class="container-fluid">
                      <div class="alert-icon">
                        <i class="material-icons">warning</i>
                      </div>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                      </button>
                        <ul>
                            Cannot add room because of the following:<br>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
@endif

<h5 id="TitlePage">Contact Information</h5>

<div class="row">
    <div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Search</label>
            <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('tblContact', '1')">
        </div>
    </div>
    <div class="col-md-6">
        <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddContact()"><i class="material-icons">add</i> Add</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="teal">
                <h4 class="title">Contact Information</h4>
                <p class="category"></p>
            </div>
            <div class="card-content table-responsive scrollable-table" id="style-1">
                <table class="table" id="tblContact">
                    <thead class="text-info">
                        <th style="display:none">Contact ID</th>
                        <th onclick="sortTable(1, 'tblContact', 'string')" class="text-center">Contact</th>
                        <th onclick="sortTable(2, 'tblContact', 'string')" class="text-center">Contact Details</th>
                        <th onclick="sortTable(3, 'tblContact', 'string')" class="text-center">Contact Status</th>
                        <th class="text-center">Action</th>
                    </thead>
                    <tbody>
                        @foreach($Contacts as $Contact)
                            <tr class="text-center">
                                <td style="display:none">{{$Contact->strContactID}}</td>
                                <td>{{$Contact->strContactName}}</td>
                                <td>{{$Contact->strContactDetails}}</td>
                                <td>{{$Contact->intContactStatus}}</td>
                                <td>
                                    <button type="button" rel="tooltip" title="Edit" class="btn btn-primary btn-simple btn-xs" onclick="ShowModalEditContact('{{$Contact->strContactID}}','{{$Contact->strContactName}}', '{{$Contact->strContactDetails}}', '{{$Contact->intContactStatus}}')">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs" onclick="ShowModalDeleteContact('{{$Contact->strContactID}}')">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
            </div>
        </div>
    </div>
</div>

@endsection

@section('modals')

<div id="DivModalAddContact" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">add</i>
                            </div>
                            <div class="card-content">
                                <p class="category"></p>
                                <h3 class="title">Add Contact<span class="close" onclick="HideModalAddContact()">X</span></h3>
                                <form onsubmit="return CheckForm()" method="post" action="/Contact/Save">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="ContactID" name="ContactID" value="{{$ContactID}}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating" id="ContactNameError">
                                                <label class="control-label">Contact</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#ContactNameError')" onchange="ValidateInput(this, 'string', '#ContactNameError')" id="ContactName" name="ContactName" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Details</label>
                                                <input type="text" class="form-control" id="ContactDetails" name="ContactDetails" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="ErrorLabel"></p>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success pull-right">Save</button>
                                    <div class="clearfix"></div>


                                </form>
                            </div>

                    </div>
                </div>
        </div>
    </div>
</div>

<div id="DivModalEditContact" class="modal">
    <div class="Modal-content" style="max-width: 500px;">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="blue">
                                <i class="material-icons">create</i>
                            </div>
                            <div class="card-content">
                                <p class="category"></p>
                                <h3 class="title">Edit Contact<span class="close" onclick="HideModalEditContact()">X</span></h3>
                                <form onsubmit="return CheckForm()" method="post" action="/Contact/Edit">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="EditContactID" name="EditContactID">
                                    <input type="hidden" id="OldContactName" name="OldContactName">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="EditContactNameError">
                                                <label class="control-label">Contact</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditContactNameError')" onchange="ValidateInput(this, 'string', '#EditContactNameError')" id="EditContactName" name="EditContactName" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static">
                                                <label class="control-label">Details</label>
                                                <input type="text" class="form-control" id="EditContactDetails" name="EditContactDetails" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class = "row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static">
                                                <label class="control-label">Status</label>
                                                <div class="selectBox">
                                                    <select id="EditContactStatus" name="EditContactStatus">
                                                      <option>Active</option>
                                                      <option>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>        

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="ErrorLabel"></p>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success pull-right">Save</button>
                                    <div class="clearfix"></div>

                                </form>
                            </div>

                    </div>
                </div>
        </div>
    </div>
</div>

<div id="DivModalDeleteContact" class="modal">
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
                            <h3 class="title">Delete Contact?<span class="close" onclick="HideModalDeleteContact()">X</span></h3>
                            <form method="post" action="/Contact/Delete">
                                {{ csrf_field() }}
                                <input type="hidden" name="DeleteContactID" id="DeleteContactID" value="">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteContact()">Cancel</button>
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