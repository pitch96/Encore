@extends('frontend.layouts.default')
<?php error_reporting(0); ?>
@section('title', 'Dashboard')
@section('style')
    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
        }
    </style>
@endsection
@section('content')
    <section class="login-section section-gapping">
        <div class="container">
            <div class="login-form d-flex">
                <div class="login-detail">
                    <div class="login-center">
                        <h1 class="main-title text-center">New Account Registration</h1>
                        <h4 class="login-subtitle">
                            Please enter your information
                        </h4>
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
                    <form action="{{ route('register') }}" method="POST" id="registerForm" class="needs-validation validation_form position-relative mt-4 pt-4" novalidate>
                        @csrf
                        <div class="form-control">
                            @if($errors->any())
                                @foreach($errors->getMessages() as $error)
                                    <div style="color: red;">{{$error[0]}}</div>
                                @endforeach
                            @endif 
                        </div>
                        <div class="form-control text-center">
                            <div class="control gender">
                                <label class="radio">
                                    <input type="radio" name="user_type" value="{{ config('constants.USER_TYPE') }}"
                                        data-skip="skip" checked="">
                                    User
                                </label>
                                <label class="radio">
                                    <input type="radio" value="{{ config('constants.PROMOTER_TYPE') }}" name="user_type"
                                        data-skip="skip" {{ request()->source == 'sales' ? 'checked' : '' }}>
                                    Promoter
                                </label>
                            </div>
                        </div>
                        <div class="form-control">
                            <input type="text" placeholder="First name" name="first_name" id="first_name" class="input-fields" value="{{ old('first_name') }}" required>
                        </div>
                        <div class="form-control">
                            <input type="text" placeholder="Last name" name="last_name" id="last_name" class="input-fields" value="{{ old('last_name') }}" required>
                        </div>
                        <div class="form-control">
                            <input type="email" placeholder="Email" name="email" id="email" class="input-fields" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-control">
                            <input type="text" placeholder="(123) 456-7890" name="phone_no" id="phone_no" class="input-fields" value="{{ old('phone_no') }}" required>
                        </div>
                        <div class="form-control">
                            <input type="text" placeholder="Company name" name="company_name" id="company_name" class="input-fields" value="{{ old('company_name') }}">
                        </div>
                        <div class="form-control">
                            <input type="password" placeholder="Password" name="password" id="password" class="input-fields" required>
                        </div>
                        <div class="form-control">
                            <input type="password" placeholder="Confirm password" name="password_confirmation" id="password_confirmation" class="input-fields" required>
                        </div>
                        <div class="form-control">
                            <label class="remember form-check-label" for="invalidCheck3">
                                <input class="form-check-input" name="agree" type="checkbox" value="1"
                                id="invalidCheck3" required>
                                 By Signing an account you agree to our
                                    <a href="{{ url('termsconditions') }}" class="reg hover-color">
                                        Term & Conditions </a> and
                                    <a href="{{ url('privacypolicy') }}" class="reg hover-color">
                                        Privacy Policy </a>
                               
                            </label>
                        </div>
                        <div class="form-control">
                            <input type="submit" value="Sign up" class="input-login btn-common">
                        </div>
                        <div class="form-control">
                            Already have an account? <a href="{{ url('login') }}" class="login-link"><b>Signin here</b></a>
                        </div>
                    </form>
                </div>
                <div class="login-picture">
                    <img src="{{ asset('frontend/images/login_pic.jpg') }}" alt="bg-login">
                </div>
            </div>
        </div>
    </section>

    <script>

        $(document).ready(function() {
            $("#registerForm").validate({
                rules: {
                    password: {
                        minlength: 6,
                    },
                    password_confirmation: {
                        minlength: 6,
                        equalTo: "#password"
                    }
                }
            });
        })
    </script>
@endsection
