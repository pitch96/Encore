<!DOCTYPE html>
<html lang="en">

<head>
    <title>Encore Events | Log in</title>
    <!-----basic page needs --->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}" type="text/css">
    {{-- toastr --}}
    <link rel="stylesheet" href="{{ asset('assets/dist/css/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.com/libraries/jquery.mask">

    <style>
        #toast-container.nopacity>div {
            opacity: 1;
        }
    </style>
</head>

<body>
    <section class="login_screen">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 login_background">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12 px-0">
                            <div class="login-main-banner"
                                style="background-image: url('{{ asset('frontend/images/log.png') }}')">
                            </div>
                        </div>
                        @php
                        if (isset($_COOKIE['login_email']) && isset($_COOKIE['login_pass'])) {
                                $login_email = $_COOKIE['login_email'];
                                $login_pass = $_COOKIE['login_pass'];
                                $is_remember = "checked='checked'";
                            } else {
                                $login_email = '';
                                $login_pass = '';
                                $is_remember = '';
                            }
                        @endphp
                        <div class="col-xl-6 col-lg-6 col-md-12 col-12 px-md-5">
                            <div class="main_box_login">
                                <div class="formflow_login my-4 text-center">
                                    <a class="brand" href="{{ url('/') }}">
                                        <img src="{{ asset('frontend/images/logo.png') }}" alt="logo"
                                            class="brading img-fluid">
                                    </a>
                                    <h4 class="login_welcome mt-3">Welcome!</h4>
                                    <p class="login_para">Hello there Login to continue</p>
                                    <form method="POST" action="{{ route('login') }}"
                                        class="needs-validation validation_form position-relative mt-4 pt-4" novalidate>
                                        @csrf
                                        <div class="form-group">
                                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                            <input type="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ $login_email }}" required autocomplete="email"
                                                placeholder="Email">
                                            @error('email')
                                                <span class="invalid-feedback text-left" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @else
                                                <span class="invalid-feedback text-left email-validation" role="alert">
                                                    <strong>The email field is required.</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" id="password" value="{{ $login_pass }}" required
                                                autocomplete="password" placeholder="Password">
                                            <a href="javascript:void(0)" class="show_password " data-value="0"><i
                                                    class="fa fa-eye" style="left: 90% !important;"
                                                    aria-hidden="true"></i></a>
                                            @error('password')
                                                <span class="invalid-feedback text-left" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @else
                                                <span class="invalid-feedback text-left" role="alert">
                                                    <strong>The password field is required.</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group form-check">
                                            <div class="row d-flex justify-content-between pb-3">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-left">
                                                    <input type="checkbox" class="form-check-input" name="rememberme"
                                                        id="invalidCheck3" {{ $is_remember }}>
                                                    <label class="remember" for="invalidCheck3">
                                                        Remember me
                                                    </label>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <p class="forget text-right mb-0"> <a
                                                            href="{{ route('forget.password.get') }}"
                                                            class="f_psw hover-color">Forgot Password ?</a> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-block login-btn">Login</button>
                                    </form>
                                    <div class="create_acc mt-4 ">
                                        <p class="Reg_login ">Not register yet? <a href="{{ url('register') }}"
                                                class="reg hover-color">
                                                Create an Account </a> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--col-12 -->
                </div>
                <!--main row -->
            </div>
        </div>
    </section>


    <!-- plugins -->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.mask.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/8a15c38d9e.js " crossorigin="anonymous "></script>
    {{-- toastr js --}}
    <script src="{{ asset('assets/dist/js/toastr.min.js') }}"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        $(document).ready(function() {
            $('.show_password').on('click', function() {
                var show = $(this).data('value');
                if (show === 1) {
                    $(this).data('value', 0);
                    $(this).html(
                        '<i class="fa fa-eye" style="left: 90% !important;" aria-hidden="true"></i>');
                } else {
                    $(this).data('value', 1);
                    $(this).html(
                        '<i class="fa fa-eye-slash" style="left: 90% !important;" aria-hidden="true"></i>'
                        );
                }
                show = $(this).data('value');
                $('#password').attr('type', show === 1 ? "text" : "password");
            });
        });

        // Toastr Message
        $(document).ready(function() {
            toastr.options.timeOut = 5000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif (Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @elseif (Session::has('warning'))
                toastr.error('{{ Session::get('warning') }}');
            @endif

            $('#toast-container').addClass('nopacity');

            $('#email').on('keyup', function() {
                var valid = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(this.value) && this.value.length;
                $('.email-validation').html((valid ? '' : '<strong> Invalid email id </strong>')).css(
                    "display", "block");
            });
        });
    </script>
</body>

</html>
