@extends('layout')

@section('WebpageTitle')
    <title>Reports</title>
@endsection

@section('scripts')
    <script>


    </script>
@endsection

@section('content')
<h5 id="TitlePage">Reports</h5>

<div class="row">
    
    <a href="/QueryReports">
        <div class="col-md-6 cursor-pointer">
            <div class="card">
                <div class="card-header card-chart" data-background-color="orange">
                    <div class="ct-chart text-center"><i class="material-icons icon-header" style="font-size: 100px;">assignment</i></div>
                </div>
                <div class="card-content">
                    <h4 class="title">Queries Report</h4>
                    <p class="category">Generate a list of accomodations, items, activities etc. in the resort</p>
                </div>
            </div>
        </div>
    </a>
    
    <a href="/SalesReport">
        <div class="col-md-6 cursor-pointer">
            <div class="card">
                <div class="card-header card-chart" data-background-color="blue">
                    <div class="ct-chart text-center"><i class="material-icons icon-header" style="font-size: 100px;">assessment</i></div>
                </div>
                <div class="card-content">
                    <h4 class="title">Sales Report</h4>
                    <p class="category">Generate a report of sales of the resort</p>
                </div>

            </div>
        </div>
    </a>
    
</div>

@endsection