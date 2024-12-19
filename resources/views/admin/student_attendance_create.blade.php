@extends('admin.layouts.layouts')
@section('title', 'Attendance Create')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Attendance Create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('student.attendance.index') }}">Attendance List</a></li>
                            <li class="breadcrumb-item active">Attendance Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Attendance Create</h3>
                            </div>
                            <div class="card-body">
                                <!-- Filter Form -->
                                <form id="filter-form" method="GET" action="{{ route('student.attendance.create') }}">
                                    <div class="form-group">
                                        <label for="class_id">Select Class</label>
                                        <select name="class_id" id="class_id" class="form-control">
                                            <option value="">-- Select Class --</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Attendance Date</label>
                                        <input type="date" name="date" id="date" class="form-control" value="{{ request('date') ?? now()->toDateString() }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </form>

                                @if ($students)
                                    <!-- Attendance Form -->
                                    <form method="POST" action="{{ route('student.attendance.store') }}">
                                        @csrf
                                        <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                                        <input type="hidden" name="date" value="{{ request('date') }}">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Attendance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($students as $student)
                                                    <tr>
                                                        <td>{{ $student->name }}</td>
                                                        <td>
                                                            <select name="attendance[{{ $student->id }}]" class="form-control" required>
                                                                <option value="present">Present</option>
                                                                <option value="absent">Absent</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-success mt-3">Save Attendance</button>
                                    </form>
                                @else
                                    <p class="text-danger">No students found for the selected class.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
