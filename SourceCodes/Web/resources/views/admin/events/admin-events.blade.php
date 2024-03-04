@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Manage Event')

@section('content')
    <div class="content-wrapper" style="min-height: 1302.12px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Manage Events</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Events</li>
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
                                <input type="hidden" id="params" value="{{ $params }}">
                                <table id="promoter-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Event Title</th>
                                            <th>Category Type</th>
                                            <th>Organizer</th>
                                            <th>Venue</th>
                                            <th>Start Date/Time</th>
                                            <th>End Date/Time</th>
                                            <th>Event Status</th>
                                            <th>Created By</th>
                                            <th>Event Detail</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($events) > 0)
                                            @foreach ($events as $key => $event)
                                                @if ($event->event_status != 'Expired')
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td title="{{ $event->event_title }}">
                                                            {{ Str::length($event->event_title) > 30 ? substr($event->event_title, 0, 30) . '...' : $event->event_title }}
                                                        </td>
                                                        <td>{{ $event->category->name }}</td>
                                                        <td>{{ $event->organizer }}</td>
                                                        <td title="{{ $event->venue }} ">
                                                            {{ Str::length($event->venue) > 20 ? substr($event->venue, 0, 20) . '...' : $event->venue }}
                                                        </td>
                                                        <td>{{ $event->start_date }} {{ $event->start_time }}</td>
                                                        <td>{{ $event->end_date }} {{ $event->end_time }}</td>
                                                        <td>
                                                            @if ($event->event_status === 'Upcoming')
                                                                <span
                                                                    class="right badge badge-warning">{{ $event->event_status }}</span>
                                                            @elseif($event->event_status === 'Running')
                                                                <span
                                                                    class="right badge badge-success">{{ $event->event_status }}</span>
                                                            @else
                                                                <span
                                                                    class="right badge badge-danger">{{ $event->event_status }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $event->user->first_name }} {{ $event->user->last_name }}</td>
                                                        <td>
                                                            <a href="{{ url('admin/event/detail/' . Crypt::encrypt($event->id)) }}"
                                                                title="View Event Detail" class="badge badge-secondary">
                                                                <i class="fa-solid fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                        <tr>
                                            <td colspan="10" class="text-center">{{ trans('messages.record_not_found') }}</td>
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
