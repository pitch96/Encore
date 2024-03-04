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
                        <h1 class="main-title text-center">Welcome</h1>
                        <h4 class="login-subtitle">
                            Please login to continue
                        </h4>
                    </div>
                    @php
                   // print_r(session('error'));
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
                    <form action="{{ route('login') }}" method="POST" id="loginForm" class="needs-validation validation_form position-relative mt-4 pt-4" novalidate>
                        @csrf
                        
                        <div class="form-control">
                            @if(session()->has('error'))
                                <div style="color: red;">{{ session('error') }}</div>
                            @endif
                        </div>

                        <div class="form-control">
                            <input type="email" placeholder="Email" name="email" class="input-fields" value="{{ $login_email }}" required>
                            @if($errors->any())
                                @foreach($errors->getMessages() as $error)
                                    <span style="color: red;">{{$error[0]}}</span>
                                @endforeach
                            @endif 
                        </div>
                        <div class="form-control">
                            <input type="password" placeholder="Password" name="password" class="input-fields" required>
                        </div>
                        <div class="form-control forgot-button">
                            <a href="{{ route('forget.password.get') }}" class="login-link">Forgot Password?</a>
                        </div>
                        <div class="form-control">
                            <input type="submit" value="Login" class="input-login btn-common">
                        </div>
                        <div class="form-control">
                            Not register yet?<a href="{{ url('register') }}" class="login-link"><b>Create an Account</b></a>
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
            $("#loginForm").validate();
        })
    </script>
@endsection