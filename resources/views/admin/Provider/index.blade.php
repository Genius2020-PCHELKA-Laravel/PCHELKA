@include('admin.static.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="main-content" style="min-height: 562px;">
        <div class="section-header">
            <h1>Dropdown</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>
                <div class="breadcrumb-item">Dropdown</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Dropdown</h2>
            <p class="section-lead">
                Toggle contextual overlays for displaying lists of links and more with the Bootstrap dropdown plugin.
            </p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Simple</h4>
                        </div>
                        <div class="card-body">
                            <div class="dropdown d-inline mr-2">
                                <div class="form-group">
                                    <label for="company"> Select Company</label>
                                    <select name="companyId" id="companies" class="form-control js-example-basic-multiple js-states form-control"">
                                        @foreach($companies as $key => $company)
                                            <option value="{{$key}}">{{$company}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
        $('#companies').select2({

        });
    });
</script>
