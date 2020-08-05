@include('admin.static.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1> View Services</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header-action">
                            <div class="card-header">

                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table style="text-align:center;" id="dtBasicExample"
                                       class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th scope="col" style="display:none;">#</th>
                                        <th scope="col">Service Name</th>
                                        <th scope="col">Service Price</th>
                                        <th scope="col">Material Price</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    @foreach($data as $single)
                                        <tr >
                                            <td style="display:none;">{{$single->id}}</td>
                                            <td>{{$single->name}}</td>
                                            <td>{{$single->hourPrice}}</td>
                                            <td>{{$single->materialPrice}}</td>
                                            <td>{{$single->unit}}</td>
                                            <td>
                                                <a href="#" class="btn btn-outline-success editBtn">Edit <i
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


{{--Update Service Modal--}}
<div class="modal fade" id="editService" role="dialog" aria-labelledby="editService"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Service</h5>

            </div>
            <form action="" id="editForm">
                <div class="modal-body">
                    <div class="form-group">
                        {{csrf_field()}}
                        <input type="hidden" id="id"/>
                        <label>Service Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                               placeholder="" disabled/>
                    </div>
                    <div class="form-group">
                        <label>Service Price</label>
                        <input type="number" min="0" class="form-control" name="hourPrice" id="hourPrice"
                               placeholder="" required/>
                    </div>
                    <div class="form-group">
                        <label>Material Price</label>
                        <input type="number" min="0" class="form-control" name="materialPrice" id="materialPrice"
                               placeholder="" required/>
                    </div>
                    <div class="form-group">
                        <label>Unit</label>
                        <input type="text" class="form-control" name="unit" id="unit"
                               placeholder="" required/>
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
            $('#editService').modal('show');

            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();
            console.log(data);
            $('#id').val(data[0]);
            $('#name').val(data[1]);
            $('#hourPrice').val(data[2]);
            $('#materialPrice').val(data[3]);
            $('#unit').val(data[4]);
        });

        $('#editForm').on('submit', function (e) {
            e.preventDefault();
            var id = $('#id').val();

            $.ajax({
                type: "POST",
                url: "service/editService/" + id,
                data: $('#editForm').serialize(),
                success: function (response) {
                    console.log(response);
                    $('#editService').modal('hide');
                    location.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>
