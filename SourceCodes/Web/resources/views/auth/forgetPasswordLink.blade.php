<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password</title>
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
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-lg-6 col-md-6 col-12 px-0">
                            <div class="login-main-banner"
                                style="background-image: url('{{ asset('frontend/images/res.png') }}')">
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12 col-12 px-md-5">
                            <div class="login my-4 text-center">
                                <a class="brand" href="{{ url('/') }}">
                                    <img src="{{ asset('frontend/images/logo.png') }}" alt="logo"
                                        class="brading img-fluid">
                                </a>
                                <h4 class="login_welcome mt-3">Reset Password ?</h4>
                                <p class="login_para">Please choose your new password.</p>

                                <form action="{{ route('reset.password.post') }}" method="POST"
                                    class="needs-validation validation_form position-relative mt-4 pt-4" novalidate>
                                    @csrf
                                    <input type="text" name="token" value="{{ $token }}"
                                        class="form-control" style="display: none">
                                    <div class="form-group">
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" placeholder="Email" required
                                            autocomplete="email">
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
                                        <input id="password" type="password"
                                            class="form-control hide-show-password @error('password') is-invalid @enderror"
                                            name="password" placeholder="Password" required autocomplete="new-password">
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

                                    <div class="form-group">
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                        <input id="password-confirm" type="password"
                                            class="form-control hide-show-password" name="password_confirmation"
                                            placeholder="Confirm password" required autocomplete="new-password">
                                        <a href="javascript:void(0)" class="show_password " data-value="0"><i
                                                class="fa fa-eye" style="left: 90% !important;"
                                                aria-hidden="true"></i></a>
                                        <span class="invalid-feedback text-left" role="alert">
                                            <strong>The confirm password field is required.</strong>
                                        </span>
                                    </div>
                                    <button type="submit" class="btn btn-block login-btn">Update Password</button>
                                </form>

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
                $('.email-validation').html((valid ? '' : '<strong> Invalid email address </strong>')).css(
                    "display", "block");
            });
        });

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
                $(this).siblings('.hide-show-password').attr('type', show === 1 ? "text" : "password");
            });
        });
    </script>
</body>

</html>
