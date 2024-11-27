@extends('parent.layouts.layouts') <!-- Adjust layout file path if necessary -->
@section('title', 'Parent Profile')

@section('content')
    <div class="content-wrapper">
        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Parent Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Parent Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Profile Section -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Profile Picture -->
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="{{ $parent->photo ? asset('storage/' . $parent->photo) : asset('default-avatar.png') }}"
                                     class="img-fluid rounded-circle mb-3"
                                     alt="Parent Photo"
                                     width="150"
                                     height="150">
                                <h3>{{ $parent->name }} {{ $parent->last_name }}</h3>
                                <p><strong>Email:</strong> {{ $parent->email }}</p>
                                <p><strong>Phone:</strong> {{ $parent->phone }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <!-- Personal Details -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Personal Details</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ $parent->gender == 1 ? 'Male' : 'Female' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $parent->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $parent->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td>{{ ucfirst($parent->role) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ \Carbon\Carbon::parse($parent->created_at)->format('F d, Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
