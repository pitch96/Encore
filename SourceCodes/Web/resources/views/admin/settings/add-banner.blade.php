@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Add Banner')

@section('style')

@endsection

@section('content')

    <div class="content-wrapper" style="min-height: 1302.12px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Add Banner</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Banner</li>
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
                                <form action="{{ url('admin/save/banner') }}" method="post" enctype="multipart/form-data" >
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card p-3">
                                                <div class="row">
                                                    <div class="col-xl-10 col-lg-12 col-12">
                                                        <!-- text input -->
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <!-- textarea -->
                                                                <div class="form-group edt">
                                                                    <label class="create_event_head"> Description <span class="text-danger">*</span></label>
                                                                    <textarea name="description[]" class="form-control description" required placeholder="Description">{{ old('description.*') }}</textarea>
                                                                    @error('description.*')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>This field is required</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>

                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <label class="create_event_head"> File Upload <span class="text-danger">*</span></label>
                                                                        <div class="custom-file">
                                                                            <input type="file" name="banner_image[]"
                                                                                onchange="gallery_photo_add(this);"
                                                                                class="custom-file-input" data-count="1"
                                                                                accept="image/*" required>
                                                                            <label class="custom-file-label mb-md-0"
                                                                                for="exampleInputFile">Choose file</label>
                                                                        </div>
                                                                        @error('banner_image.*')
                                                                            <span class="text-danger text-sm" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                        <div class="size_validation1 text-danger">  </div>
                                                                    </div>

                                                                    <br>
                                                                    <div class="gallery1"> </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2 pl-3">
                                                                <div class="input-group-btn col-2">
                                                                    <button class="btn btn-secondary float-right"
                                                                        type="button" style="margin-top: 34px;"
                                                                        onclick="additional_fields();"> <i
                                                                            class="fa-solid fa-circle-plus"></i> </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="additional_fields" class="row"> </div>
                                                    </div>
                                                    <hr class="mt-0">
                                                    <div class="crd_foter">
                                                        <button type="submit"
                                                            class="btn save_event_btn btn-secondary float-right">Save
                                                            Banner</button>
                                                        <a href="{{ url('admin/banner/images') }}"><button type="button"
                                                                class="btn btn-default float-right mr-2">Cancel</button></a>
                                                    </div>
                                                </div>
                                                <!-- input states -->
                                            </div> <!-- create card div -->
                                        </div><!-- col-md-6 -->

                                    </div>
                                </form>
                            </div>
                        </div><!-- row -->
                    </div><!-- /.container-fluid -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
    <script src="{{ asset('customjs/adminjs/settings/create.js?v=' . time()) }}"></script>
@endsection
