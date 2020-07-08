<div class="navbar-bg "></div>
<div>
    <nav class="navbar navbar-expand-lg main-navbar  ">
        <div class="form-inline mr-auto ">
            <ul class="navbar-nav mr-3">
                <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                            class="fas fa-search"></i></a></li>
            </ul>
        </div>
        <ul class="navbar-nav navbar-right ">
            <li class="dropdown"><a href="#" data-toggle="dropdown"
                                    class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <div class="d-sm-none d-lg-inline-block">Hi, Admin</div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">

                    <div class="dropdown-divider"></div>
                    <a href="{{route('logout')}}" class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
</div>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">Pchelka</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Pc</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Bookings</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-bookmark"></i> <span>Booking</span></a>
                <ul class="dropdown-menu" >
                    <li><a class="nav-link" href="{{route('viewAll')}}">All</a></li>
                    <li><a class="nav-link" href="{{route('viewconfirm')}}">Confirmed</a></li>
                    <li><a class="nav-link" href="{{route('viewRescheduled')}}">Rescheduled</a></li>
                    <li><a class="nav-link" href="{{route('viewCompleted')}}">Completed</a></li>
                    <li><a class="nav-link" href="{{route('viewcanceled')}}">Canceled</a></li>
                </ul>
            </li>
            <li class="menu-header">Companies</li>
            <li><a class="nav-link" href="{{route('viewCompany')}}"><i class="fas fa-building"></i>
                    <span>Companies</span></a></li>


            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-people-carry"></i> <span>Providers</span></a>
                <ul class="dropdown-menu" >
                    <li><a class="nav-link" href="{{route('viewProvider')}}">Show All Provider</a></li>
                    <li><a class="nav-link" href="{{route('providerByService')}}">Show By Service</a></li>
                    <li><a class="nav-link" href="{{route('providerByCompany')}}">Show By Company</a></li>
                    <li><a class="nav-link edit1Btn">Delete Past Schedule</a></li>
                </ul>
            </li>



            <li class="menu-header">Users</li>
            <li><a class="nav-link" href="{{route('viewUser')}}"><i class="fas fa-user"></i>
                    <span>Users</span></a></li>
            <li class="menu-header">Services</li>
            <li><a class="nav-link " href="{{route('viewService')}}" ><i class="fas fa-clipboard"></i>
                    <span>Services</span></a></li>
        </ul>

    </aside>
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


