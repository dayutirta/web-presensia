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

  /* Animasi Slide */
  .slide-out {
    animation: slide-out 0.5s forwards;
  }
  .slide-in {
    animation: slide-in 0.5s forwards;
  }

  @keyframes slide-out {
    from {
      transform: translateX(0);
      opacity: 1;
    }
    to {
      transform: translateX(-100%);
      opacity: 0;
    }
  }

  @keyframes slide-in {
    from {
      transform: translateX(100%);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }


  
  .hidden {
    display: none;
  }
</style>

<main class="main-content mt-0">
  <section>
    <div class="page-header min-vh-100 d-flex align-items-center justify-content-center" id="page-container">
      <div class="container-fluid"> 
        <div class="row justify-content-center align-items-center">      
          <div class="col-xl-4 col-lg-5 col-md-6" id="login-page">
            <div class="card login-card-body">
              <div class="card-header pb-0 text-left bg-transparent">
                <h3 class="font-weight-bolder text-info text-center text-gradient">Selamat Datang</h3>
              </div>
              <div class="card-body">
                <form role="form" method="POST" action="{{ route('login') }}">
                  @csrf
                  <label for="no_pegawai">Nomor Pegawai</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" name="no_pegawai" id="no_pegawai" placeholder="Nomor Pegawai" aria-label="no_pegawai">
                    @error('no_pegawai')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>
                  <label for="password">Password</label>
                  <div class="mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-label="Password">
                    @error('password')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Masuk</button>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center pt-0">
                <small class="text-muted">Lupa Password?  
                  <a href="javascript:void(0)" class="text-info text-gradient font-weight-bold" onclick="showResetPage()">Reset Disini</a>
                </small>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-5 col-md-6 hidden" id="reset-page">
            <div class="card login-card-body">
              <div class="card-header pb-0 text-left bg-transparent">
                <h4 class="font-weight-bolder text-info text-center text-gradient">Reset Password</h4>
              </div>
              <div class="card-body">
                <form role="form" action="/reset-password" method="POST">
                  @csrf
                  <label for="email">Email</label>
                  <div class="mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" aria-label="Email">
                    @error('email')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>
                  <label for="password">New Password</label>
                  <div class="mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="New Password" aria-label="Password">
                    @error('password')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>
                  <label for="password_confirmation">Confirm Password</label>
                  <div class="mb-3">
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" aria-label="Password Confirmation">
                    @error('password_confirmation')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Reset Password</button>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center pt-0">
                <small class="text-muted">Ingat password?  
                  <a href="javascript:void(0)" class="text-info text-gradient font-weight-bold" onclick="showLoginPage()">Login Disini</a>
                </small>
              </div>
            </div>
          </div>
          <div class="col-md-6 d-none d-md-block position-relative">
            <div class="bg-cover top-0 end-0 h-100 w-100" style="background-image:url('../assets/img/curved-images/3915977 2.png');"></div>
          </div>
          
        </div>
      </div>
    </div>
  </section>
</main>

<script>
function showResetPage() {
  const loginPage = document.getElementById('login-page');
  const resetPage = document.getElementById('reset-page');
  loginPage.classList.remove('slide-in'); 
  loginPage.classList.add('slide-out');
  loginPage.addEventListener('animationend', function() {
    loginPage.classList.add('hidden');
    resetPage.classList.remove('hidden');
    resetPage.classList.add('slide-in'); 
  }, { once: true });
}

function showLoginPage() {
  const loginPage = document.getElementById('login-page');
  const resetPage = document.getElementById('reset-page');
  resetPage.classList.remove('slide-in'); 
  resetPage.classList.add('slide-out');
  resetPage.addEventListener('animationend', function() {
    resetPage.classList.add('hidden');
    loginPage.classList.remove('hidden');
    loginPage.classList.add('slide-in'); 
  }, { once: true });
}
</script>

@endsection