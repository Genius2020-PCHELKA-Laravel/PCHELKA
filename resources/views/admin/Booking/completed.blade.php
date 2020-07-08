@include('admin.static.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1> View Completed Booking </h1>
        </div>


        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header-action">

                        </div>
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



{{--Update Company Modal--}}
<div class="modal fade" id="editCompany" role="dialog" aria-labelledby="editCompany"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Company</h5>

            </div>
            <form action="" id="editForm">
                <div class="modal-body">
                    <div class="form-group">
                        {{csrf_field()}}
                        <input type="hidden" id="id"/>
                        <label>Change Status</label>
                        <input type="text" class="form-control" name="status" id="status"
                               placeholder=""/>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--Delete Modal--}}
<div class="modal fade" id="deleteCompany" role="dialog" aria-labelledby="deleteCompany" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form id="deleteForm">
                {{csrf_field()}}
                <div class="modal-body"> Do you want delete this company?
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
