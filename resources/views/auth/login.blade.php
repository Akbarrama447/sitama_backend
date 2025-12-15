<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/images/SITAMA.png') }}" type="image/png" />
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <title>{{ env('APP_NAME', 'SITAMA - Login') }}</title>

    <style>
        body {
            background: linear-gradient(180deg, #ffffffff, #ffffffff, #c3ddffff); /* Gradient biru modern */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            border: none;
            border-radius: 1rem; /* Sudut lebih membulat */
            background-color: rgba(255, 255, 255, 0.95); /* Lebih transparan untuk efek glass */
            backdrop-filter: blur(10px); /* Efek glass */
        }
        .form-control {
            padding: 0.6rem 1rem; /* Input lebih tinggi/modern */
        }
        .btn-primary {
            padding: 0.6rem 1rem;
            font-weight: 500;
            background: #3a7bd5;
            border: none;
            color: #ffffffff;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(58, 123, 213, 0.3);
        }
        .btn-primary:hover {
            background: #f0f0f0 ;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(58, 123, 213, 0.4);
            color: #1e3c72;
        }
        .card-body {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
        }
    </style>
</head>

<body>
    <div class="wrapper w-100">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">

                        <div class="card login-card shadow-lg">
                            <div class="card-body p-4 p-md-5">
                                <div class="text-center mb-4">
                                    {{-- Logo SITAMA --}}
                                    <img src="{{ asset('assets/images/SITAMA.png') }}" width="150" alt="Logo SITAMA" class="mb-3">
                                    <h4 class="font-weight-bold">Selamat Datang</h4>
                                    <p class="text-muted">Silakan masuk ke akun SITAMA Anda</p>
                                </div>

                                <div class="form-body">
                                    <form class="row g-3" action="{{ route('login') }}" method="POST">
                                        @csrf

                                        {{-- Email Input --}}
                                        <div class="col-12">
                                            <label for="inputEmailAddress" class="form-label text-secondary small text-uppercase fw-bold">Email</label>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="inputEmailAddress" placeholder="nama@email.com" value="{{ old('email') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Password Input --}}
                                        <div class="col-12">
                                            <label for="inputChoosePassword" class="form-label text-secondary small text-uppercase fw-bold">Password</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" name="password"
                                                    class="form-control border-end-0 @error('password') is-invalid @enderror"
                                                    id="inputChoosePassword" value=""
                                                    placeholder="Masukkan Password">
                                                <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Remember Me & Forgot Password --}}
                                        <div class="col-md-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="remember">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Ingat Saya</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <a href="{{ route('password.request') }}" class="small text-primary">Lupa Password?</a>
                                        </div>

                                        {{-- Submit Button --}}
                                        <div class="col-12 mt-4">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary rounded-3 shadow-sm">
                                                    <i class="bx bxs-lock-open"></i> Masuk
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Copyright (Optional) --}}
                        <div class="text-center mt-3 text-muted small">
                            <p class="mb-0">Copyright © {{ date('Y') }} SITAMA. All right reserved.</p>
                        </div>

                    </div>
                </div>
                </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>