@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Update Charge')

@section('content')

    <div class="content-wrapper" style="min-height: 1302.12px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Update Promotional Event Charge</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Update Promotion Charge</li>
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
                                <form method="POST"
                                    action="{{ url('admin/update/charge/' . Crypt::encrypt($response->id)) }}">
                                    @csrf
                                    @method('put')
                                    <div class="row justify-content-center">
                                        <div class="col-xl-4 col-lg-8 col-md-8 col-12">
                                            <div class="input-group mb-3">
                                                <label class="create_event_head">Set Promotional Price<span class="text-danger">*</span></label>
                                                <input id="charge" type="number" class="form-control" maxlength="100"
                                                    name="charge" value="{{ $response?$response->charge:0 }}" placeholder="Price" required
                                                    autocomplete="name" autofocus onkeyup="alertMessage()">
                                                    <span id="errorMsg" style="display:none; color:red;">Price should be more than 0.</span>
                                                @error('charge')
                                                    <span class="text-danger text-sm" role="alert">
                                                        <strong id="charge-alert">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- /.col -->
                                                    <div class="crd_foter">
                                                        <button type="submit"
                                                            class="btn save_event_btn btn-secondary float-right">
                                                            Update Price
                                                        </button>
                                                        <a href="{{ url('admin/dashboard') }}"><button type="button" id="submit-charge-btn" class="btn btn-default float-right mr-2">Cancel</button></a>     
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

<script>
function alertMessage(){
        let x = document.getElementById('charge').value;
        if(x && x < 1){
            $('#errorMsg').show();
            $('#submit-charge-btn').disabled();
        }else{
            $('#errorMsg').hide();
        }
    }
</script>
