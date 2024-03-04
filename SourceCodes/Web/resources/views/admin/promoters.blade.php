@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Promoters List')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Manage Promoters</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Promoters</li>
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
                            <div class="card-body">
                                <table id="data-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone No</th>
                                            <th>Company Name</th>
                                            <th>Type</th>
                                            <th>Actions</th>
                                            <th>Verify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($users) > 0)
                                            @foreach ($users as $key => $user)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone_no }}</td>
                                                    <td>{{ $user->company_name }}</td>
                                                    <td>Promoter</td>
                                                    <td>
                                                        <a href="{{ url('admin/edit/user/' . Crypt::encrypt($user->id)) }}"
                                                            class="badge badge-warning"><i class="fa-solid fa-pen"></i></a>
                                                        <a href="javascript:void(0)" data-delete_msg="Are you sure, you want to delete this promoter?"
                                                            class="badge badge-danger delete-data" data-delete_url="{{ url('admin/delete/user/' . Crypt::encrypt($user->id)) }}" >
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @php
                                                            if ($user->isVerified === 1) {
                                                                $val = 0;
                                                                $status = 'checked';
                                                                $msg = 'Are you sure, you want to mark this promoter as non-verified?';
                                                            } else {
                                                                $val = 1;
                                                                $status = '';
                                                                $msg = 'Are you sure, you want to verify this promoter?';
                                                            }
                                                        @endphp
                                                        <a href="javascript:void(0)"
                                                            data-delete_url="{{ url('/admin/verify/promoter/' . Crypt::encrypt($user->id) . '/' . $val) }}"
                                                            data-delete_msg="{{ $msg }}"
                                                            title="Change promotion verification status" class="change-verify-status">
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
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">{{ trans('messages.record_not_found') }}</td>
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
