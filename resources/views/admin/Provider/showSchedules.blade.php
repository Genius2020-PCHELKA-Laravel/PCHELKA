@include('admin.static.header')
<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1>Show "{{$providerName}}" Provider Schedules</h1>
            <div class="section-header-breadcrumb">

            </div>
        </div>
        <div class="section-body">
            <div class="row">

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Available Schedules</h4>
                        </div>
                        <div class="card-body">
                            <div id="accordion1">
                                @foreach(array_keys($response) as $availableDate)
                                    @php $delete = 1; @endphp
                                    <div class="accordion">
                                        <div class="accordion-header collapsed" role="button" data-toggle="collapse"
                                             data-target="#panel-body{{$availableDate}}" aria-expanded="false">
                                            <h4>{{$availableDate}}</h4>

                                        </div>
                                        <div class="accordion-body collapse" id="panel-body{{$availableDate}}"
                                             data-parent="#accordion1"
                                             style="">

                                            <ul class=" "
                                                style="display: inline-block;">

                                                @foreach($response[$availableDate] as $time)

                                                    @if($time->isActive)
                                                        <li class="list-group-item col-lg-4 col-md-4"
                                                            style="width: 80px; display: inline-block; text-align: center">
                                                            <label>{{date("h:i a", strtotime($time->timeStart))  }}</label>
                                                        </li>
                                                    @else
                                                        @php $delete = 0; @endphp
                                                    @endif

                                                @endforeach
                                            </ul>
                                            <br/>
                                            <center>
                                                @if($delete == 1)
                                                    <form onsubmit="if(!confirm('Are you sure ? ')){return false}"
                                                          method="post" action="{{ route('deleteSche',$id) }}">
                                                        {{csrf_field()}}
                                                        <button type="submit" id="btnDelete" class="btn btn-danger">
                                                            Delete Schedules
                                                        </button>
                                                        <input type="hidden" value="{{$availableDate}}"
                                                               name="availableDate"/>
                                                        <input type="hidden" value="{{$id}}" name="id"/>
                                                    </form>
                                                @else
                                                    <div class="badge badge-info"> You cannot delete this date because
                                                        there is a Booked time
                                                    </div>
                                                @endif
                                            </center>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Booked Schedules</h4>
                        </div>
                        <div class="card-body">
                            <div id="accordion">
                                @foreach(array_keys($response) as $availableDate)
                                    <div class="accordion">
                                        <div class="accordion-header collapsed" role="button" data-toggle="collapse"
                                             data-target="#panel-body-{{$availableDate}}" aria-expanded="false">
                                            <h4>{{$availableDate}}</h4>
                                        </div>
                                        <div class="accordion-body collapse" id="panel-body-{{$availableDate}}"
                                             data-parent="#accordion"
                                             style="">

                                            <ul class=" "
                                                style="display: inline-block;">
                                                @foreach($response[$availableDate] as $time)

                                                    @if(!$time->isActive)
                                                        @if($time->isGap)
                                                            <li class="list-group-item col-lg-4 col-md-4"
                                                                style="width: 80px; display: inline-block; text-align: center">
                                                                <label
                                                                    style="color: red;">{{date("h:i a", strtotime($time->timeStart))  }}   </label>
                                                            </li>
                                                        @else
                                                            <li class="list-group-item col-lg-4 col-md-4"
                                                                style="width: 80px; display: inline-block; text-align: center">
                                                                <label>{{date("h:i a", strtotime($time->timeStart))  }}</label>
                                                            </li>
                                                        @endif
                                                    @endif

                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@include('admin.static.footer')
<script></script>
