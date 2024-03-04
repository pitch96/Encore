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
                                @php
                                if($params === 'all_events'){
                                        $color2 =  'btn btn-info';
                                        $color1 =  'btn btn-secondary';
                                    }else{
                                        $color2 =  'btn btn-secondary';
                                        $color1 =  'btn btn-info';
                                    }
                                @endphp
                                <a href="/admin/manage/events"><button class="{{ $color1 }}">My Events</button></a>
                                <a href="/admin/manage/events?events=all_events"><button class="{{ $color2 }}">All Events</button></a>
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
                                            @if (Auth::user()->user_type != config('constants.ADMIN_TYPE'))
                                                <th>Is Approval</th>
                                            @endif
                                            <th>Is Live</th>
                                            <th>Actions</th>
                                            @if (Auth::user()->user_type === config('constants.ADMIN_TYPE'))
                                                <th>Make Popular</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($events) > 0)
                                            @foreach ($events as $key => $event)
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
                                                    @if (Auth::user()->user_type != config('constants.ADMIN_TYPE'))
                                                        <td>
                                                            @if ($event->promoterRequestResponse->status === 0)
                                                                <span class="right badge badge-warning">Pending</span>
                                                            @elseif($event->promoterRequestResponse->status === 1)
                                                                <span class="right badge badge-success">Approved</span>
                                                            @elseif($event->promoterRequestResponse->status === 2)
                                                                <span class="right badge badge-danger">Rejected</span>
                                                            @elseif($event->user_id === config('constants.ADMIN_TYPE'))
                                                                <span class="right badge badge-success">Approved</span>
                                                            @else
                                                                <span class="right badge badge-info">Pay
                                                                    ${{ $paybleAmount }}</span>
                                                            @endif
                                                        </td>
                                                    @endif
                                                    <td>
                                                        @php
                                                            if ($event->status === 1) {
                                                                $val = 0;
                                                                $status = 'checked';
                                                                $msg = 'Are you sure, you want to remove this event from live?';
                                                            } else {
                                                                $val = 1;
                                                                $status = '';
                                                                $msg = 'Are you sure, you want to make live this event?';
                                                            }
                                                        @endphp
                                                        <a href="javascript:void(0)"
                                                        @if($event->event_status === 'Expired')
                                                                    data-delete_url=""
                                                                    data-delete_msg="This event has expired. Can not make it live now."
                                                            @elseif (Auth::user()->user_type === config('constants.ADMIN_TYPE'))
                                                                    data-delete_url="{{ url('admin/change/event/status/' . Crypt::encrypt($event->id) . '/' . $val) }}"
                                                                    data-delete_msg="{{ $msg }}"
                                                                @elseif(Auth::user()->id != $event->user_id)
                                                                    data-delete_url=""
                                                                    data-delete_msg="You are not allowed to perform this action."
                                                                @elseif($event->verifiedPromoterEvent === 1 && $event->user_id === Auth::user()->id)
                                                                    @if ($event->promoterRequestResponse->status === 0)
                                                                        data-delete_url=""
                                                                        data-delete_msg="Wait for Admin's response for this event!"
                                                                    @elseif($event->promoterRequestResponse->status === 2)
                                                                        data-delete_url=""
                                                                        data-delete_msg="Admin has rejected your request!"
                                                                    @else
                                                                        data-delete_url="{{ url('admin/change/event/status/' . Crypt::encrypt($event->id) . '/' . $val) }}"
                                                                        data-delete_msg="{{ $msg }}"
                                                                    @endif
                                                        @elseif(count($event->promoterRequestResponse) > 0)
                                                            @if ($event->promoterRequestResponse->status === 0) data-delete_url=""
                                                                        data-delete_msg="Wait for Admin's response for this event!"
                                                                    @elseif($event->promoterRequestResponse->status === 2)
                                                                        data-delete_url=""
                                                                        data-delete_msg="Admin has rejected your request!"
                                                                    @else
                                                                        data-delete_url="{{ url('admin/change/event/status/' . Crypt::encrypt($event->id) . '/' . $val) }}"
                                                                        data-delete_msg="{{ $msg }}" @endif
                                                        @else data-delete_url=""
                                                            data-get_access="{{ url('/admin/get/access/' . Crypt::encrypt($event->id) . '/' . Crypt::encrypt(Auth::user()->id)) }}"
                                                            data-delete_msg="First take approval by admin." @endif
                                                            title="Manage Event Status" class="change-status">
                                                            <div class="form-group">
                                                                <div
                                                                    class="custom-control sw-point custom-switch custom-switch-off-danger custom-switch-on-success">
                                                                    <input type="checkbox" {{ $status }}
                                                                        class="custom-control-input">
                                                                    <label class="custom-control-label"
                                                                        for="customSwitch3"></label>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('admin/event/detail/' . Crypt::encrypt($event->id)) }}"
                                                            class="badge badge-secondary" title="View Event Detail">
                                                            <i class="fa-solid fa-eye"></i></a>
                                                        @if (Auth::user()->user_type === config('constants.ADMIN_TYPE') || $event->user_id === Auth::user()->id)
                                                            <a href="{{ url('admin/edit/event/' . Crypt::encrypt($event->id)) }}"
                                                                title="Edit Event" class="badge badge-warning"><i
                                                                    class="fa-solid fa-pen"></i></a>
                                                            <a href="javascript:void(0)"
                                                                class="badge badge-danger delete-data" title="Delete Event"
                                                                data-delete_msg="Are you sure, you want to delete this event?"
                                                                data-delete_url="{{ url('admin/delete/event/' . Crypt::encrypt($event->id)) }}">
                                                                <i class="fa-solid fa-trash-can"></i></a>
                                                            <a href="javascript:void(0)"
                                                                data-delete_url="{{ url('admin/cancel/event/' . Crypt::encrypt($event->id)) }}"
                                                                data-delete_msg="Do you really want to cancel the event?"
                                                                class="badge badge-secondary cancel-event"
                                                                title="Cancel Event">
                                                                <i class="fa fa-close"></i></a>
                                                        @endif
                                                    </td>
                                                    @if (Auth::user()->user_type === config('constants.ADMIN_TYPE') )
                                                        <td>
                                                            @php
                                                                if ($event->isPopular === 1) {
                                                                    $val = 0;
                                                                    $status = 'checked';
                                                                    $msg = 'Are you sure, you want to remove this event from popluar event List?';
                                                                } else {
                                                                    $val = 1;
                                                                    $status = '';
                                                                    $msg = 'Are you sure, you want to make this event as popular event?';
                                                                }
                                                            @endphp
                                                            <a href="javascript:void(0)"
                                                                @if ($event->status != 1)
                                                                    data-delete_url=""
                                                                    data-delete_msg="You cannot make event as popular if event is not live"
                                                                @else
                                                                    data-delete_url="{{ url('admin/change/popular/status/' . Crypt::encrypt($event->id) . '/' . $val) }}"
                                                                    data-delete_msg="{{ $msg }}"
                                                                @endif
                                                                title="Make Event Popular" class="popular-status">
                                                                <div class="form-group">
                                                                    <div
                                                                        class="custom-control sw-point custom-switch custom-switch-off-danger custom-switch-on-success">
                                                                        <input type="checkbox" {{ $status }}
                                                                            class="custom-control-input">
                                                                        <label class="custom-control-label"
                                                                            for="customSwitch3"></label>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </td>
                                                    @endif
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
