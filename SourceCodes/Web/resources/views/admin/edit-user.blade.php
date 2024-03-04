@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Update User')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        
                        <h1>Update @if ($user->user_type === config('constants.ADMIN_TYPE'))
                                Admin
                            @elseif($user->user_type === config('constants.USER_TYPE'))
                                User
                            @else
                                Promoter
                            @endif
                        </h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Update @if ($user->user_type === config('constants.ADMIN_TYPE'))
                                    Admin
                                @elseif($user->user_type === config('constants.USER_TYPE'))
                                    User
                                @else
                                    Promoter
                                @endif
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ url('admin/update/user/' . Crypt::encrypt($user->id)) }}">
                                    @method('put')
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-xl-4 col-lg-10 col-md-10 col-12">
                                            <label class="create_event_head">First Name <span class="text-danger">*</span></label>
                                            <div class="input-group mb-3">
                                                <input id="first_name" type="text" class="form-control" name="first_name"
                                                    value="{{ $user->first_name }}" placeholder="First name" required
                                                    autocomplete="first_name" autofocus>
                                                @error('first_name')
                                                    <span class="text-danger text-sm" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="create_event_head">Last Name <span class="text-danger">*</span></label>
                                                <input id="last_name" type="text" class="form-control" name="last_name"
                                                    value="{{ $user->last_name }}" placeholder="Last name" required
                                                    autocomplete="last_name" autofocus>
                                                @error('last_name')
                                                    <span class="text-danger text-sm" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="create_event_head">User Type <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" readonly
                                                    value="@if ($user->user_type === config('constants.ADMIN_TYPE')) Admin @elseif($user->user_type === config('constants.USER_TYPE')) User @else Promoter @endif"
                                                    placeholder="User Type" required autocomplete="user_type" autofocus>

                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="create_event_head">Email <span class="text-danger">*</span></label>
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
                                                <label class="create_event_head">Phone Number <span class="text-danger">*</span></label>
                                                <input id="phone_no" type="phone_no" class="form-control" name="phone_no"
                                                    value="{{ $user->phone_no }}" required placeholder="(123) 456-7890"
                                                    autocomplete="phone_no">
                                                @error('phone_no')
                                                    <span class="text-danger text-sm" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="create_event_head">Company Name</label>
                                                <input id="company_name" type="company_name" class="form-control"
                                                    name="company_name" value="{{ $user->company_name }}"
                                                    placeholder="Company Name" autocomplete="company_name">
                                            </div>

                                            <div class="row">
                                                <!-- /.col -->
                                                <div class="col-12">
                                                    <div class="crd_foter">
                                                        <button type="submit"
                                                            class="btn save_event_btn btn-secondary float-right">
                                                            Update @if ($user->user_type === config('constants.ADMIN_TYPE'))
                                                                Admin
                                                            @elseif($user->user_type === config('constants.USER_TYPE'))
                                                                User
                                                            @else
                                                                Promoter
                                                            @endif
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
