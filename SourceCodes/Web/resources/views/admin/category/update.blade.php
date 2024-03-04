@extends('layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Update Category')

@section('content')

    <div class="content-wrapper" style="min-height: 1302.12px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 d-flex justify-content-center align-items-center">
                    <div class="col-6">
                        <h1>Update Category</h1>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Update Category</li>
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
                                    action="{{ url('admin/update/category/' . Crypt::encrypt($category->id)) }}">
                                    @csrf
                                    @method('put')
                                    <div class="row justify-content-center">
                                        <div class="col-xl-4 col-lg-8 col-md-8 col-12">
                                            <div class="input-group mb-3">
                                                <label class="create_event_head">Category Name <span class="text-danger">*</span></label>
                                                <input onkeyup="alertMessage()" id="name" type="text" class="form-control" maxlength="100"
                                                    name="name" value="{{ $category->name }}" placeholder="Name" required
                                                    autocomplete="name" autofocus>
                                                    <span id="errorMsg" style="display:none; color:red;">Name should be 6 to 30 characters long</span>
                                                @error('name')
                                                    <span class="text-danger text-sm" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- /.col -->
                                                    <div class="crd_foter">
                                                        <button type="submit"
                                                            class="btn save_event_btn btn-secondary float-right">
                                                            Update Category
                                                        </button>
                                                        <a href="{{ url('admin/manage/categories') }}"><button type="button" class="btn btn-default float-right mr-2">Cancel</button></a>     
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
        let x = document.getElementById('name').value;
        if(x.length < 5 || x.length >30){
            $('#errorMsg').show();
            $('#submit-button').disabled();
        }else{
            $('#errorMsg').hide();
        }
    }
</script>