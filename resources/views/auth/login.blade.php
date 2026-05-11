<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; OMDB</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css')}}">

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="{{ asset('assets/img/stisla-fill.svg')}}" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

                        <!-- Language Switcher -->
            <div class="text-center mb-3">
                <div class="dropdown d-inline-block">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fas fa-globe"></i>
                        {{ app()->getLocale() == 'id' ? 'ID' : 'EN' }}
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ url('lang', 'en') }}" class="dropdown-item">
                            English
                        </a>
                        <a href="{{ url('lang', 'id') }}" class="dropdown-item">
                            Bahasa Indonesia
                        </a>
                    </div>
                </div>
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>{{__('messages.login') }}</h4></div>

              <div class="card-body">
                <form method="POST" action="{{ route('signin')}}" class="needs-validation" novalidate="">
                    @csrf
                  <div class="form-group">
                    <label for="email">{{__('messages.email') }}</label>
                    <input type="email" class="form-control" name="email" tabindex="1">
                    @error('email')
                        <span class="text-sm text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">{{__('messages.password') }}</label>
                    </div>
                    @csrf
                    <input type="password" class="form-control" name="password" tabindex="2">
                    @error('password')
                        <span class="text-sm text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      {{__('messages.login') }}
                    </button>
                  </div>
                </form>

              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              {{__('messages.Dont have an account?') }} <a href="{{ url('/register') }}">{{__('messages.create one') }}</a>
            </div>
            <div class="simple-footer">
              Copyright &copy; Stisla <span id="year"></span>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('assets/modules/jquery.min.js')}}"></script>
  <script src="{{ asset('assets/modules/popper.js')}}"></script>
  <script src="{{ asset('assets/modules/tooltip.js')}}"></script>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{ asset('assets/modules/moment.min.js')}}"></script>
  <script src="{{ asset('assets/js/stisla.js')}}"></script>

  <!-- JS Libraies -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js')}}"></script>
  <script src="{{ asset('assets/js/custom.js')}}"></script>

  @if(session()->has('success'))
  <script>
    Swal.fire({
        text: "{{ session()->get('success') }}",
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })
  </script>
  @endif

  @if(session()->has('error'))
  <script>
    Swal.fire({
        text: "{{ session()->get('error') }}",
        icon: 'error',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })
  </script>
  @endif

  <script>
    const year = document.getElementById('year');
    year.innerHTML = new Date().getFullYear();
  </script>
</body>
</html>