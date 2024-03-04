@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Manage Tickets')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Manage Tickets</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tickets</li>
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
                            <div class="card-body">
                                <table id="data-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Ticket Title</th>
                                            <th>Event Title</th>
                                            <th>Ticket Type</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>End Date/Time</th>
                                            <th>Ticket Status</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($tickets) > 0)
                                            @foreach ($tickets as $key => $ticket)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ Str::length($ticket->ticket_title) > 30 ? substr($ticket->ticket_title, 0, 30) . '...' : $ticket->ticket_title }}
                                                    </td>
                                                    <td>{{ Str::length($ticket->event->event_title) > 30 ? substr($ticket->event->event_title, 0, 30) . '...' : $ticket->event->event_title }}
                                                    </td>
                                                    <td>{{ $ticket->ticket_type }}</td>
                                                    <td>{{ $ticket->quantity }}</td>
                                                    <td>{{ $ticket->ticket_type === 'Paid' ? $ticket->price : '0' }}</td>
                                                    <td>{{ $ticket->end_date }} {{ $ticket->end_time }}</td>
                                                    <td>
                                                        @if ($ticket->ticket_status === 'Upcoming')
                                                            <span
                                                                class="right badge badge-warning">{{ $ticket->ticket_status }}</span>
                                                        @elseif($ticket->ticket_status === 'Running')
                                                            <span
                                                                class="right badge badge-success">{{ $ticket->ticket_status }}</span>
                                                        @else
                                                            <span
                                                                class="right badge badge-danger">{{ $ticket->ticket_status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            if ($ticket->status === 1) {
                                                                $val = 0;
                                                                $status = 'checked';
                                                                $msg = 'Are you sure, you want to deactivate this ticket?';
                                                            } else {
                                                                $val = 1;
                                                                $status = '';
                                                                $msg = 'Are you sure, you want to activate this ticket?';
                                                            }
                                                        @endphp

                                                        <a href="javascript:void(0)" 
                                                        @if(($ticket->ticket_status === 'Expired') && ($ticket->status ===0)) data-delete_url=""
                                                            data-delete_msg="Ticket already expired. Cannot make it live."
                                                        @endif
                                                        data-delete_url="{{ url('admin/change/ticket/status/' . Crypt::encrypt($ticket->id) . '/' . $val) }}" 
                                                            data-delete_msg="{{ $msg }}" class="change-status" title="Manage Event Status">
                                                            <div class="form-group">
                                                                <div
                                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                                    <input type="checkbox" {{ $status }}
                                                                        class="custom-control-input">
                                                                    <label class="custom-control-label"
                                                                        for="customSwitch3"></label>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('admin/edit/ticket/' . Crypt::encrypt($ticket->id)) }}"
                                                            class="badge badge-warning">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="badge badge-danger delete-data" title="Delete Ticket" 
                                                            data-delete_msg="Are you sure, you want to delete this ticket?"
                                                            data-delete_url="{{ url('admin/delete/ticket/' . Crypt::encrypt($ticket->id)) }}" >
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                    </td>
                                                </tr>
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
