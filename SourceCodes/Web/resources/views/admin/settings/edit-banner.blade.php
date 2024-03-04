@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Edit Banner')

@section('style')

@endsection

@section('content')

    <div class="content-wrapper" style="min-height: 1302.12px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Edit Banner</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Banner</li>
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
                                <form action="{{ url('admin/update/banner/' . Crypt::encrypt($banner_image->id)) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card p-3">
                                                <div class="row justify-content-center">
                                                    <div class="col-xl-4 col-lg-12 col-12">
                                                        <!-- text input -->
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <!-- textarea -->
                                                                <div class="form-group">
                                                                    <label class="create_event_head"> Description <span class="text-danger">*</span></label>
                                                                    <textarea name="description" class="form-control description" required id="description" placeholder="Description">{!! $banner_image->description !!}</textarea>
                                                                    @error('description')
                                                                        <span class="text-danger text-sm" role="alert">
                                                                            <strong>This field is required</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <label class="create_event_head"> File Upload</label>
                                                                <div class="custom-file">
                                                                    <input type="file" name="banner_image"
                                                                        onchange="gallery_photo_add(this);"
                                                                        class="custom-file-input" id="gallery-photo-add"
                                                                        accept="image/*">
                                                                    <label class="custom-file-label mb-md-0"
                                                                        for="exampleInputFile">Choose file</label>
                                                                </div>
                                                                @error('banner_image')
                                                                    <span class="text-danger text-sm" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <div class="size_validation1 text-danger">  </div>
                                                            </div>

                                                            <br>
                                                            <div class="gallery">
                                                                @if ($banner_image->banner_image)
                                                                    <img style="height:200px; width:200px"
                                                                        src="{{ asset('banner-images/' . $banner_image->banner_image) }}" />
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr class="mt-0">
                                                    <div class="crd_foter">
                                                        <button type="submit"
                                                            class="btn save_event_btn btn-secondary float-right">Update
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
        </section>
        <!-- /.content -->
    </div>

@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
    <script src="{{ asset('customjs/adminjs/settings/edit.js?v=' . time()) }}"></script>
@endsection
