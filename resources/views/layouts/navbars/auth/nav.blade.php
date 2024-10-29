<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="d-xl-none">
            <h6 class="d-inline">Pages/</h6>
            <h6 class="font-weight-bolder d-inline mb-0 text-capitalize">{{ str_replace('-', ' ', Request::path()) }}</h6>
        </nav>
        <nav aria-label="breadcrumb" ></nav>

        <!-- Navbar Right Section -->
        <div class="d-flex align-items-center">
            <!-- Sign Out Button -->

            <div class="nav-item dropdown">
                <a href="javascript:;" class="nav-link text-body font-weight-bold px-0 me-3" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user me-sm-1"></i>
                    <span class="d-sm-inline d-none">[NAMA]</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end px-2 py-3" aria-labelledby="profileDropdown">
                    <li>
                        <a href="{{ url('/profile') }}" class="dropdown-item">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/static-sign-up') }}" class="dropdown-item">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">Registrasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/logout') }}" class="dropdown-item">
                            <i class="fas fa-sign-out-alt me-sm-1"></i>
                            <span class="d-sm-inline d-none">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>




            <!-- Notification Dropdown -->
            <div class="nav-item dropdown">
                <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell cursor-pointer"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end px-2 py-3" aria-labelledby="dropdownMenuButton">
                    <li class="mb-2">
                        <a class="dropdown-item border-radius-md" href="javascript:;">
                            <div class="d-flex py-1">
                                <div class="my-auto">
                                    <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="text-sm font-weight-normal mb-1">
                                        <span class="font-weight-bold">New message</span> from Laur
                                    </h6>
                                    <p class="text-xs text-secondary mb-0">
                                        <i class="fa fa-clock me-1"></i>
                                        13 minutes ago
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <!-- Additional Notification Items -->
                </ul>
            </div>

            <!-- Sidenav Toggler for Small Screens -->
            <a href="javascript:;" class="nav-link text-body p-0 d-xl-none ms-3" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                </div>
            </a>
        </div>
    </div>
</nav>
<!-- End Navbar -->
