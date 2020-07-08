@include('admin.static.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1>Providers By Service</h1>
            <div class="section-header-breadcrumb">

            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header-action">
                            <div class="card-header"><h4>Providers By Service <span>
                                    </span></h4>
                                <div class="card-header-action">
                                    <a class="btn btn-primary" data-toggle="modal"
                                       style="color: #ffffff; background-color: #f5c500;"
                                       data-target="#addProvider">
                                        Add Provider
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <form action="/provider/ShowBYservices" method="get"id="searchForm" >
                                    <div class="form-group">
                                        <label>Service Type</label>
                                        <select class="form-control custom-select js-example-basic"
                                                name="serviceType" required>
                                            @foreach($services as $ser)
                                                <option name="serviceId" id="serviceId"
                                                        value="{{$ser->id}}">{{$ser->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary " id="btnFind">Find</button>
                                </form>

                                <table class="table table-striped table-md data-table" id="tableData">

                                    <thead>
                                    <tr>
                                        <th scope="col" style="display:none;">#</th>
                                        <th scope="col">Provider Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Mobile Num.</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table">
                                    @foreach($data as $single)
                                        <tr>
                                            <td style="display:none;">{{$single->id}}</td>
                                            <td>{{$single->name}}</td>
                                            <td>{{$single->email}}</td>
                                            <td>{{$single->mobileNumber}}</td>
                                            <td>@if(isset($single->companyId))
                                                    {{App\Models\Company::where('id',$single->companyId)->first()->name }}
                                                @endif  </td>
                                            <td>
                                                <a href="{{route('addProvider')}}"
                                                   class="btn btn-outline-success editBtn ">Edit <i
                                                        class="fas fa-edit "></i></a>
                                                <a class="btn btn-outline-danger  deleteBtn ">Delete <i
                                                        class="fas fa-trash-alt"></i> </a>
                                                <a class="btn btn-outline-success addScheduleBtn " data-toggle="modal"
                                                   data-target="#addSchedule">Schedule <i
                                                        class="fas fa-edit "></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0">
                                    {{--                                    {{ $data->links() }}--}}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{--Delete Modal--}}
<div class="modal fade" id="deleteProvider" role="dialog" aria-labelledby="deleteProvider" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form id="deleteForm">
                {{csrf_field()}}
                <div class="modal-body"> Do you want delete this Provider?
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

{{--Add Provider Modal --}}
<div class="modal fade" id="addProvider" role="dialog" aria-labelledby="addProvider"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Provider</h5>

            </div>
            <form action="" id="addForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        {{csrf_field()}}
                        <label>Provider Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Insert Provider name" required/>
                    </div>
                    <div class="form-group">
                        <label>Provider Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Insert Provider email" required/>
                    </div>
                    <div class="form-group">
                        <label>Provider Mobile</label>
                        <input type="text" class="form-control" name="mobileNumber"
                               placeholder="Insert Provider mobile num." required/>
                    </div>

                    <div class="form-group">
                        <label>Company</label>
                        <select class="form-control custom-select js-example-basic"
                                name="companyId" required>
                            @foreach($company as $com)
                                <option name="companyId" value="{{$com->id}}">{{$com->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 ">
                        <label>Services</label>
                        <br>
                        <select class="form-control custom-select js-example-basic-multiple"
                                name="services[]" multiple="multiple" style="  height: 200px; width: 100%;" required>
                            @foreach($services as $ser)
                                <option value="{{$ser->id}}">{{$ser->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" accept="image/*" class="form-control" name="providerImage" required />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary ">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--Add Schdule Modal --}}
<div class="modal fade" id="addSchedule" role="dialog" aria-labelledby="addSchedule"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Schedule</h5>

            </div>
            <form action="" id="addScheduleForm" enctype="multipart/form-data">
                <div class="modal-body">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" class="form-control" name="startDate" placeholder="" required/>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" class="form-control" name="endDate" placeholder="" required/>
                    </div>
                    <div class="form-group">
                        <label>Start time</label>
                        <input type="time" class="form-control" name="startDate" placeholder="" required/>
                    </div>
                    <div class="form-group">
                        <label>End time</label>
                        <input type="time" class="form-control" name="startDate" placeholder="" required/>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary ">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('admin.static.footer')
<script>

    $(document).ready(function () {
        $('#btnFind').click(function () {
            var serviceId = $('#serviceId').val();
            $.ajax({
                type: 'get',
                dataType: 'html',
                url: {{route('providerByService')}},
                data: $('#searchForm').serialize(),
                success: function (response) {
                    $('#tableData').html(response);
                }
            });
        });
    });
</script>

{{--Add Data Script--}}
<script type="text/javascript">
    $(document).ready(function () {
        $('#addForm').on('submit', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "provider/addProvider",
                // data: $('#addForm').serialize(),
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    console.log(response)
                    $('#addProvider').modal('hide')
                    location.reload()
                    // alert("Data Saved");
                },
                error: function (error) {
                    console.log(error)
                    // alert("Data Not Saved");
                }

            });

        });
    });
</script>

{{--Delete Data Script--}}
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.deleteBtn').on('click', function () {
            $('#deleteProvider').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();
            console.log(data);
            $('#delId').val(data[0]);
        });
        $('#deleteForm').on('submit', function (e) {
            e.preventDefault();
            var id = $('#delId').val();
            $.ajax({
                type: 'POST',
                url: "/provider/deleteProvider/" + id,
                data: $('#deleteForm').serialize(),
                success: function (response) {
                    console.log(response);
                    $('#deleteProvider').modal('hide');
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
        $('.js-example-basic-multiple').select2();
    });
</script>
{{--Add Schdule Script--}}
<script type="text/javascript">
    $(document).ready(function () {
        $('#addScheduleForm').on('submit', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "provider/addProvider",
                // data: $('#addForm').serialize(),
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    console.log(response)
                    $('#addSchedule').modal('hide')
                    console.log(this.data);
                    location.reload()
                    // alert("Data Saved");
                },
                error: function (error) {
                    console.log(error)
                    // alert("Data Not Saved");
                }

            });

        });
    });
</script>
