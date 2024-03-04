@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Order Details')

@section('content')
    <div class="content-wrapper" style="min-height: 1302.12px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Event Details with Orders</h1>
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
                                @php
                                if($params === 'expired_events'){
                                        $color2 =  'btn btn-info';
                                        $color1 =  'btn btn-secondary';
                                    }else{
                                        $color2 =  'btn btn-secondary';
                                        $color1 =  'btn btn-info';
                                    }
                                @endphp
                                <a href="/admin/event/details"><button class="{{ $color1 }}">Running</button></a>
                                <a href="/admin/event/details?events=expired_events"><button class="{{ $color2 }}">Expired</button></a>
                                <input type="hidden" id="params" value="{{ $params }}">
                                <table id="event-order-details-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Event Title</th>
                                            <th>Start Date/Time</th>
                                            <th>End Date/Time</th>
                                            <th>Tickets Sold</th>
                                            <th>Revenue Generated</th>
                                            <th>Guest Count</th>
                                            <th>See Orders</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($events) > 0)
                                            @foreach ($events as $key => $event)
                                                <tr>
                                                    @if($event != null)
                                                        <td>{{ $key+1 }}</td>
                                                    @endif
                                                    <td title="{{ $event->event_title }}">
                                                        {{ Str::length($event->event_title) > 30 ? substr($event->event_title, 0, 30) . '...' : $event->event_title }}
                                                    </td>
                                                    <td>{{ $event->start_date }} {{ $event->start_time }}</td>
                                                    <td>{{ $event->end_date }} {{ $event->end_time }}</td>
                                                    <td>{{ $event->tickets_sold['tickets_sold'] === null ? 0 : $event->tickets_sold['tickets_sold'] }}
                                                    </td>
                                                    <td>{{ '$' }}{{ $event->revenue['revenue_generated'] === null ? 0 : $event->revenue['revenue_generated'] }}
                                                    </td>
                                                    <td>{{ $event->guestCount ? $event->guestCount : 0 }}</td>
                                                    <td>
                                                        <a href="{{ url('admin/event/orders/details/' . Crypt::encrypt($event->id)) }}">
                                                            <button class="btn btn-info">See Orders</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="12" class="text-center">
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
