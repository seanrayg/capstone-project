@extends('layout')

@section('WebpageTitle')
    <title>Activities</title>
@endsection

@section('scripts')

@endsection

@section('content')
@foreach($ActivitiesContents as $Content)
<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('{{$Content->strHeaderImage}}');">
    </div>
    <div class="container">
        <div class="content-center brand">
            <h1 class="h1-seo">Il Sogno</h1>
            <h3>Activities</h3>
        </div>
    </div>
</div>

<div class="main">
    
    <div class="section section-tabs">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h2 class="title">Activities</h2>
                    <h5 class="description">{{$Content->strHeaderDescription}}</h5>
                </div>
            </div>
@endforeach
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6 class="title">Activities</h6><br>
                    <p class="text-muted text-center">Lorem ipsum dolor</p>
                    <div class="row table">
                            <table class="stretch-element">
                                <thead class="text-primary">
                                    <th class="text-center">Beach Activity</th>
                                    <th class="text-center">Rate</th>
                                    <th class="text-center">Description</th>
                                </thead>
                                <tbody>
                                    @foreach($Activities as $Activity)
                                    <tr>
                                        <td>{{$Activity->strBeachAName}}</td>
                                        <td>{{$Activity->dblBeachARate}}</td>
                                        <td>{{$Activity->strBeachADescription}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>          
                    </div>
                </div>
            </div>
        </div>
            
    </div>

</div>

@include('layouts.ReservationSection')



@endsection