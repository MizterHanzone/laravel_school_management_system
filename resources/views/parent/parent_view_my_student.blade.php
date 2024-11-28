@extends('parent.layouts.layouts')
@section('title', 'View Students')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Students to {{ $parent->name }} {{ $parent->last_name }}</h1> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('parent.dashboard') }}">Dashboard</a></li>
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
                                <th>FirstName</th>
                                <th>LastName</th>
                                <th>Gender</th>
                                <th>DateOfBirth</th>
                                <th>Rreligion</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>AdmissionDate</th>
                                <th>Class</th>
                                <th>AcademicYear</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($my_students as $my_student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $my_student->name }}</td>
                                    <td>{{ $my_student->last_name }}</td>
                                    <td>{{ $my_student->gender == 1 ? 'Male' : 'Female' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($my_student->dob)->format('d-M-Y') }}</td>
                                    <td>{{ $my_student->religion }}</td>
                                    <td>{{ $my_student->email }}</td>
                                    <td>{{ $my_student->phone }}</td>
                                    <td>{{ \Carbon\Carbon::parse($my_student->admission_date)->format('d-M-Y') }}</td>
                                    <td>{{ $my_student->class ? $my_student->class->name : 'No Class' }}</td>
                                    <td>{{ $my_student->academiYear ? $my_student->academiYear->name : 'No Academic' }}</td>
                                    <td>{{ $my_student->status }}</td>
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
</script>
@endsection
