@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Create Ticket')

@section('style')

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Create Ticket</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Event</li>
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
                                    <div class="col-xl-8 col-lg-10 col-md-10 col-12">
                                        <div class="panel panel-default">

                                            <div class="panel-body">
                                                <form action="{{ url('admin/save/ticket') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" id="end_date" value="">
                                                    <input type="hidden" id="end_time" value="">
                                                    <div class="form-group">
                                                        <h4 class="event_detail_form">Event</h4>
                                                        <label class="create_event_head">Choose Event <span class="text-danger">*</span></label>
                                                        <select class="form-control select2bs4 select_event"
                                                            style="width: 100%;" name="event_id" required>
                                                            <option value="">Choose Event</option>
                                                            @if (count($events) > 0)
                                                                @foreach ($events as $key => $event)
                                                                    <option value="{{ $event->id }}"
                                                                        {{ ($event_id ?? old('event_id')) == $event->id ? 'selected' : '' }}
                                                                        data-end_date="{{ $event->end_date }}"
                                                                        data-end_time="{{ $event->end_time }}">
                                                                        {{ $event->event_title }} </option>
                                                                @endforeach
                                                            @else
                                                                <option value="">No Event Found</option>
                                                            @endif
                                                        </select>
                                                        @error('event_id')
                                                            <span class="text-danger text-sm" role="alert">
                                                                <strong>The ticket type field is required</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <hr>
                                                    <div class="row mb-3">
                                                        <div class="col-10">
                                                            <h4 class="event_detail_form">Ticket Details</h4>
                                                        </div>
                                                        <div class="input-group-btn col-2">
                                                            <button class="btn btn-secondary float-right" type="button"
                                                                onclick="additional_fields();"> <i
                                                                    class="fa-solid fa-circle-plus"></i> </button>
                                                        </div>
                                                    </div>
                                                    <div class="border border-5 p-3">
                                                        <label class="create_event_head">Fill up the details</label>
                                                        <div class="row">
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label class="create_event_head">Ticket Title <span class="text-danger">*</span></label>
                                                                    <input type="text" name="ticket_title[]"
                                                                        class="form-control" maxlength="150"
                                                                        placeholder="Ticket Title" required
                                                                        value="{{ old('ticket_title.0') }}">
                                                                    @error('ticket_title.*')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>The ticket title field is required</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label class="create_event_head">Ticket Type <span class="text-danger">*</span></label>
                                                                    <select class="form-control select2bs4 choose-type"
                                                                        data-count="0" style="width: 100%;"
                                                                        name="ticket_type[]" required>
                                                                        <option value="">Choose ticket type</option>
                                                                        <option value="Paid" {{ old('ticket_type.0') === 'Paid' ? 'selected' : '' }}>Paid</option>
                                                                        <option value="Free" {{ old('ticket_type.0') === 'Free' ? 'selected' : '' }}>Free</option>
                                                                    </select>
                                                                    @error('ticket_type.*')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>The ticket type field is required</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label class="create_event_head">Ticket Quantity <span class="text-danger">*</span></label>
                                                                    <input type="number" name="total_qty[]"
                                                                        class="form-control quantity" min="1"
                                                                        max="999999999" placeholder="Total Quantity"
                                                                        required value="{{ old('total_qty.0') }}">
                                                                    @error('total_qty.*')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>The total qty field is required</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12"
                                                                id="price_status0" style="display:none;">
                                                                <div class="form-group">
                                                                    <label class="create_event_head">Ticket Price <span class="text-danger">*</span></label>
                                                                    <input type="number" name="ticket_price[]"
                                                                        step="0.01" min="0" max="999999999"
                                                                        class="form-control numbersOnly"
                                                                        placeholder="Price per unit" id="validation0"
                                                                        value="{{ old('ticket_price.0') }}">
                                                                    @error('ticket_price.0')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>The ticket price field is required</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <label class="create_event_head">Date & Time</label>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label class="create_event_head"> End Date <span class="text-danger">*</span></label>
                                                                    <i class="fa fa-calendar end_ticket"
                                                                        aria-hidden="true"></i>
                                                                    <input type="text" name="end_date[]"
                                                                        data-count="0" required
                                                                        class="form-control endDate end-date-0" readonly
                                                                        value="{{ old('end_date.0') }}"
                                                                        placeholder="End date" />
                                                                    @error('end_date.*')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>The end date field is required</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <label class="create_event_head"> End Time <span class="text-danger">*</span></label>
                                                                    <input type="time" name="end_time[]"
                                                                        data-count="0" class="form-control end-time-0"
                                                                        value="{{ old('end_time.0') }}" required
                                                                        placeholder="End date" />
                                                                    @error('end_time.*')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>The end time field is required</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div id="additional_fields" class=""> </div>

                                                    <div class="crd_foter mt-3">
                                                        <button type="submit"
                                                            class="btn save_event_btn btn-secondary float-right">Save
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
