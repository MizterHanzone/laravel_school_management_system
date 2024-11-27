@extends('admin.layouts.layouts')
@section('title', 'Admin update password')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin update password</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.list') }}">Admin List</a></li>
                            <li class="breadcrumb-item active">Admin update password</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Admin update password</h3>
                            </div>
                            <form action="{{ route('admin.update.password') }}" method="POST">
                                @csrf
                                {{-- @method('PUT') --}}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Old Passowrd</label>
                                        <input type="text" name="old_password" class="form-control"
                                            id="exampleInputEmail1" placeholder="Enter old password"
                                            value="{{ old('old_password') }}">
                                    </div>
                                    @error('old_password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">New Passowrd</label>
                                        <input type="password" name="new_password" class="form-control"
                                            id="exampleInputEmail1" placeholder="Enter new password"
                                            value="{{ old('new_password') }}">
                                    </div>
                                    @error('new_password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Confirm Passowrd</label>
                                        <input type="password" name="confirm_password" class="form-control"
                                            id="exampleInputEmail1" placeholder="Enter confirm password"
                                            value="{{ old('confirm_password') }}">
                                    </div>
                                    @error('confirm_password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
