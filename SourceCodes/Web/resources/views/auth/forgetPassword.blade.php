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
                        <h2 class="main-title">Forgot Password ?</h2>
                        <h4 class="login-subtitle">
                            Enter your email ID and we'll send you a forgot password link.
                        </h4>
                    </div>
                    <form action="{{ route('forget.password.post') }}" method="POST" id="forgetPasswordForm" class="needs-validation validation_form position-relative mt-4 pt-4" novalidate>
                        @csrf
                        
                        <div class="form-control">
                            @if(session()->has('error'))
                                <div style="color: red;">{{ session('error') }}</div>
                            @endif
                        </div>

                        <div class="form-control">
                            <input type="email" placeholder="Email" name="email" class="input-fields" value="{{ old('email') }}" required>
                            @if($errors->any())
                                @foreach($errors->getMessages() as $error)
                                    <span style="color: red;">{{$error[0]}}</span>
                                @endforeach
                            @endif 
                        </div>
                        <div class="form-control">
                            <input type="submit" value="Send Link" class="input-login btn-common">
                        </div>
                        <div class="form-control">
                            Back to <a href="{{ url('login') }}" class="reg hover-color"> Login
                            </a>
                        </div>
                    </form>
                </div>
                <div class="login-picture">
                    <img src="{{ asset('frontend/images/bg-login.png') }}" alt="bg-login">
                </div>
            </div>
        </div>
    </section>

    <script>

        $(document).ready(function() {
            $("#forgetPasswordForm").validate();
        })
    </script>
@endsection