@extends('admin.layouts.layouts')
@section('title', 'Student')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Student</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Student</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <form action="" method="GET" class="row">
                    <div class="form-group col-md-2">
                        <label for="class_id">Select Class</label>
                        <select name="class_id" class="form-control">
                            <option value="">Select Class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" @if (request()->class_id == $class->id) selected @endif>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="academi_year_id">Select Class</label>
                        <select name="acdemi_year_id" class="form-control">
                            <option value="">Select Academic Year</option>
                            @foreach ($academi_years as $academic_year)
                                <option value="{{ $academic_year->id }}" @if (request()->acdemi_year_id == $academic_year->id) selected @endif>
                                    {{ $academic_year->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="gender">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="" disabled selected>Select Gender</option>
                            <option value="1" @if (request()->gender == '1') selected @endif>Male</option>
                            <option value="0" @if (request()->gender == '0') selected @endif>Female</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="status">Select Status</label>
                        <select name="status" class="form-control">
                            <option value="" disabled selected>Select Status</option>
                            <option value="Studying" @if (request()->status == 'Studying') selected @endif>Studying</option>
                            <option value="Drop Out" @if (request()->status == 'Drop Out') selected @endif>Drop Out</option>
                            <option value="Graduation" @if (request()->status == 'Graduation') selected @endif>Graduation</option>
                        </select>
                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-1 d-flex align-items-end">
                        <button class="btn btn-success w-100" type="submit">Filter</button>
                    </div>
                    <div class="form-group col-md-1 d-flex align-items-end">
                        <a href="{{ route('student.index') }}" class="btn btn-danger w-100">Clear</a>
                    </div>
                </form>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title m-0">Student</h3>
                        <a href="{{route('student.create')}}" class="btn btn-primary"
                            style="position: absolute; right: 20px;">Add New</a>
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
                                        <td><img src="{{ asset('storage/' . $student->photo) }}" alt="" class="image" width="50" height="50"></td><td><img src="{{ asset('storage/' . $student->photo) }}" alt="" class="image" width="50" height="50"></td>
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
                    </div>
                </div>
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

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
