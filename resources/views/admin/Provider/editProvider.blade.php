@include('admin.static.header')
<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1>Edit Provider</h1>
        </div>
        @if(isset($data))
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Provider</h4>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" id="editForm" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            {{csrf_field()}}
                                            <label>Provider Name</label>
                                            <input type="text" value="{{$data->name}}" class="form-control" name="name"
                                                   placeholder="Insert Provider name"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Provider Email</label>
                                            <input type="email" value="{{ $data->email }}" class="form-control"
                                                   name="email" placeholder="Insert Provider email"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Provider Mobile</label>
                                            <input type="text" value="{{ $data->mobileNumber }}" class="form-control"
                                                   name="mobileNumber"
                                                   placeholder="Insert Provider mobile num."/>
                                        </div>

                                        <div class="form-group">
                                            <label>Company</label>
                                            <select class="form-control custom-select js-example-basic"
                                                    name="companyId">
                                                @foreach($company as $com)
                                                    <option name="companyId"
                                                            value="{{$com->id}}">{{$com->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Services</label>
                                            <ul class="list-group list-group-flush " style="display: inline-block;">
                                                @foreach($AllServ as $ser)
                                                    <li class="list-group-item col-lg-4 col-md-4" style="width: 23%;
    display: inline-block;">
                                                        <!-- Default checked -->
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="services[]"
                                                                   value="{{$ser->id}}" class="custom-control-input "
                                                                   id="check{{$ser->id}}"
                                                                   @if(in_array($ser->name,$services)) checked @endif>
                                                            <label class="custom-control-label"
                                                                   for="check{{$ser->id}}">{{$ser->name}}</label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="form-group">
                                            <label>Image</label>
                                            @php
                                            $hi = explode('/',$data->imageUrl);
                                            $link=$hi[1].'/app/public/'.$hi[2];
                                            @endphp
                                            <img src="/{{$link}}"  style="width:250px; height:250px" alt="Provider image"
                                                 class="img-thumbnail">
                                        </div>

                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" accept="image/*" class="form-control"
                                                   name="providerImage" >
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary ">Save</button>
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








