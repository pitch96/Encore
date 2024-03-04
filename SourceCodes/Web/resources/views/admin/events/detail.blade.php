@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Event Preview')

@section('content')
    <div class="content-wrapper" style="min-height: 1302.12px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Event Detail</h1><br>
                        <a href="{{ $url }}" class="btn btn-secondary"> Go Back</a>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
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
                    <input type="hidden" id="startDate" value="{{ $event->start_date . ' ' . $event->start_time }}">
                    <input type="hidden" id="endDate" value="{{ $event->end_date . ' ' . $event->end_time }}">
                    <div class="col-12">
                        <div class="event_detail card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12 col-md-12 mb-3">
                                        <div class="profile_dp">
                                            <img src="{{ $event->image }}" class="product-image" alt="Event Image">
                                            <div class="edit_middle">
                                                <div class="pencil"><i class="fa fa-pencil-square" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col-12 -->
                                    <div class="col-xl-6 col-lg-12 col-md-12">
                                        <div class="event_data_card card pl-md-2 mb-0">
                                            <div class="row float-left mb-md-1">
                                                <div class="col-xl-3 col-lg-3 col-md-4 col-12 eve_view_col px-md-0">
                                                    <div class="preview_event card shadow-sm py-3 px-2 mb-md-0">
                                                        <h5 class="event_heading">Category Name : </h5>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 col-lg-9 col-md-8 col-12 eve_scnd_col">
                                                    <div class="prw_9ent card shadow-sm py-3 px-2 mb-md-0">
                                                        <p class="event_paragraph">{{ $event->category->name }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row float-left mb-md-1">
                                                <div class="col-xl-3 col-lg-3 col-md-4 col-12 eve_view_col px-md-0">
                                                    <div class="preview_event card shadow-sm py-3 px-2 mb-md-0">
                                                        <h5 class="event_heading"> Title : </h5>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 col-lg-9 col-md-8 col-12 eve_scnd_col">
                                                    <div class="prw_9ent card shadow-sm py-3 px-2 mb-md-0">
                                                        <p class="event_paragraph">{{ $event->event_title }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row float-left mb-md-1">
                                                <div class="col-xl-3 col-lg-3 col-md-4 col-12 eve_view_col px-md-0">
                                                    <div class="preview_event card shadow-sm py-3 px-2 mb-md-0">
                                                        <h5 class="event_heading">Event Description : </h5>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 col-lg-9 col-md-8 col-12 eve_scnd_col">
                                                    <div class="prw_9ent card shadow-sm py-3 px-2 mb-md-0">
                                                        <p class="event_paragraph">{{ $event->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row float-left mb-md-1">
                                                <div class="col-xl-3 col-lg-3 col-md-4 col-12 eve_view_col px-md-0">
                                                    <div class="view2nd_event card shadow-sm py-3 px-2 mb-md-0">
                                                        <h5 class="event_heading">Event Details : </h5>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 col-lg-9 col-md-8 col-12 eve_scnd_col">
                                                    <div class="prw_9ent card shadow-sm py-3 px-2 mb-md-0">
                                                        <p class="event_paragraph"> <span class="text"> Venue :-
                                                            </span>{{ $event->venue }}</p>
                                                        <p class="event_paragraph"> <span class="text"> Address :-
                                                            </span>{{ $event->address }}</p>
                                                        <p class="event_paragraph"> <span class="text"> City :-
                                                            </span>{{ $event->city }}</p>
                                                        <p class="event_paragraph"> <span class="text"> Zipcode :-
                                                            </span>{{ $event->zipcode }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row float-left mb-md-1">
                                                <div class="col-xl-3 col-lg-3 col-md-4 col-12 eve_view_col px-md-0">
                                                    <div class="view3rd_event card shadow-sm py-3 px-2 mb-md-0">
                                                        <h5 class="event_heading">Event Organizer : </h5>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 col-lg-9 col-md-8 col-12 eve_scnd_col">
                                                    <div class="prw_9ent card shadow-sm py-3 px-2 mb-md-0">
                                                        <p class="event_paragraph"> <span class="text"> Organizer Name :-
                                                            </span>{{ $event->organizer }}</p>
                                                        <p class="event_paragraph"> <span class="text"> Event Start
                                                                Date/Time :-
                                                            </span>{{ $event->start_date }} {{ $event->start_time }}
                                                        </p>
                                                        <p class="event_paragraph"> <span class="text"> Event End
                                                                Date/Time :-
                                                            </span>{{ $event->end_date }} {{ $event->end_time }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row float-left mb-md-1">
                                                <div class="col-xl-3 col-lg-3 col-md-4 col-12 eve_view_col px-md-0">
                                                    <div class="preview_event card shadow-sm py-3 px-2 mb-md-0">
                                                        <h5 class="event_heading">Event Status : </h5>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 col-lg-9 col-md-8 col-12 eve_scnd_col">
                                                    <div class="prw_9ent card shadow-sm py-3 px-2 mb-md-0">
                                                        <p class="event_paragraph" id="demo"></p>
                                                        <!-- inner col-12 -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($event->user_id === Auth::user()->id)
                                <div class="card-footer text-center">
                                    @php
                                        if ($event->status === 1) {
                                            $val = 0;
                                            $color = 'green';
                                            $msg = 'Are you sure, you want to remove this event from live?';
                                            $text = 'Live Now';
                                        } else {
                                            $val = 1;
                                            $color = 'red';
                                            $msg = 'Are you sure, you want to make live this event?';
                                            $text = 'Make Live';
                                        }
                                    @endphp
                                    {{-- @dd($promotion_event->status); --}}

                                    @if (Auth::user()->user_type === config('constants.PROMOTER_TYPE'))
                                        @if (isset($promotion_event))
                                            @if ($promotion_event->status === 0)
                                                <a href="javascript:void(0)" class="btn btn-secondary">Please wait for admin
                                                    approval. Your request is in-progress</a>
                                            @elseif($promotion_event->status === 1)
                                                <a href="javascript:void(0)"
                                                    data-delete_url="{{ url('admin/change/event/status/' . Crypt::encrypt($event->id) . '/' . $val) }}"
                                                    data-delete_msg="{{ $msg }}"
                                                    class="btn save_event_btn btn-secondary bg-{{ $color }} change-status">{{ $text }}</a>
                                                @if ($event->status === 1)
                                                    <a href="javascript:void(0)" class="btn btn-secondary refer_event"
                                                        data-stripe_account="{{ $stripe_account->id }}"
                                                        data-event_id="{{ $event->id }}">Refer Link</a>
                                                @endif
                                            @else
                                                <a href="javascript:void(0)" class="btn btn-secondary"> Your request was
                                                    rejected by admin.</a>
                                            @endif
                                        @else
                                            @if (Auth::user()->id === $event->user_id)
                                                <a href="{{ url('admin/get/access/' . Crypt::encrypt($event->id) . '/' . Crypt::encrypt($event->user_id)) }}"
                                                    class="btn btn-secondary get-access1"
                                                    data-event_created_by="{{ $event->user_id }}"
                                                    data-event_id="{{ $event->id }}">Get Access</a>
                                            @endif
                                        @endif
                                    @elseif(Auth::user()->user_type === config('constants.ADMIN_TYPE'))
                                        <a href="javascript:void(0)"
                                            data-delete_url="{{ url('admin/change/event/status/' . Crypt::encrypt($event->id) . '/' . $val) }}"
                                            data-delete_msg="{{ $msg }}"
                                            class="btn save_event_btn btn-secondary bg-{{ $color }} change-status">{{ $text }}</a>
                                        @if ($event->status === 1)
                                            <a href="javascript:void(0)" class="btn btn-secondary refer_event"
                                                data-stripe_account="{{ $stripe_account->id }}"
                                                data-event_id="{{ $event->id }}">Refer Link</a>
                                        @endif
                                    @else
                                        <a href="javascript:void(0)"
                                            data-delete_url="{{ url('admin/change/event/status/' . Crypt::encrypt($event->id) . '/' . $val) }}"
                                            data-delete_msg="{{ $msg }}"
                                            class="btn save_event_btn btn-secondary bg-{{ $color }} change-status">{{ $text }}</a>
                                    @endif
                                </div>
                            @endif
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
    <input type="hidden" id="loggedin_id" value="{{ Crypt::encrypt(Auth::user()->id) }}">
@endsection

@section('script')
    <script src="{{ asset('customjs/adminjs/event/detail.js?v=' . time()) }}"></script>
@endsection
