@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Promotional List')

@section('content')
    <div id="tab1" class="content-wrapper" style="min-height: 1302.12px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Promotional Lists</h1>
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
                                if($params === 'free_events'){
                                        $color2 =  'btn btn-info';
                                        $color1 =  'btn btn-secondary';
                                    }else{
                                        $color2 =  'btn btn-secondary';
                                        $color1 =  'btn btn-info';
                                    }
                                @endphp
                                <a href="/admin/promotion/list"><button class="{{ $color1 }}">Paid Events</button></a>
                                <a href="/admin/promotion/list?events=free_events"><button class="{{ $color2 }}">Free Events</button></a>
                                <input type="hidden" id="params" value="{{ $params }}">
                                <table id="promotion-list-table" class=" table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Promoter Name</th>
                                            <th>Event Title</th>
                                            <th>Category Type</th>
                                            <th>Organizer</th>
                                            <th>Venue</th>
                                            <th>Start Date/Time</th>
                                            <th>End Date/Time</th>
                                            <th>Event Status</th>
                                            <th>Payment Status</th>
                                            <th>Actions</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @if((count($promotionEvents) > 0))
                                            @foreach ($promotionEvents as $key => $promotionEvent)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $promotionEvent->promoter->first_name }}
                                                        {{ $promotionEvent->promoter->last_name }}</td>
                                                    <td title="{{ $promotionEvent->events->event_title }}">
                                                        {{ Str::length($promotionEvent->events->event_title) > 30 ? substr($promotionEvent->events->event_title, 0, 30) . '...' : $promotionEvent->events->event_title }}
                                                    </td>
                                                    <td>{{ $promotionEvent->events->category->name }}</td>
                                                    <td>{{ $promotionEvent->events->organizer }}</td>
                                                    <td title="{{ $promotionEvent->events->venue }} ">
                                                        {{ Str::length($promotionEvent->events->venue) > 20 ? substr($promotionEvent->events->venue, 0, 20) . '...' : $promotionEvent->events->venue }}
                                                    </td>
                                                    <td>{{ $promotionEvent->events->start_date }}
                                                        {{ $promotionEvent->events->start_time }}</td>
                                                    <td>{{ $promotionEvent->events->end_date }}
                                                        {{ $promotionEvent->events->end_time }}</td>
                                                    <td>
                                                        @if ($promotionEvent->event_status === 'Upcoming')
                                                            <span
                                                                class="right badge badge-warning">{{ $promotionEvent->event_status }}</span>
                                                        @elseif($promotionEvent->event_status === 'Running')
                                                            <span
                                                                class="right badge badge-success">{{ $promotionEvent->event_status }}</span>
                                                        @else
                                                            <span
                                                                class="right badge badge-danger">{{ $promotionEvent->event_status }}</span>
                                                        @endif
                                                    </td>
                                                    <td><span
                                                            class="right badge badge-success">{{ $promotionEvent->payment_status ? $promotionEvent->payment_status: 'Free Event' }}</span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            if ($promotionEvent->status === 0) {
                                                                $color = 'warning';
                                                                $status = 'Pending';
                                                                $visibility = '';
                                                            } elseif ($promotionEvent->status === 1) {
                                                                $color = 'success';
                                                                $status = 'Approved';
                                                                $visibility = 'disabled';
                                                            } else {
                                                                $color = 'danger';
                                                                $status = 'Rejected';
                                                                $visibility = '';
                                                            }
                                                        @endphp
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-{{ $color }} btn-sm">
                                                                {{ $status }}</button>
                                                            <button type="button"
                                                                class="btn btn-{{ $color }} dropdown-toggle dropdown-icon btn-sm"
                                                                data-toggle="dropdown" aria-expanded="false"
                                                                {{ $visibility }}>
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            @if ($visibility != 'disabled')
                                                                <div class="dropdown-menu" role="menu" style="">
                                                                    <a href="javascript:void(0)" class="dropdown-item text-warning permission-response"
                                                                        data-response_msg="Are you sure, you want make pending this request?"
                                                                        data-response_url="{{ url('admin/promotion/action/0/' . Crypt::encrypt($promotionEvent->id)) }} }}"
                                                                        >Pending</a>
                                                                    <a href="javascript:void(0)" class="dropdown-item text-success permission-response"
                                                                        data-response_msg="Are you sure, you want make approved this request?"
                                                                        data-response_url="{{ url('admin/promotion/action/1/' . Crypt::encrypt($promotionEvent->id)) }} }}"
                                                                        >Approved</a>
                                                                    <a href="javascript:void(0)" class="dropdown-item text-danger permission-response"
                                                                        data-response_msg="Are you sure, you want make reject this request?"
                                                                        data-response_url="{{ url('admin/promotion/action/2/' . Crypt::encrypt($promotionEvent->id)) }} }}"
                                                                        >Rejected</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('admin/event/detail/' . Crypt::encrypt($promotionEvent->events->id)) }}"
                                                            class="badge badge-secondary" title="View Event Detail">
                                                            <i class="fa-solid fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td colspan="11" class="text-center">{{ trans('messages.record_not_found') }}</td>
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
