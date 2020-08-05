@include('admin.static.header')
<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1>Change Provider</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
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
                                    <li class="list-group-item">Location : {{$response["userLocation"]}}</li>
                                    <li class="list-group-item">Provider Name : {{$response["providerName"]}}</li>
                                    <li class="list-group-item">Provider Mobile Number
                                        : {{$response["providerMobileNumber"]}}</li>
                                    <li class="list-group-item">Client Name : {{$response["clientName"]}}</li>
                                    <li class="list-group-item">Client Mobile Number
                                        : {{$response["clientMobileNumber"]}}</li>
                                    <li class="list-group-item">Service Type : {{$response["serviceType"]}}</li>

                                </center>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{$response["serviceType"]}} Providers</h4>
                        </div>
                        <form method="post" id="changeProviderForm" name="changeProviderForm">
                            @csrf
                            <div class="card-body">
                                @if(empty($availableProvider))
                                    We Don't Have Available Provider in <br>
                                    <b> Date</b> :  {{$response["duoDate"]}}<br>
                                    <b> Time </b>: {{$response["duoTime"]}}<br>
                                    <b> For Service</b> : {{$response["serviceType"]}}
                                @else
                                    <div class="form-group">
                                        <label>Select Provider</label>
                                        <select class="form-control form-control-lg" name="providerId">
                                            @foreach ($availableProvider as $provider)
                                                <option data-subtext="{{ $provider->name }}"
                                                        value="{{ $provider->id }}">{{ $provider->name }}</option>
                                            @endforeach
                                        </select>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary ">Save</button>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@extends('admin.static.footer')
