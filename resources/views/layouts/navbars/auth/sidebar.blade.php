<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
  <div class="sidenav-header position-sticky top-0 z-index-3 bg-white">
    <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard') }}">
        <img src="{{ asset('assets/img/curved-images/Logo.png') }}" class="navbar-brand-img h-100" alt="Presensia Logo" style="height: 60px;">
        <span class="ms-3 font-weight-bold" style="font-size: 1.25rem;">Presensia</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item pb-2">
        <a class="nav-link {{ (Request::is('dashboard') ? 'active' : '') }}" href="{{ url('dashboard') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md {{ (Request::is('dashboard') ? 'bg-primary' : 'bg-white') }} text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-home" style="font-size: 1rem; color: {{ (Request::is('dashboard') ? '#ffffff' : '#000000') }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link {{ (Request::is('user-management') ? 'active' : '') }}" href="{{ url('user-management') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-users" style="font-size: 1rem; color: {{ (Request::is('user-management') ? '#ffffff' : '#000000') }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">User Management</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link {{ (Request::is('permit-management') ? 'active' : '') }}" href="{{ url('permit-management') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-table" style="font-size: 1rem; color: {{ (Request::is('permit-management') ? '#ffffff' : '#000000') }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Permit Management</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link {{ (Request::is('bills-management') ? 'active' : '') }}" href="{{ url('bills-management') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-file-invoice-dollar" style="font-size: 1rem; color: {{ (Request::is('bills-management') ? '#ffffff' : '#000000') }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Bills Management</span>
        </a>
      </li>
    </ul>
  </div>
</aside>
