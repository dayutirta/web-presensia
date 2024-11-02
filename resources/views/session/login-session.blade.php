@extends('layouts.user_type.guest')
@section('content')

<style>
  .bg-cover {
    background-size: cover;
    background-position: center;
  }
  
  @media (min-width: 768px) {
    .bg-cover {
      min-height: 100vh; 
    }
  }
</style>

<main class="main-content mt-0">
  <section>
    <div class="page-header min-vh-100 d-flex align-items-center justify-content-center"> 
      <div class="container-fluid"> 
        <div class="row justify-content-center align-items-center"> 
          <div class="col-xl-4 col-lg-5 col-md-6">
            <div class="card login-card-body">
              <div class="card-header pb-0 text-left bg-transparent">
                <h3 class="font-weight-bolder text-info text-center text-gradient">Selamat Datang</h3>
              </div>
              <div class="card-body">
                <form role="form" method="POST" action="/session">
                  @csrf
                  <label for="no_pegawai">Nomor Pegawai</label>
                  <div class="mb-3">
                    <input type="" class="form-control" name="no_pegawai" id="no_pegawai" placeholder="Nomor Pegawai" value="" aria-label="no_pegawai" aria-describedby="no_pegawai-addon">
                    @error('no_pegawai')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>
                  <label for="password">Password</label>
                  <div class="mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" aria-label="Password" aria-describedby="password-addon">
                    @error('password')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>
                  {{-- <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                  </div> --}}
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Masuk</button>
                  </div>
                </form>
              </div>
              {{-- <div class="card-footer text-center pt-0">
                <small class="text-muted">Forgot your password? Reset your password 
                  <a href="/login/forgot-password" class="text-info text-gradient font-weight-bold">here</a>
                </small>
                <p class="mb-4 text-sm mx-auto">
                  Don't have an account?
                  <a href="register" class="text-info text-gradient font-weight-bold">Sign up</a>
                </p>
              </div> --}}
            </div>
          </div>

          <!-- Image Section -->
          <div class="col-md-6 d-none d-md-block position-relative">
            <div class="bg-cover top-0 end-0 h-100 w-100" style="background-image:url('../assets/img/curved-images/3915977 2.png');"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

@endsection
