@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Update Ticket')

@section('style')

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Update Event</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Update Event</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-8">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <form action="{{ url('admin/update/ticket/' . Crypt::encrypt($ticket->id)) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                    <div class="form-group">
                                                        <h4 class="event_detail_form">Event</h4>
                                                        <input type="hidden" name="event_id" value="{{ $ticket->event_id }}">
                                                        <label class="create_event_head">Choose Event <span class="text-danger">*</span></label>
                                                        <select class="form-control select2bs4" style="width: 100%;"
                                                            name="" required disabled>
                                                            <option value="">Choose Event</option>
                                                            @if (count($events) > 0)
                                                                @foreach ($events as $key => $event)
                                                                    <option value="{{ $key }}"
                                                                        @if ($ticket->event_id == $key) selected @endif>
                                                                        {{ $event }}</option>
                                                                @endforeach
                                                            @else
                                                                <option value="">No Event Found</option>
                                                            @endif
                                                        </select>
                                                        @error('event_id')
                                                            <span class="text-danger text-sm" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <hr>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-6">
                                                            <h4 class="event_detail_form">Ticket Details</h4>
                                                        </div>

                                                    </div>
                                                    <div class="border border-5 p-3">
                                                        <label class="create_event_head">Fill up the details</label>
                                                        <div class="row">
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label class="create_event_head">Ticket Title <span class="text-danger">*</span></label>
                                                                    <input type="text" name="ticket_title"
                                                                        maxlength="150" class="form-control"
                                                                        placeholder="Ticket Title" required
                                                                        value="{{ $ticket->ticket_title }}">
                                                                    @error('ticket_title')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label class="create_event_head">Ticket Type <span class="text-danger">*</span></label>
                                                                    <select class="form-control select2bs4 choose-type"
                                                                        data-count="0" style="width: 100%;"
                                                                        name="ticket_type" required>
                                                                        <option value="">Choose ticket type</option>
                                                                        <option value="Paid"
                                                                            @if ($ticket->ticket_type === 'Paid') selected @endif>
                                                                            Paid</option>
                                                                        <option value="Free"
                                                                            @if ($ticket->ticket_type === 'Free') selected @endif>
                                                                            Free</option>
                                                                    </select>
                                                                    @error('ticket_type')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label class="create_event_head">Ticket Quantity <span class="text-danger">*</span></label>
                                                                    <input type="number" name="total_qty"
                                                                        class="form-control quantity" min="0"
                                                                        max="999999999" placeholder="Total Quantity"
                                                                        required value="{{ $ticket->quantity }}">
                                                                    @error('total_qty')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12"
                                                                id="price_status0"
                                                                @if ($ticket->ticket_type === 'Free') style="display:none;" @endif>
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label class="create_event_head">Ticket Price <span class="text-danger">*</span></label>
                                                                    <input type="number" name="ticket_price"
                                                                        class="form-control" min="0" max="999999999"
                                                                        step="0.01" placeholder="Ticket Price"
                                                                        id="validation0" value="{{ $ticket->price }}">
                                                                    @error('ticket_price')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <h6>Date & Time</h6> -->
                                                        <label class="create_event_head">Date & Time</label>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label class="create_event_head"> End Date <span class="text-danger">*</span></label>
                                                                    <i class="fa fa-calendar end_ticket"
                                                                        aria-hidden="true"></i>
                                                                    <input type="text" name="end_date" data-count="0"
                                                                        class="form-control endDate end-date-0" readonly
                                                                        value="{{ $ticket->end_date }}" required
                                                                        placeholder="End date" />
                                                                    @error('end_date')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <!-- text input -->
                                                                <div class="input-group">
                                                                    <label class="create_event_head"> End Time <span class="text-danger">*</span></label>
                                                                    <input type="time" name="end_time" data-count="0"
                                                                        class="form-control end-time-0"
                                                                        value="{{ $ticket->end_time }}" required
                                                                        placeholder="End date" />
                                                                    @error('end_time')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div id="additional_fields" class=""> </div>

                                                    <div class="card-footer">
                                                        <button type="submit"
                                                            class="btn btn-secondary float-right">Update
                                                            Ticket</button>
                                                        <a href="{{ url('admin/manage/tickets') }}"><button type="button" class="btn btn-default float-right mr-2">Cancel</button></a>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('script')
    <script src="{{ asset('customjs/adminjs/ticket/create.js?v=' . time()) }}"></script>
@endsection
