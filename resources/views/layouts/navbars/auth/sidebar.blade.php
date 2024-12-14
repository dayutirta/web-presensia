<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
  @php
    $dashboardUrl = '#';
    if (Auth::user()->id_level == 1) {
        $dashboardUrl = url('/hrd/dashboard');
    } elseif (Auth::user()->id_level == 2) {
        $dashboardUrl = url('/spv/dashboard');
    }
  @endphp
  <div class="sidenav-header position-sticky top-0 z-index-3 bg-white">
    <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ $dashboardUrl }}">
      <img src="{{ asset('assets/img/curved-images/Logo.png') }}" class="navbar-brand-img h-100" alt="Presensia Logo" style="height: 60px;">
      <span class="ms-3 font-weight-bold" style="font-size: 1.25rem;">Presensia</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item pb-2">
        <a class="nav-link {{ Request::is('*dashboard') ? 'active' : '' }}" href="{{ $dashboardUrl }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md {{ Request::is('*dashboard') ? 'bg-primary' : 'bg-white' }} text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-home" style="font-size: 1rem; color: {{ Request::is('*dashboard') ? '#ffffff' : '#000000' }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link {{ Request::is('pegawai') ? 'active' : '' }}" href="{{ url('/pegawai') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md {{ Request::is('pegawai') ? 'bg-primary' : 'bg-white' }} text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-users" style="font-size: 1rem; color: {{ Request::is('pegawai') ? '#ffffff' : '#000000' }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Manajemen Pegawai</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link {{ Request::is('perizinan') ? 'active' : '' }}" href="{{ url('perizinan') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md {{ Request::is('perizinan') ? 'bg-primary' : 'bg-white' }} text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-table" style="font-size: 1rem; color: {{ Request::is('perizinan') ? '#ffffff' : '#000000' }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Manajemen Izin</span>
        </a>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link {{ Request::is('absensi') ? 'active' : '' }}" href="{{ url('absensi') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md {{ Request::is('absensi') ? 'bg-primary' : 'bg-white' }} text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-table" style="font-size: 1rem; color: {{ Request::is('absensi') ? '#ffffff' : '#000000' }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Manajemen Absensi</span>
        </a>
      </li>
      {{-- @if (Auth::user()->id_level == 1)
      <li class="nav-item pb-2">
        <a class="nav-link {{ Request::is('gaji') ? 'active' : '' }}" href="{{ url('gaji') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md {{ Request::is('gaji') ? 'bg-primary' : 'bg-white' }} text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-file-invoice-dollar" style="font-size: 1rem; color: {{ Request::is('gaji') ? '#ffffff' : '#000000' }};" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Management Gaji</span>
        </a>
      </li>
      @endif --}}
    </ul>
  </div>
</aside>