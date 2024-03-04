@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Subscribed User List')

@section('content')
    <div class="content-wrapper" style="min-height: 1302.12px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Subscribed User Lists</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Subscribed User</li>
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
                                            <th>User Email</th>
                                            @if (count($subscribe_users) > 0)
                                            <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($subscribe_users) > 0)
                                            @foreach ($subscribe_users as $key => $subscribe_user)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $subscribe_user->email }}</td>
                                                    <td><a href="javascript:void(0)" class="badge badge-danger delete-data" title="Delete Event" 
                                                        data-delete_msg="Are you sure, you want to delete this subscribed user?"
                                                        data-delete_url="{{ url('admin/deleteSubcribedUser/' . Crypt::encrypt($subscribe_user->id)) }}" >
                                                        <i class="fa-solid fa-trash-can"></i></a></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2" class="text-center">{{ trans('messages.record_not_found') }}</td>
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
