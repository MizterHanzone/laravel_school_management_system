@extends('teacher.layouts.layouts')
@section('title', 'Students in My Classes')

@section('content')
    <div class="content-wrapper">
        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Students in My Classes</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Students in My Classes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Classes and Students -->
        <section class="content">
            <div class="container-fluid">
                @foreach ($classes as $class)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Class: {{ $class->name }}</h3>
                        </div>
                        <div class="card-body">
                            <table id="adminTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Photo</th>
                                        <th>FirstName</th>
                                        <th>LastName</th>
                                        <th>Gender</th>
                                        <th>DateofBirth</th>
                                        <th>Religion</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>AdmissionDate</th>
                                        <th>Class</th>
                                        <th>AcademicYear</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ asset('storage/' . $student->photo) }}" alt="" class="image" width="50" height="50"></td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->last_name }}</td>
                                            <td>{{ $student->gender == 1 ? 'Male' : 'Female' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($student->dob)->format('d-M-Y') }}</td>
                                            <td>{{ $student->religion}}</td>
                                            <td>{{ $student->email}}</td>
                                            <td>{{ $student->phone}}</td>
                                            <td>{{ \Carbon\Carbon::parse($student->admission_date)->format('d-M-Y') }}</td>
                                            <td>{{ $student->class ? $student->class->name : 'No Class' }}</td>
                                            <td>{{ $student->academiYear ? $student->academiYear->name : 'No Academic' }}</td>
                                            <td>{{ $student->status}}</td>
                                            <td>
                                                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-success">Edit</a>
                                                <form
                                                    action="{{ route('student.destroy', $student->id) }}"
                                                    method="POST" class="d-inline"
                                                    id="delete-form-{{ $student->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="confirmDelete({{ $student->id }})">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- <ul class="list-group">
                                @php
                                    $classStudents = $students->where('class_id', $class->id);
                                @endphp

                                @forelse ($classStudents as $student)
                                    <li class="list-group-item">{{ $student->name }} - {{ $student->last_name }}</li>
                                @empty
                                    <li class="list-group-item">No students in this class.</li>
                                @endforelse
                            </ul> --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#adminTable').DataTable({
                responsive: true,
                autoWidth: false,
                lengthChange: true,
                searching: true,
                buttons: ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#adminTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection