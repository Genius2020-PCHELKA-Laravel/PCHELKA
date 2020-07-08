@include('admin.static.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1> View Companies</h1>
        </div>
        <div class="section-body">


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header-action">
                            <div class="card-header"><h4>Companies Count<span>({{$data->count}})</span></h4>

                                <div class="card-header-action">
                                    <a class="btn btn-primary" data-toggle="modal"
                                       style="color: #ffffff; background-color: #f5c500;"
                                       data-target="#addCompany">
                                        Add Company
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
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
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Mobile Num.</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    @foreach($data as $single)
                                        <tbody id="table">
                                        <tr>
                                            <td style="display:none;">{{$single->id}}</td>
                                            <td>{{$single->name}}</td>
                                            <td>{{$single->email}}</td>
                                            <td>{{$single->mobile}}</td>
                                            <td>
                                                <a href="#" class="btn btn-outline-success editBtn">Edit <i
                                                        class="fas fa-edit "></i></a>
                                                <a class="btn btn-outline-danger  deleteBtn ">Delete <i
                                                        class="fas fa-trash-alt"></i> </a>
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

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{--Add Company Modal --}}
<div class="modal fade" id="addCompany" role="dialog" aria-labelledby="addCompany"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Company</h5>

            </div>
            <form action="" id="addForm">
                <div class="modal-body">
                    <div class="form-group">
                        {{csrf_field()}}
                        <label>Company Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Insert company name" required/>
                    </div>
                    <div class="form-group">
                        <label>Company Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Insert company email" required/>
                    </div>
                    <div class="form-group">
                        <label>Company Mobile</label>
                        <input type="text" class="form-control" name="mobile" required placeholder="Insert company mobile num." data-inputmask='"mask": "999999999"' data-mask/>
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
                        <label>Company Name</label>
                        <input type="text" class="form-control" name="name"  required id="name"
                               placeholder=""/>
                    </div>
                    <div class="form-group">
                        <label>Company Email</label>
                        <input type="email" class="form-control" name="email" required id="email"
                               placeholder=""/>
                    </div>
                    <div class="form-group">
                        <label>Company Mobile</label>
                        <input type="text" class="form-control" name="mobile" id="mobile"
                               placeholder="" data-inputmask='"mask": "999999999"' data-mask required/>

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

{{--Update Data Script--}}
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.editBtn').on('click', function () {
            $('#editCompany').modal('show');

            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();
            console.log(data);
            $('#id').val(data[0]);
            $('#name').val(data[1]);
            $('#email').val(data[2]);
            $('#mobile').val(data[3]);
        });

        $('#editForm').on('submit', function (e) {
            e.preventDefault();
            var id = $('#id').val();

            $.ajax({
                type: "POST",
                url: "company/editCompany/" + id,
                data: $('#editForm').serialize(),
                success: function (response) {
                    console.log(response);
                    $('#editCompany').modal('hide');
                    location.reload();
                },
                error: function (error) {
                    console.log(error);
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
                url: "company/addCompany",
                data: $('#addForm').serialize(),
                success: function (response) {
                    console.log(response)
                    $('#addCompany').modal('hide')
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
            $('#deleteCompany').modal('show');
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
                url: "/company/deleteCompany/" + id,
                data: $('#deleteForm').serialize(),
                success: function (response) {
                    console.log(response);
                    $('#deleteCompany').modal('hide');
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
        $("#search").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#table tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

