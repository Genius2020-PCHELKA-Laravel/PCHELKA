@include('admin.static.header')
<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1>Booking Details</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-1 col-lg-1"></div>
                <div class="col-12 col-md-5 col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>Booking Details</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <center>
                                    <li class="list-group-item">RefCode : {{$response["refCode"]}} </li>
                                    <li class="list-group-item">Duo Date : {{$response["duoDate"]}}</li>
                                    <li class="list-group-item">Duo Time : {{$response["duoTime"]}}</li>
                                    <li class="list-group-item">Provider Name : {{$response["providerName"]}}</li>
                                    <li class="list-group-item">Provider Mobile Number
                                        : {{$response["providerMobileNumber"]}}</li>
                                    <li class="list-group-item">Client Name : {{$response["clientName"]}}</li>
                                    <li class="list-group-item">Client Mobile Number
                                        : {{$response["clientMobileNumber"]}}</li>
                                    <li class="list-group-item">Service Type : {{$response["serviceType"]}}</li>
                                    <li class="list-group-item">Status : {{$response["status"]}}</li>
                                    <li class="list-group-item">Total Amount : {{$response["totalAmount"]}}</li>

                                </center>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Provider Evaluation</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <center>
                                    <li class="list-group-item">Average Provider Evaluation
                                        : {{$response["avgEvaluation"]}} </li>
                                    @if($response["bookingEvaluation"]>0)
                                        <li class="list-group-item">booking "{{$response["refCode"]}}" Evaluation  : {{$response["bookingEvaluation"]}}</li>
                                    @else
                                        <li class="list-group-item">booking "{{$response["refCode"]}}" Evaluation  : <b>Not Evaluated Yet </b> </li>
                                    @endif
                                </center>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-5 col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>Booking Location</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <center>
                                    <li class="list-group-item">Address
                                        : {{$response['addressDetails']['address']}}</li>
                                    <li class="list-group-item">Details
                                        : {{$response['addressDetails']['details']}}</li>
                                    <li class="list-group-item">Area : {{$response['addressDetails']['area']}}</li>
                                    <li class="list-group-item">Street : {{$response['addressDetails']['street']}}</li>
                                    <li class="list-group-item">Building Number
                                        : {{$response['addressDetails']['buildingNumber']}}</li>
                                    <li class="list-group-item">Apartment
                                        : {{$response['addressDetails']['apartment']}}</li>

                                </center>
                            </ul>
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Booking Answers</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <center>
                                    @foreach($response['answer'] as $ans)
                                        <li class="list-group-item">{{$ans['question'] }} : {{ $ans['answer']}}</li>
                                    @endforeach
                                </center>
                            </ul>
                        </div>

                    </div>

                </div>
                <div class="col-md-1 col-lg-1"></div>
            </div>
        </div>
    </div>

@extends('admin.static.footer')
