@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Event Orders')

@section('content')
    <div class="content-wrapper" style="min-height: 1302.12px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Scanned Ticket Orders List</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Events Details</li>
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
                            <div class="manageevent_table card-body">
                                <a class="btn btn-info" href="{{ URL::previous() }}"> Go Back </a>
                                <table id="order-details-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>User Name</th>
                                            <th>Image</th>
                                            <th>Ticket Title</th>
                                            <th>Ticket Type</th>
                                            <th>Quantity</th>
                                            <th>Price($)</th>
                                            <th>Total Price Paid($)</th>
                                            <th>Tickets Scanned</th>
                                            <th>Order Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (count($order_data) > 0)
                                            @foreach ($order_data as $key => $item)
                                                <tr class="sm-thrd">
                                                    <td class="summ-tds">{{ $key+1 }}</td>
                                                    <td class="summ-tds">{{ $item->user->full_name }}</td>
                                                    <td class="summary-th">
                                                        <a href="{{ url('event/detail/' . $order_details->event_id) }}"><img
                                                                src="{{ $item->order_details->event_image }}" alt=""
                                                                height="60" width="100" srcset=""></a>
                                                    </td>
                                                    <td class="summ-tds">{{ $item->order_details->ticket_title }}</td>
                                                    <td class="summ-tds">{{ $item->order_details->ticket_type }}</td>
                                                    <td class="summ-tds">{{ $item->order_details->ticket_purchase_qty }}
                                                    </td>
                                                    <td class="summ-tds">{{ $item->order_details->ticket_price }}</td>
                                                    <td class="summ-tds">
                                                        {{ $item->order_details->total_price }}</td>
                                                    <td>{{ $item->ticketsChecked }}</td>
                                                    <td class="summ-tds">{{ $item->order_placed_date }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" class="text-center">
                                                    {{ trans('messages.record_not_found') }}</td>
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
