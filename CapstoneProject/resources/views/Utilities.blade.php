@extends('layout')

@section('WebpageTitle')
    <title>Utilities</title>
@endsection

@section('scripts')
    <script>


    </script>
@endsection

@section('content')
<h5 id="TitlePage">Utilities</h5>

<div class="row">
    
    <a href="/ContactInformation">
        <div class="col-md-4 cursor-pointer">
            <div class="card">
                <div class="card-header card-chart" data-background-color="teal">
                    <div class="ct-chart text-center"><i class="material-icons icon-header" style="font-size: 100px;">ring_volume</i></div>
                </div>
                <div class="card-content">
                    <h4 class="title text-center">Contact Information</h4>
                </div>
            </div>
        </div>
    </a>
    <a href="/ContentManagement">
        <div class="col-md-4 cursor-pointer">
            <div class="card">
                <div class="card-header card-chart" data-background-color="red">
                    <div class="ct-chart text-center"><i class="material-icons icon-header" style="font-size: 100px;">desktop_windows</i></div>
                </div>
                <div class="card-content">
                    <h4 class="title">Website Content Management</h4>
                </div>

            </div>
        </div>
    </a>
    <a href="/SystemUsers">
        <div class="col-md-4 cursor-pointer">
            <div class="card">
                <div class="card-header card-chart" data-background-color="purple">
                    <div class="ct-chart text-center"><i class="material-icons icon-header" style="font-size: 100px;">supervisor_account</i></div>
                </div>
                <div class="card-content">
                    <h4 class="title text-center">Users</h4>
                </div>

            </div>
        </div>
    </a>
    
</div>

@endsection