@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Transfer Payments')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Transfer Payments</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payments</li>
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
                                <table id="data-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Event</th>
                                            <th>Admin</th>
                                            <th>Promoter</th>
                                            <th>Amount($)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($paymentTransfers) > 0)
                                            @foreach ($paymentTransfers as $key => $paymentTransfer)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>
                                                        <a class="anchor_color"
                                                            href="{{ url('event/detail/' . $paymentTransfer->event_id) }}">
                                                            {{ Str::length($paymentTransfer->event->event_title) > 20 ? substr($paymentTransfer->event->event_title, 0, 20) . '...' : $paymentTransfer->event->event_title }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $paymentTransfer->admin->full_name }}</td>
                                                    <td>{{ $paymentTransfer->promoter->full_name }}</td>
                                                    <td>{{ $paymentTransfer->total_price }}</td>
                                                    <td>
                                                        <span
                                                            class="badge badge-success">{{ $paymentTransfer->payment_status }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">{{ trans('messages.record_not_found') }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
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
