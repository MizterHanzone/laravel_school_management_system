@extends('admin.layouts.layouts')
@section('title', 'Assign Subject')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Assign Subject</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Assign Subject</li>
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
                    <div class="form-group col-md-3">
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
                    <div class="form-group col-md-3">
                        <label for="subject_id">Select Subject</label>
                        <select name="subject_id" class="form-control">
                            <option value="">Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" @if (request()->subject_id == $subject->id) selected @endif>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-1 d-flex align-items-end">
                        <button class="btn btn-success w-100" type="submit">Filter</button>
                    </div>
                    <div class="form-group col-md-1 d-flex align-items-end">
                        <a href="{{ route('assign_subject_to_class.index') }}" class="btn btn-danger w-100">Clear</a>
                    </div>
                </form>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title m-0">Assign Subject</h3>
                        <a href="{{ route('assign_subject_to_class.create') }}" class="btn btn-primary"
                            style="position: absolute; right: 20px;">Assign New Subject</a>
                    </div>
                    <div class="card-body">
                        <table id="adminTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignSubjectToClasses as $assignSubjectToClass)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $assignSubjectToClass->class->name }}</td>
                                        <td>{{ $assignSubjectToClass->subject->name }}</td>
                                        <td>{{ $assignSubjectToClass->status == 1 ? 'Active' : 'InActive' }}</td>
                                        <td>
                                            <a href="{{ route('assign_subject_to_class.edit', $assignSubjectToClass->id) }}"
                                                class="btn btn-success">Edit</a>
                                            <form
                                                action="{{ route('assign_subject_to_class.destroy', $assignSubjectToClass->id) }}"
                                                method="POST" class="d-inline"
                                                id="delete-form-{{ $assignSubjectToClass->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $assignSubjectToClass->id }})">Delete</button>
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
