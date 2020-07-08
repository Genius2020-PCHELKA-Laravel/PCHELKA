@include('admin.static.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1> View All Booking</h1>
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
                                <table class="table table-striped table-md">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="display:none;">#</th>
                                            <th scope="col">Duo Date </th>
                                            <th scope="col">Duo Time </th>
                                            <th scope="col">Provider Name </th>
                                            <th scope="col">Provider Mobile  </th>
                                            <th scope="col">Client Name </th>
                                            <th scope="col">REFCODE </th>
                                            <th scope="col">status </th>
                                            <th scope="col">Action </th>
                                        </tr>
                                        </thead>
                                        <tbody id="table">
                                        @foreach($bookings as $single)
                                            <tr>
                                                <td style="display:none;">{{$single->id}}</td>
                                                <td>{{$single->duoDate}}</td>
                                                <td>{{$single->duoTime}}</td>
                                                <td>{{$single->name}}</td>
                                                <td>{{$single->mobileNumber}}</td>
                                                <td>{{$single->fullName}}</td>
                                                <td>{{$single->refCode}}</td>
                                                @if($single->status ==1)
                                                <td><div class="badge badge-primary">{{\App\Enums\BookingStatusEnum::getKey( $single->status)}}</div></td>
                                                    <td>
                                                        <a  class="btn btn-outline-success editBtn">Complete</a>
                                                        <a class="btn btn-outline-danger  edit1Btn ">Cancel</a>
                                                    </td>
                                                @endif

                                                @if($single->status ==2)
                                                    <td><div class="badge badge-success" >{{\App\Enums\BookingStatusEnum::getKey( $single->status)}}</div></td>
                                                    <td><div class="badge badge-light" > The booking has been completed</div></td>
                                                @endif

                                                @if($single->status ==3)
                                                    <td ><div class="badge badge-warning">{{\App\Enums\BookingStatusEnum::getKey( $single->status)}}</div></td>
                                                    <td>
                                                        <a  class="btn btn-outline-success editBtn">Complete</a>
                                                        <a class="btn btn-outline-danger  edit1Btn ">Cancel</a>
                                                    </td>
                                                @endif

                                                @if($single->status ==4)
                                                    <td ><div  class="badge badge-danger">{{\App\Enums\BookingStatusEnum::getKey( $single->status)}}</div></td>
                                                    <td><div class="badge badge-light" > The booking has been Canceled</div></td>
                                                @endif

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
<div class="modal fade" id="editcompleted" role="dialog" aria-labelledby="editcompleted" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form id="editForm">
                {{csrf_field()}}
                <div class="modal-body"> Do you want change this status?
                    <input type="hidden" name="id" id="delId">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-shadow" id="">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="editcanceled" role="dialog" aria-labelledby="editcanceled" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form id="edit1Form">
                {{csrf_field()}}
                <div class="modal-body"> Do you want change this status?
                    <input type="hidden" name="id" id="delId">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-shadow" id="">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>



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

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.editBtn').on('click', function () {
            $('#editcompleted').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();
            console.log(data);
            $('#delId').val(data[0]);
        });
        $('#editForm').on('submit', function (e) {
            e.preventDefault();
            var id = $('#delId').val();
            $.ajax({
                type: 'POST',
                url: "/Booking/editcompleted/" + id,
                data: $('#editForm').serialize(),
                success: function (response) {
                    console.log(response);
                    $('#editcompleted').modal('hide');
                    location.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.edit1Btn').on('click', function () {
            $('#editcanceled').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();
            console.log(data);
            $('#delId').val(data[0]);
        });
        $('#edit1Form').on('submit', function (e) {
            e.preventDefault();
            var id = $('#delId').val();
            $.ajax({
                type: 'POST',
                url: "/Booking/editcanceled/" + id,
                data: $('#edit1Form').serialize(),
                success: function (response) {
                    console.log(response);
                    $('#editcanceled').modal('hide');
                    location.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>
