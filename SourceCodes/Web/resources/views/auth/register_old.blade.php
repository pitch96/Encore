<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registration</title>
    <!-----basic page needs --->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12 px-0">
                            <div class="login-main-banner"
                                style="background-image: url('{{ asset('frontend/images/reg.png') }}')">
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12 col-12 px-md-5">
                            <div class="login-box">
                                <div class="login my-4 text-center">
                                    <a class="brand" href="{{ url('/') }}">
                                        <img src="{{ asset('frontend/images/logo.png') }}" alt="logo"
                                            class="brading img-fluid">
                                    </a>
                                    <h4 class="login_welcome mt-3">Welcome!</h4>
                                    <p class="login_para">Hello there Sign up to continue</p>

                                    <form method="POST" action="{{ route('register') }}"
                                        class="needs-validation validation_form position-relative mt-4 pt-4" novalidate>
                                        @csrf

                                        <div class="form-group">
                                            <div class="control gender">
                                                <label class="radio">
                                                    <input type="radio" name="user_type" value="{{ config('constants.USER_TYPE') }}"
                                                        data-skip="skip" checked="">
                                                    User
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" value="{{ config('constants.PROMOTER_TYPE') }}" name="user_type"
                                                        data-skip="skip">
                                                    Promoter
                                                </label>
                                                @error('user_type')
                                                    <span class="invalid-feedback text-left" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @else
                                                    <span class="invalid-feedback text-left" role="alert">
                                                        <strong>The first name field is required.</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <i class="fa fa-user-o" aria-hidden="true"></i>
                                            <input type="text"
                                                class="form-control name-field reset-form @error('first_name') is-invalid @enderror"
                                                name="first_name" maxLength="20" value="{{ old('first_name') }}"
                                                placeholder="First name" required autocomplete="first_name" autofocus>
                                            @error('first_name')
                                                <span class="invalid-feedback text-left" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @else
                                                <span class="invalid-feedback text-left" role="alert">
                                                    <strong>The first name field is required.</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <i class="fa fa-user-o" aria-hidden="true"></i>
                                            <input id="last_name" type="text"
                                                class="form-control name-field reset-form @error('last_name') is-invalid @enderror"
                                                maxLength="20" name="last_name" value="{{ old('last_name') }}"
                                                placeholder="Last name" required autocomplete="last_name" autofocus>
                                            @error('last_name')
                                                <span class="invalid-feedback text-left" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @else
                                                <span class="invalid-feedback text-left" role="alert">
                                                    <strong>The last name field is required.</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                            <input id="email" type="email"
                                                class="form-control reset-form @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" placeholder="Email" required
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
                                            <i class="fa fa-mobile" aria-hidden="true"></i>
                                            <input type="text" name="phone_no"
                                                class="form-control phone_no reset-form @error('phone_no') is-invalid @enderror"
                                                value="{{ old('phone_no') }}" required
                                                placeholder="(123) 456-7890" />
                                            @error('phone_no')
                                                <span class="invalid-feedback text-left" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @else
                                                <span class="invalid-feedback text-left" role="alert">
                                                    <strong>The phone number field is required.</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <i class="fa fa-mobile" aria-hidden="true"></i>
                                            <input type="text" name="company_name"
                                                class="form-control company_name reset-form"
                                                value="{{ old('company_name') }}" maxlength="100"
                                                placeholder="Company Name" />
                                        </div>

                                        <div class="form-group">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                            <input type="password" id="password"
                                                class="form-control hide-show-password reset-form @error('password') is-invalid @enderror"
                                                name="password" placeholder="Password" required
                                                autocomplete="password">
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
                                            <input type="password" id="password-confirm"
                                                class="form-control hide-show-password reset-form"
                                                name="password_confirmation" placeholder="Confirm password" required
                                                autocomplete="new-password">
                                            <a href="javascript:void(0)" class="show_password " data-value="0"><i
                                                    class="fa fa-eye" style="left: 90% !important;"
                                                    aria-hidden="true"></i></a>
                                            <span class="invalid-feedback text-left" role="alert">
                                                <strong>The confirm password field is required.</strong>
                                            </span>
                                        </div>
                                        <div class="form-group form-check">
                                            <div class="row d-flex justify-content-between pb-3">
                                                <div class="col-12 text-left">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck3" required>
                                                    <label class="remember form-check-label" for="invalidCheck3">
                                                        <div class="agree"> By Signing an account you agree to our
                                                            <a href="{{ url('termsconditions') }}" class="reg hover-color">
                                                                Term & Conditions </a> and
                                                            <a href="{{ url('privacypolicy') }}" class="reg hover-color">
                                                                Privacy Policy </a>
                                                        </div>
                                                    </label>

                                                    <div class="invalid-feedback text-left">
                                                        You must agree before submitting.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-block login-btn">Sign Up</button>
                                    </form>
                                    <div class="create_acc mt-4">
                                        <p class="Reg_login">
                                            Already have an account
                                            <a href="{{ url('login') }}" class="reg hover-color"> Signin here </a>
                                        </p>
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
                $(this).siblings('.hide-show-password').attr('type', show === 1 ? "text" : "password");
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
        });

        $(document).ready(function() {
            $('.phone_no').mask('(000) 000-0000');
        });
        $('#email').on('keyup', function() {
            var valid = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(this.value) && this.value.length;
            $('.email-validation').html((valid ? '' : '<strong> Invalid email id </strong>')).css("display",
                "block");
        });

        function testInput(event) {
            var value = String.fromCharCode(event.which);
            var pattern = new RegExp(/[a-zåäö ]/i);
            return pattern.test(value);
        }

        $('.name-field').bind('keypress', testInput);

        $('input[type=radio][name=user_type]').change(function() {
            $('.reset-form').val('');
        })
    </script>
</body>

</html>
