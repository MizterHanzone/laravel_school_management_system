@extends('student.layouts.layouts')
@section('title', 'Student Profile')

@section('content')
    <div class="content-wrapper">
        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Your Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
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
                                <img src="{{ asset('storage/' . $student->photo ?? 'default-avatar.png') }}"
                                     class="img-fluid rounded-circle mb-3"
                                     alt="Student Photo"
                                     width="150"
                                     height="150">
                                <h3>{{ $student->name }} {{ $student->last_name }}</h3>
                                <p><strong>Email:</strong> {{ $student->email }}</p>
                                <p><strong>Phone:</strong> {{ $student->phone }}</p>
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
                                        <td>{{ $student->gender == 1 ? 'Male' : 'Female' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>{{ \Carbon\Carbon::parse($student->dob)->format('d M, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Religion</th>
                                        <td>{{ $student->religion }}</td>
                                    </tr>
                                    <tr>
                                        <th>Admission Date</th>
                                        <td>{{ \Carbon\Carbon::parse($student->admission_date)->format('d M, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $student->status }}</td>
                                    </tr>
                                    <tr>
                                        <th>Class</th>
                                        <td>{{ $student->class->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Academic Year</th>
                                        <td>{{ $student->academiYear->name ?? 'N/A' }}</td>
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
