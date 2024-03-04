@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Manage Banner Images')

@section('content')
    <div class="content-wrapper" style="min-height: 1302.12px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Manage Banner Images</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Banner Images</li>
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
                                <table id="data-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($banner_images) > 0)
                                            @foreach ($banner_images as $key => $banner_image)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td> <img src="{{ $banner_image->banner_image }}" alt="" height="100" width="100"></td>
                                                    <td>{!! $banner_image->description !!} </td>
                                                    <td>
                                                        @php
                                                            if ($banner_image->status === 1) {
                                                                $val = 0;
                                                                $status = 'checked';
                                                                $msg = 'Are you sure, you want to deactivate this banner?';
                                                            } else {
                                                                $val = 1;
                                                                $status = '';
                                                                $msg = 'Are you sure, you want to activate this banner?';
                                                            }
                                                        @endphp

                                                        <a href="javascript:void(0)" data-delete_url="{{ url('admin/change/banner/status/' . Crypt::encrypt($banner_image->id) . '/' . $val) }}" 
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
                                                        <a href="{{ url('admin/edit/banner/' . Crypt::encrypt($banner_image->id)) }}"
                                                            title="Edit banner" class="badge badge-warning"><i
                                                                class="fa-solid fa-pen"></i></a>
                                                        <a href="javascript:void(0)"
                                                            title="Delete banner" class="badge badge-danger delete-data"
                                                            data-delete_msg="Are you sure, you want to delete this banner?"
                                                            data-delete_url="{{ url('admin/delete/banner/' . Crypt::encrypt($banner_image->id)) }}" >
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">{{ trans('messages.record_not_found') }}</td>
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
