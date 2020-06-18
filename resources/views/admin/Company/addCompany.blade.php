@include('admin.static.header')


<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1><i class="fas fa-building"></i> Company</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Company</h4>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input type="text" class="form-control" name="mobile">
                                </div>
                                <button class="btn btn-primary">Add New</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@extends('admin.static.footer')

@if(session('add'))
    <script>
        Swal.fire('Any fool can use a computer')
    </script>

@endif
