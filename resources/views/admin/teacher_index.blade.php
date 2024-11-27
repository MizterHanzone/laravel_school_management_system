@extends('admin.layouts.layouts')
@section('title', 'Teacher')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Teacher</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Teacher</li>
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
                    <!-- Filter by Date of Join -->
                    <div class="form-group col-md-2">
                        <label for="date_of_join_from">Date of Join (From)</label>
                        <input type="date" name="date_of_join_from" class="form-control"
                            value="{{ request()->date_of_join_from }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="date_of_join_to">Date of Join (To)</label>
                        <input type="date" name="date_of_join_to" class="form-control"
                            value="{{ request()->date_of_join_to }}">
                    </div>

                    <!-- Filter by Teacher Status -->
                    <div class="form-group col-md-2">
                        <label for="teacher_status">Teacher Status</label>
                        <select name="teacher_status" class="form-control">
                            <option value="" disabled selected>Select Status</option>
                            <option value="1" @if (request()->teacher_status == '1') selected @endif>Active</option>
                            <option value="0" @if (request()->teacher_status == '0') selected @endif>Inactive</option>
                        </select>
                    </div>

                    <!-- Filter by Gender -->
                    <div class="form-group col-md-2">
                        <label for="gender">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="" disabled selected>Select Gender</option>
                            <option value="1" @if (request()->gender == '1') selected @endif>Male</option>
                            <option value="0" @if (request()->gender == '0') selected @endif>Female</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-group col-md-1 d-flex align-items-end">
                        <button class="btn btn-success w-100" type="submit">Filter</button>
                    </div>
                    <div class="form-group col-md-1 d-flex align-items-end">
                        <a href="{{ route('teacher.index') }}" class="btn btn-danger w-100">Clear</a>
                    </div>
                </form>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title m-0">Teacher</h3>
                        <a href="{{ route('teacher.create') }}" class="btn btn-primary"
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
                                    <th>Join Date</th>
                                    <th>Marital_status</th>
                                    <th>Current_address</th>
                                    <th>Qualification</th>
                                    <th>Experience</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teachers as $teacher)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img src="{{ asset('storage/' . $teacher->photo) }}" alt=""
                                                class="image" width="50" height="50"></td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->last_name }}</td>
                                        <td>{{ $teacher->gender == 1 ? 'Male' : 'Female' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($teacher->dob)->format('d-M-Y') }}</td>
                                        <td>{{ $teacher->religion }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->phone }}</td>
                                        <td>{{ \Carbon\Carbon::parse($teacher->date_of_join)->format('d-M-Y') }}</td>
                                        <td>{{ $teacher->marital_status }}</td>
                                        <td>{{ $teacher->current_address }}</td>
                                        <td>{{ $teacher->qualification }}</td>
                                        <td>{{ $teacher->experience }}</td>
                                        <td>{{ $teacher->teacher_status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <a href="{{ route('teacher.edit', $teacher->id) }}"
                                                class="btn btn-success">Edit</a>
                                            <form action="{{ route('teacher.destroy', $teacher->id) }}" method="POST"
                                                class="d-inline" id="delete-form-{{ $teacher->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $teacher->id }})">Delete</button>
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
