@extends('teacher.layouts.layouts')
@section('title', 'My Profile')

@section('content')
    <div class="content-wrapper">
        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>My Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">My Profile</li>
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
                                <img src="{{ $teacher->photo ? asset('storage/' . $teacher->photo) : asset('default-user.png') }}"
                                     alt="Teacher Photo"
                                     class="img-fluid rounded-circle mb-3"
                                     width="150"
                                     height="150">
                                <h3>{{ $teacher->name }} {{ $teacher->last_name }}</h3>
                                <p><strong>Email:</strong> {{ $teacher->email }}</p>
                                <p><strong>Phone:</strong> {{ $teacher->phone }}</p>
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
                                        <td>{{ $teacher->gender == 1 ? 'Male' : 'Female' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>{{ \Carbon\Carbon::parse($teacher->dob)->format('F d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Religion</th>
                                        <td>{{ $teacher->religion }}</td>
                                    </tr>
                                    <tr>
                                        <th>Marital Status</th>
                                        <td>{{ ucfirst($teacher->marital_status ?? 'N/A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Current Address</th>
                                        <td>{{ $teacher->current_address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Qualification</th>
                                        <td>{{ $teacher->qualification ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Experience</th>
                                        <td>{{ $teacher->experience ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Join</th>
                                        <td>{{ \Carbon\Carbon::parse($teacher->date_of_join)->format('F d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $teacher->teacher_status == 1 ? 'Active' : 'Inactive' }}</td>
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
