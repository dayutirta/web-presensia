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
        <a class="nav-link {{ (Request::is('user-profile') ? 'active' : '') }}" href="{{ url('user-profile') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user" style="font-size: 1rem; color: {{ (Request::is('user-profile') ? '#ffffff' : '#000000') }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">User Profile</span>
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
        <a class="nav-link {{ (Request::is('tables') ? 'active' : '') }}" href="{{ url('tables') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-table" style="font-size: 1rem; color: {{ (Request::is('tables') ? '#ffffff' : '#000000') }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Tables</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link {{ (Request::is('billing') ? 'active' : '') }}" href="{{ url('billing') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-file-invoice-dollar" style="font-size: 1rem; color: {{ (Request::is('billing') ? '#ffffff' : '#000000') }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Billing</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link {{ (Request::is('profile') ? 'active' : '') }}" href="{{ url('profile') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-id-card" style="font-size: 1rem; color: {{ (Request::is('profile') ? '#ffffff' : '#000000') }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link" href="{{ url('static-sign-in') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-sign-out-alt" style="font-size: 1rem; color: {{ (Request::is('static-sign-in') ? '#ffffff' : '#000000') }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Log out</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link" href="{{ url('static-sign-up') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user-plus" style="font-size: 1rem; color: {{ (Request::is('static-sign-up') ? '#ffffff' : '#000000') }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Register</span>
        </a>
      </li>
    </ul>
  </div>
</aside>
