@extends('layout')

@section('WebpageTitle')
    <title>Contact Us</title>
@endsection

@section('scripts')

@endsection

@section('content')
@foreach($ContactsContents as $Content)
<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('{{$Content->strHeaderImage}}');">
    </div>
    <div class="container">
        <div class="content-center brand">
            <h1 class="h1-seo">Il Sogno</h1>
            <h3>Contact Us</h3>
        </div>
    </div>
</div>

<div class="main">
    
    <div class="section section-tabs">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h2 class="title">Contact Us</h2>
                    <h5 class="description">{{$Content->strHeaderDescription}}</h5>
                </div>
            </div>
@endforeach
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center modal-title">Contact Information</p>
                    <div class="table">
                        <table class="text-center stretch-element">
                            <thead class="text-primary">
                                <th class="text-center">Contact</th>
                                <th class="text-center">Info</th>
                            </thead>
                            <tbody>
                                @foreach($Contacts as $Contact)
                                    <tr>
                                        <td>{{$Contact->strContactName}}</td>
                                        <td>{{$Contact->strContactDetails}}</td>
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

@include('layouts.ReservationSection')



@endsection