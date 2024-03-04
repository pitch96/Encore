@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Payment Details')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
@endsection
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Payment Details</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payment Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="col-md-5 col-md-offset-3">
                                    <div class="panel panel-default" style="background-color: #343a40;">
                                        <div class="panel-heading display-table"
                                            style="color: #f5f5f5;
                                            background-color: #343a40;">
                                            <div class="row display-tr">
                                                <h3 class="panel-title display-td">Payment Details</h3>
                                                <div class="display-td">
                                                    <img class="img-responsive pull-right" style="height: 70px; width:310px"
                                                        src="{{ asset('stripe-img.png') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form role="form" action="{{ route('stripe.payment') }}" method="post"
                                                class="validation" data-cc-on-file="false"
                                                data-stripe-publishable-key="{{ config('constants.STRIPE_KEY') }}" id="payment-form">
                                                @csrf
                                                <input type="hidden" name="event_id" value="{{ $event_id }}">
                                                <input type="hidden" name="event_created_by" value="{{ $creater_id }}">

                                                <div class='form-row row'>
                                                    <div class='col-xs-12 form-group required'>
                                                        <label class='control-label'>Amount <span class="text-danger">(This is the fixed amount for this event)</span></label>
                                                        <input class='form-control' type='text' name="payable_amount"
                                                            value="${{ $paybleAmount }}" readonly>
                                                    </div>
                                                </div>
                                                <div class='form-row row'>
                                                    <div class='col-xs-12 form-group required'>
                                                        <label class='control-label'>Card Holder Name</label>
                                                        <input class='form-control' size='4' type='text'>
                                                    </div>
                                                </div>

                                                <div class='form-row row'>
                                                    <div class='col-xs-12 form-group card-no required'>
                                                        <label class='control-label'>Card Number</label>
                                                        <input autocomplete='off' class='form-control card-num'
                                                            size='20' type='text'>
                                                    </div>
                                                </div>

                                                <div class='form-row row'>
                                                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                                                        <label class='control-label'>CVC</label>
                                                        <input autocomplete='off' class='form-control card-cvc'
                                                            placeholder='e.g 415' size='4' type='text'>
                                                    </div>
                                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                        <label class='control-label'>Exp Month</label>
                                                        <input class='form-control card-expiry-month' placeholder='MM'
                                                            size='2' type='text'>
                                                    </div>
                                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                        <label class='control-label'>Exp Year</label>
                                                        <input class='form-control card-expiry-year' placeholder='YYYY'
                                                            size='4' type='text'>
                                                    </div>
                                                </div>

                                                <div class='form-row row'>
                                                    <div class='col-md-12 hide error form-group'>
                                                        <div class='alert-danger alert'>Fix the errors before you begin.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <button class="btn btn-primary btn-lg btn-block" id="pay_now"
                                                            type="submit">Pay
                                                            Now</button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection

@section('script')
    {{-- <script type="text/javascript" src="https://js.stripe.com/v2/"></script> --}}
    <script type="text/javascript" src="{{ asset('js/stripe.js?v=' . time()) }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/payment.js?v=' . time()) }}"></script>
@endsection
