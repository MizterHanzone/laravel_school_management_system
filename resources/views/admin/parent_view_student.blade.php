@extends('admin.layouts.layouts')
@section('title', 'View Assigned Students')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Students Assigned to {{ $parent->name }} {{ $parent->last_name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('parent.index') }}">Parents</a></li>
                        <li class="breadcrumb-item active">View Students</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table id="adminTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Photo</th>
                                <th>FirstName</th>
                                <th>LastName</th>
                                <th>Gender</th>
                                <th>DateOfBirth</th>
                                <th>Religion</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Admission</th>
                                <th>Class</th>
                                <th>AcademicYear</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parent->students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset('storage/' . $student->photo) }}" alt="" class="image" width="50" height="50"></td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->last_name }}</td>
                                    <td>{{ $student->gender == 1 ? 'Male' : 'Female' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($student->dob)->format('d-M-Y') }}</td>
                                    <td>{{ $student->religion }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ \Carbon\Carbon::parse($student->admission_date)->format('d-M-Y') }}</td>
                                    <td>{{ $student->class ? $student->class->name : 'No Class' }}</td>
                                    <td>{{ $student->academicYear ? $student->academi_years->name : 'No Academic' }}</td>
                                    <td>
                                        <form action="{{ route('student.unassign', ['parent_id' => $parent->id, 'student_id' => $student->id]) }}" method="POST" id="delete-student-{{ $student->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $student->id }})">Remove</button>
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
            paging: true,
            ordering: true,
            info: true,
            buttons: ["copy", "csv", "excel", "pdf", "print"],
            dom: 'Bfrtip',
        }).buttons().container().appendTo('#adminTable_wrapper .col-md-6:eq(0)');
    });

    function confirmDelete(studentId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will remove the student from this parent!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-student-' + studentId).submit();
            }
        });
    }
</script>
@endsection
