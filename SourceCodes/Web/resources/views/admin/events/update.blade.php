@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Update Event')

@section('style')

@endsection

@section('content')

    <div class="content-wrapper" style="min-height: 1302.12px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
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

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- general form elements disabled -->
                <div class="row justify-content-center">
                    <div class="col-md-12 col-12">

                        <div class="row justify-content-center">
                            <div class="col-12">
                                <form action="{{ url('admin/update/event/' . Crypt::encrypt($event->id)) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="create_event_cards card p-3">
                                                <h4 class="event_detail_form">Event Details</h4>
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-12 col-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label class="create_event_head"> Title <span class="text-danger">*</span></label>
                                                            <input type="text" name="event_title" id="event_title"
                                                                maxlength="100" required class="form-control"
                                                                placeholder="Event Title" value="{{ $event->event_title }}">
                                                            @error('event_title')
                                                                <span class="text-danger text-sm" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-12 col-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label class="create_event_head">Choose Category <span class="text-danger">*</span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;"
                                                                name="category_id" required id="category_id">
                                                                <option value="">Choose Category</option>
                                                                @if (count($categories) > 0)
                                                                    @foreach ($categories as $category)
                                                                        <option
                                                                            {{ $event->category_id === $category->id ? 'selected' : '' }}
                                                                            value="{{ $category->id }}">
                                                                            {{ $category->name }}
                                                                        </option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">No Category Found</option>
                                                                @endif
                                                            </select>
                                                            @error('category_id')
                                                                <span class="text-danger text-sm" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-12 col-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label class="create_event_head"> Organizer <span class="text-danger">*</span></label>
                                                            <input type="text" name="organizer" id="organizer"
                                                                maxlength="50" class="form-control" required
                                                                placeholder="Organizer" value="{{ $event->organizer }}">
                                                            @error('organizer')
                                                                <span class="text-danger text-sm" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                                <h4 class="event_detail_form">Date & Time</h4>
                                                <div class="row my-md-2">
                                                    <div class="col-md-6 col-12 mb-md-2">
                                                        <div class="input-group">
                                                            <label class="create_event_head"> Start Date <span class="text-danger">*</span></label>
                                                            <i class="fa fa-calendar start_end_icon" aria-hidden="true"></i>
                                                            <input type="text" name="start_date" id="startDate" readonly
                                                                class="form-control" required
                                                                value="{{ $event->start_date }}"
                                                                placeholder="Start date" />
                                                            @error('start_date')
                                                                <span class="text-danger text-sm" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12 mb-md-2">
                                                        <div class="input-group">
                                                            <label class="create_event_head"> End Date <span class="text-danger">*</span></label>
                                                            <i class="fa fa-calendar start_end_icon" aria-hidden="true"></i>
                                                            <input type="text" name="end_date" id="endDate" readonly
                                                                class="form-control" required
                                                                value="{{ $event->end_date }}" placeholder="End date" />
                                                            @error('end_date')
                                                                <span class="text-danger text-sm" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12 mb-md-2">
                                                        <div class="input-group">
                                                            <label class="create_event_head">Start Time <span class="text-danger">*</span></label>
                                                            <input type="time" name="start_time" id="start_time"
                                                                class="form-control" required
                                                                value="{{ $event->start_time }}"
                                                                placeholder="Start Time" />

                                                            @error('start_time')
                                                                <span class="text-danger text-sm" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div></div>
                                                    </div>
                                                    <div class="col-md-6 col-12 mb-md-2">
                                                        <div class="input-group">
                                                            <label class="create_event_head"> End Time <span class="text-danger">*</span></label>
                                                            <input type="time" name="end_time" id="end_time"
                                                                class="form-control" required
                                                                value="{{ $event->end_time }}" placeholder="End Time" />

                                                            @error('end_time')
                                                                <span class="text-danger text-sm" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div> <!-- row -->


                                                <hr />
                                                <h4 class="event_detail_form">Event Image</h4>
                                                <!-- input states -->
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <label class="create_event_head"> File Upload</label>
                                                        <div class="custom-file">
                                                            <input type="file" name="image"
                                                                class="custom-file-input" id="fileUpload"
                                                                accept="image/*">
                                                            <label class="custom-file-label mb-md-0"
                                                                for="exampleInputFile">Choose file</label>
                                                        </div>
                                                        @error('image')
                                                            <span class="text-danger text-sm" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <br>
                                                    <div id="image-holder">
                                                        @if ($event->image)
                                                            <img src="{{ $event->image }}"
                                                                alt="">
                                                        @endif
                                                    </div>
                                                </div>
                                             
                                            </div> <!-- create card div -->
                                        </div><!-- col-md-6 -->

                                        <div class="col-md-6">
                                            <div class="create_event_cards card p-3">
                                                <h4 class="event_detail_form">Location</h4>
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-6 col-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label class="create_event_head"> Venue <span class="text-danger">*</span></label>
                                                            <input type="text" name="venue" id="venue" required
                                                                class="form-control" placeholder="Venue" maxlength="200"
                                                                value="{{ $event->venue }}">
                                                            @error('venue')
                                                                <span class="text-danger text-sm" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <div class="col-xl-3 col-lg-6 col-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label class="create_event_head"> Address <span class="text-danger">*</span></label>
                                                            <input type="text" name="address" id="address"
                                                                class="form-control" required placeholder="Address"
                                                                value="{{ $event->address }}">
                                                            @error('address')
                                                                <span class="text-danger text-sm" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label class="create_event_head"> City <span class="text-danger">*</span></label>
                                                            <input type="text" name="city" id="city"
                                                                onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9_-]/g, ' ')"
                                                                class="form-control" required maxlength="20"
                                                                placeholder="City" value="{{ $event->city }}">
                                                            @error('city')
                                                                <span class="text-danger text-sm" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-12">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label class="create_event_head"> Zip Code <span class="text-danger">*</span></label>
                                                            <input type="text" name="zipcode" id="zipcode"
                                                                class="form-control zipcode" required
                                                                placeholder="Zip Code" value="{{ $event->zipcode }}">
                                                            @error('zipcode')
                                                                <span class="text-danger text-sm" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr />

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h4 class="event_detail_form">Event Description <span class="text-danger">*</span></h4>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <!-- textarea -->
                                                                <div class="form-group">
                                                                    <label class="create_event_head"> Description</label>
                                                                    <textarea name="description" class="form-control" rows="5" id="description" placeholder="Description">{{ $event->description }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                   
                                                   <h4 class="event_detail_form">Venue Layout Image</h4>
                                                   <!-- input states -->
                                                   <div class="form-group">
                                                       <div class="input-group">
                                                           <label class="create_event_head"> File Upload</label>
                                                           <div class="custom-file">
                                                               <input type="file" name="venue_image"
                                                                   class="custom-file-input" id="fileUpload2"
                                                                   accept="image/*">
                                                               <label class="custom-file-label mb-md-0"
                                                                   for="exampleInputFile">Choose file</label>
                                                           </div>
                                                           @error('venue_image')
                                                               <span class="text-danger text-sm" role="alert">
                                                                   <strong>{{ $message }}</strong>
                                                               </span>
                                                           @enderror
                                                       </div>
   
                                                       <br>
                                                       <div id="image-holder2">
                                                           @if ($event->venue_image)
                                                               <img src="{{ $event->venue_image }}"
                                                                   alt="">
                                                           @endif
                                                       </div>
                                                   </div>
                                                <hr class="mt-0">
                                                <div class="crd_foter">
                                                    <button type="submit"
                                                        class="btn save_event_btn btn-secondary float-right">Update
                                                        Event</button>
                                                    <a href="{{ url('admin/manage/events') }}"><button type="button" class="btn btn-default float-right mr-2">Cancel</button></a>
                                                </div>

                                            </div>
                                            <!-- create card div -->
                                        </div>
                                        <!-- col-6 div -->
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- row -->
                    </div>
                    <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection

@section('script')
    <script src="{{ asset('customjs/adminjs/event/create.js?v=' . time()) }}"></script>
@endsection
