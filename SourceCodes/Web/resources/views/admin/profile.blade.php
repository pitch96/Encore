@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Profile')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                        <!-- Profile Image -->
                        <div class="card profile-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid"
                                        src="{{ $user->user_profile ? asset('user-images/' . $user->user_profile) : asset('no-image.png') }}"
                                        alt="User profile picture">
                                    <a href="javascript:void(0)" class="edit-profile">
                                        <i class="fa-solid fa-pen profile-pen"></i>
                                    </a>
                                </div>

                                <h3 class="profile-username text-center">{{ $user->first_name }} {{ $user->last_name }}
                                </h3>

                                <h4 class="event_detail_form text-center">
                                    @if ($user->user_type === config('constants.ADMIN_TYPE'))
                                        Admin
                                    @elseif($user->user_type === config('constants.USER_TYPE'))
                                        User
                                    @else
                                        Promoter
                                    @endif
                                </h4>

                                <ul class="list-group list-group-unbordered mb-3 user-details">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <h5 class="data-profile">Name</h5>
                                        <h2 class="data-file"> <a class="float-right">{{ $user->first_name }}
                                                {{ $user->last_name }}</a> </h2>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <h5 class="data-profile">Email</h5>
                                        <h2 class="data-file"> <a class="float-right">{{ $user->email }}</a></h2>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <h5 class="data-profile"> Phone No </h5>
                                        <h2 class="data-file"> <a class="float-right">{{ $user->phone_no }}</a></h2>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <h5 class="data-profile">User Type</h5>
                                        <h2 class="data-file"> <a class="float-right">
                                                @if ($user->user_type === config('constants.ADMIN_TYPE'))
                                                    Admin
                                                @elseif($user->user_type === config('constants.USER_TYPE'))
                                                    User
                                                @else
                                                    Promoter
                                                @endif
                                            </a>
                                        </h2>
                                    </li>
                                </ul>
                            </div>
                            <div class="row edit-user-profile mb-3" style="display: none">
                                <form method="POST" action="{{ url('admin/update/user/' . Crypt::encrypt($user->id)) }}"
                                    enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row">
                                        <div class="input-group mb-3">
                                            <input id="first_name" type="text" class="form-control" name="first_name"
                                                maxLength="20" value="{{ $user->first_name }}" placeholder="First name"
                                                required autocomplete="first_name" autofocus>
                                            @error('first_name')
                                                <span class="text-danger text-sm" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="input-group mb-3">
                                            <input id="last_name" type="text" class="form-control" name="last_name"
                                                maxLength="20" value="{{ $user->last_name }}" placeholder="Last name"
                                                required autocomplete="last_name" autofocus>

                                            @error('name')
                                                <span class="text-danger text-sm" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" readonly
                                                value="@if ($user->user_type === config('constants.ADMIN_TYPE')) Admin @elseif($user->user_type === config('constants.USER_TYPE')) User @else Promoter @endif"
                                                placeholder="User Type" required autocomplete="user_type" autofocus>

                                        </div>
                                        <div class="input-group mb-3">
                                            <input id="email" type="email" class="form-control" name="email"
                                                value="{{ $user->email }}" placeholder="Email" required readonly
                                                autocomplete="email">

                                            @error('email')
                                                <span class="text-danger text-sm" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="input-group mb-3">
                                            <input id="phone_no" type="phone_no" class="form-control" name="phone_no"
                                                value="{{ $user->phone_no }}" placeholder="Phone No"
                                                autocomplete="phone_no">

                                            @error('phone_no')
                                                <span class="text-danger text-sm" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="user_profile" class="custom-file-input"
                                                        id="fileUpload" accept="image/*">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                @error('user_profile')
                                                    <span class="text-danger text-sm" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <br>
                                            <div id="image-holder"> </div>
                                        </div>
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="">
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    Update Profile
                                                </button>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    @if (Auth::user()->user_type != config('constants.ADMIN_TYPE'))
                        <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                            <div class="card profile-outline">
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center">Please do this for payment </h3>
                                    <hr>
                                    @if (!isset($stripe_account))
                                        <div class="tab-content text-center">
                                            <a class="btn btn-primary" href="{{ url('admin/stripe/account') }}"> Create
                                                Stripe Account</a>
                                        </div>
                                    @else
                                        <div class="tab-content text-center">
                                            <a class="btn btn-primary" href="javascript:void(0)"> Stripe Account
                                                Connected</a>
                                        </div>
                                    @endif
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    @endif
                    <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                        <div class="card profile-outline">
                            <div class="card-body box-profile">
                                <h3 class="profile-username text-center">Total Payouts ($) </h3>
                                <hr>
                                <h4 class="event_detail_form text-center">
                                    {{ $promoter_total_payout['total_payout'] ?? '0.00' }}
                                </h4>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                        <div class="card profile-outline">
                            <div class="card-body box-profile">
                                <h3 class="profile-username text-center">Referral Count By Event </h3>
                                <hr>
                                <table class="table table-bordered table-striped ">
                                    <thead>
                                        <tr>
                                            <th>Event Title</th>
                                            <th>Referral Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($referral_counts as $key => $referral_count)
                                            <tr>
                                                <td>
                                                    <a class="anchor_color"
                                                        href="{{ url('event/detail/' . $referral_count->event_id) }}">
                                                        {{ Str::length($referral_count->event->event_title) > 20 ? substr($referral_count->event->event_title, 0, 20) . '...' : $referral_count->event->event_title }}
                                                    </a>
                                                </td>
                                                <td class="anchor_color">{{ $referral_count->total }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td>
                                                    N/A
                                                </td>
                                                <td>0</td>
                                            </tr>
                                        @endforelse


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                        <div class="card profile-outline">
                            <div class="card-body box-profile">
                                <h3 class="profile-username text-center">Total Event Booked</h3>
                                <hr>
                                <table class="table table-bordered table-striped ">
                                    <thead>
                                        <tr>
                                            <th>Event Title</th>
                                            <th>Booked Event</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($total_booked_events as $key => $total_booked_event)
                                            <tr>
                                                <td>
                                                    <a class="anchor_color"
                                                        href="{{ url('event/detail/' . $total_booked_event->event_id) }}">
                                                        {{ Str::length($total_booked_event->event->event_title) > 20 ? substr($total_booked_event->event->event_title, 0, 20) . '...' : $total_booked_event->event->event_title }}
                                                    </a>
                                                </td>
                                                <td class="anchor_color">{{ $total_booked_event->total }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td>
                                                    N/A
                                                </td>
                                                <td>0</td>
                                            </tr>
                                        @endforelse


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                        <div class="card profile-outline">
                            <div class="card-body box-profile">
                                <h3 class="profile-username text-center">Total Event Booked Amount</h3>
                                <hr>
                                <table class="table table-bordered table-striped ">
                                    <thead>
                                        <tr>
                                            <th>Event Title</th>
                                            <th>Booked Amount ($)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($total_refferal_amounts as $key => $total_refferal_amount)
                                            <tr>
                                                <td>
                                                    <a class="anchor_color"
                                                        href="{{ url('event/detail/' . $total_refferal_amount->event_id) }}">
                                                        {{ Str::length($total_refferal_amount->event->event_title) > 20 ? substr($total_refferal_amount->event->event_title, 0, 20) . '...' : $total_refferal_amount->event->event_title }}
                                                    </a>
                                                </td>
                                                <td class="anchor_color">
                                                    {{ $total_refferal_amount->total_price ?? '0.00' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td>
                                                    N/A
                                                </td>
                                                <td>0.00</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#my_events"
                                            data-toggle="tab">My Events</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#order" data-toggle="tab">Orders for My Events</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#change-password"
                                            data-toggle="tab">Change Password</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="my_events">
                                        <table id="data-table" class="table table-bordered table-striped ">
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
                                                    <th>Is Live</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($events) > 0)
                                                    @foreach ($events as $key => $event)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ Str::length($event->event_title) > 30 ? substr($event->event_title, 0, 30) . '...' : $event->event_title }}
                                                            </td>
                                                            <td>{{ $event->category->name }}</td>
                                                            <td>{{ $event->organizer }}</td>
                                                            <td>{{ $event->venue }}</td>
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
                                                                <a href="{{ url('admin/change/event/status/' . $event->id . '/' . $val) }}"
                                                                    onclick="return confirm('{{ $msg }}')">
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
                                                                <a href="{{ url('admin/event/detail/' . Crypt::encrypt($event->id)) }}"
                                                                    class="badge badge-secondary">
                                                                    <i class="fa-solid fa-eye"></i></a>
                                                                <a href="{{ url('admin/edit/event/' . Crypt::encrypt($event->id)) }}"
                                                                    class="badge badge-warning"><i
                                                                        class="fa-solid fa-pen"></i></a>
                                                                <a href="{{ url('admin/delete/event/' . Crypt::encrypt($event->id)) }}"
                                                                    class="badge badge-danger"
                                                                    onclick="return confirm('Are you sure, you want to delete this event?')">
                                                                    <i class="fa-solid fa-trash-can"></i></a>
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
                                    <!-- /.tab-pane -->

                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="order">
                                        <table id="data-table" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>S.No.</th>
                                                    <th>User Name</th>
                                                    <th>Image</th>
                                                    <th> Event Title</th>
                                                    <th> Ticket Title</th>
                                                    <th> Ticket Type</th>
                                                    <th> Quantity</th>
                                                    <th>Price($)</th>
                                                    <th>Total Price($)</th>
                                                    <th>Order Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($order_data) > 0)
                                                    @foreach ($order_data as $key => $item)
                                                        @php
                                                            $order_details = json_decode($item->order_details);
                                                        @endphp
                                                        <tr class="sm-thrd">
                                                            <td class="summ-tds">{{ $key + 1 }}</td>
                                                            <td class="summ-tds">{{ $item->user->full_name }}</td>
                                                            <td class="summary-th">
                                                                <a
                                                                    href="{{ url('event/detail/' . $order_details->event_id) }}"><img
                                                                        src="{{ asset('event-images/' . $order_details->event_image) }}"
                                                                        alt="" height="60" width="100"
                                                                        srcset=""></a>
                                                            </td>
                                                            <td class="summ-tds">{{ $order_details->event_title }}</td>
                                                            <td class="summ-tds">{{ $order_details->ticket_title }}</td>
                                                            <td class="summ-tds">{{ $order_details->ticket_type }}</td>
                                                            <td class="summ-tds">{{ $order_details->ticket_purchase_qty }}
                                                            </td>
                                                            <td class="summ-tds">{{ $order_details->ticket_price }}</td>
                                                            <td class="summ-tds"
                                                                >
                                                                {{ $item->total_price }}</td>
                                                            <td class="summ-tds"
                                                                >
                                                                {{ $item->order_placed_date }}</td>
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
                                    <div class="tab-pane" id="change-password">
                                        <h2 class="order-here">Change Password</h2>
                                        <div class="row justify-content-center">
                                            <div class="col-xl-5 col-lg-8 col-md-8 col-12 justify-content-center">
                                                <form method="POST" action="{{ url('admin/change/password/') }}">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                    <div class="input-group mb-3">
                                                        <label class="create_event_head">Old Password</label>
                                                        <input id="old_password" type="password"
                                                            class="form-control hide-show-password" name="old_password"
                                                            value="" placeholder="Old Password" required
                                                            autocomplete="old_password" autofocus>
                                                        <a href="javascript:void(0)"
                                                            class="show_password show_password_style" data-value="0">
                                                            <i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        @error('old_password')
                                                            <span class="text-danger text-sm" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <label class="create_event_head">New Password</label>
                                                        <input id="password" type="password"
                                                            class="form-control hide-show-password" name="password"
                                                            value="" placeholder="New Password" required
                                                            autocomplete="password" autofocus>
                                                        <a href="javascript:void(0)"
                                                            class="show_password show_password_style" data-value="0">
                                                            <i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        @error('password')
                                                            <span class="text-danger text-sm" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <label class="create_event_head">Confirm Password</label>
                                                        <input id="password_confirmation" type="password"
                                                            class="form-control hide-show-password"
                                                            name="password_confirmation" value=""
                                                            placeholder="Confirm Password" required
                                                            autocomplete="password_confirmation" autofocus>

                                                        <a href="javascript:void(0)"
                                                            class="show_password show_password_style" data-value="0">
                                                            <i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        @error('password_confirmation')
                                                            <span class="text-danger text-sm" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <hr class="mt-0">

                                                    <button type="submit"
                                                        class="btn save_event_btn btn-secondary btn-block">
                                                        Change Password
                                                    </button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('script')
    <script src="{{ asset('customjs/profile.js?v=' . time()) }}"></script>
@endsection
