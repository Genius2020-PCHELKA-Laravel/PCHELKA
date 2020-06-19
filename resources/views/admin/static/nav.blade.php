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
                    <a href="features-profile.html" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> Profile
                    </a>
                    <a href="features-settings.html" class="dropdown-item has-icon">
                        <i class="fas fa-cog"></i> Settings
                    </a>
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
            <li class="menu-header">Dashboard</li>
            <li><a class="nav-link" href="{{route('viewCompany')}}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a></li>
            <li class="menu-header">Company</li>
            <li><a class="nav-link" href="{{route('viewCompany')}}"><i class="fas fa-building"></i>
                    <span>Companies</span></a></li>
            <li><a class="nav-link" href="{{route('viewProvider')}}"><i class="fas fa-building"></i>
                    <span>Providers</span></a></li>
            <li class="menu-header">Bookings</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i> <span>Booking</span></a>
                <ul class="dropdown-menu" style="display: block;">
                    <li><a class="nav-link" href="#">Confirmed</a></li>
                    <li><a class="nav-link" href="#">Rescheduled</a></li>
                    <li><a class="nav-link" href="#">Completed</a></li>
                    <li><a class="nav-link" href="#">Canceled</a></li>
                </ul>
            </li>

        </ul>

    </aside>
</div>
