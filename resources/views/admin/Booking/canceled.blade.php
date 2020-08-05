@include('admin.static.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1> View Booking canceled</h1>
        </div>


        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">

                            <div class="table-responsive">
                                <div class="form-group">
                                    <input type="text" name="search" id="search" class="form-control col-3"
                                           placeholder="Input Key Word To Search">
                                </div>
                                <table style="text-align:center;" id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th scope="col" style="display:none;">#</th>
                                        <th scope="col">Duo Date</th>
                                        <th scope="col">Duo Time</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Service</th>
                                        <th scope="col">Provider Name</th>
                                        <th scope="col">Provider Mobile</th>
                                        <th scope="col">Client Name</th>
                                        <th scope="col">REFCODE</th>
                                        <th scope="col">Booking Date</th>
                                        <th scope="col"> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table">
                                    @foreach($bookings as $single)


                                        <tr>
                                            <td style="display:none;">{{$single->id}}</td>
                                            <td>{{$single->duoDate}}</td>
                                            <td>{{$single->duoTime}}</td>
                                            <td>{{$single->location}}</td>
                                            <td>{{$single->serviceType}}</td>
                                            <td>{{$single->name}}</td>
                                            <td>{{$single->mobileNumber}}</td>
                                            <td>{{$single->fullName}}</td>
                                            <td>{{$single->refCode}}</td>
                                            <td>{{$single->BookedDate}}</td>
                                            <td>
                                                <div class="btn-group mb-2">
                                                    <button class="btn btn-sm btn-warning dropdown-toggle"
                                                            type="button"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        Select Action
                                                    </button>
                                                    <div class="dropdown-menu" x-placement="bottom-start"
                                                         style="position: absolute; transform: translate3d(0px, 43px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a class="dropdown-item"
                                                           href="{{url('Booking/getBooking',$single->id)}}">View
                                                            More</a></div>
                                            </td>

                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <nav class="d-inline-block">


                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@include('admin.static.footer')

<script>
    $(document).ready(function () {
        $("#search").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#table tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
