@include('admin.static.header')


<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1><i class="fas fa-building"></i> Company</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            </div>
        </div>
@if(isset($data))
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Batata</h4>
                        </div>
                        <div class="card-body">
                            <form action="" id="addForm" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        {{csrf_field()}}
                                        <label>Provider Name</label>
                                        <input type="text" value="{{$data->name}}" class="form-control" name="name" placeholder="Insert Provider name"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Provider Email</label>
                                        <input type="email" value="{{ $data->email }}" class="form-control" name="email" placeholder="Insert Provider email"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Provider Mobile</label>
                                        <input type="text" value="{{ $data->mobileNumber }}" class="form-control" name="mobileNumber"
                                               placeholder="Insert Provider mobile num."/>
                                    </div>

                                    <div class="form-group">
                                        <label>Company</label>
                                        <select class="form-control custom-select js-example-basic"
                                                name="companyId">
                                            @foreach($company as $com)
                                                <option name="companyId" value="{{$com->id}}">{{$com->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 ">
                                        <label>Services</label>
                                        <br>
                                        <select class="form-control custom-select js-example-basic-multiple"
                                                name="services[]" multiple="multiple" required style="  height: 200px; width: 100%;">
                                            @foreach($AllServ as $ser)
                                                @if(in_array($ser->name,$services))
                                                    <option value="{{ $ser->id }}" selected >{{ $ser->name }}</option>
                                                @else
                                                    <option value="{{ $ser->id }}" >{{ $ser->name }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" accept="image/*" class="form-control" name="providerImage">
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
            </div>
        </div>
@endif
    </div>
</section>

@extends('admin.static.footer')

@if(session('add'))
    <script>
        Swal.fire('Any fool can use a computer')
    </script>

@endif
