@extends('admin.layouts.layouts')
@section('title', 'Assign Class To Teacher')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Assign Class To Teacher</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Assign Class To Teacher</li>
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
                    <div class="form-group col-md-1 d-flex align-items-end">
                        <button class="btn btn-success w-100" type="submit">Filter</button>
                    </div>
                    <div class="form-group col-md-1 d-flex align-items-end">
                        <a href="{{ route('assign.classe.to.teacher') }}" class="btn btn-danger w-100">Clear</a>
                    </div>
                </form>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title m-0">Assign Class</h3>
                        <a href="{{ route('assign.classe.to.create') }}" class="btn btn-primary"
                            style="position: absolute; right: 20px;">Assign New
                            Class</a>
                    </div>
                    <div class="card-body">
                        <table id="adminTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Teacher</th>
                                    <th>Class</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teacher_classes as $teacher_class)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $teacher_class->user->name }}</td>
                                        <td>{{ $teacher_class->classes->name }}</td>
                                        <td>{{ $teacher_class->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <a href="{{ route('assign_class_to_teacher.edit', $teacher_class->id) }}"
                                                class="btn btn-success">Edit</a>
                                            <form
                                                action="{{ route('assign_class_to_teacher.destroy', $teacher_class->id) }}"
                                                method="POST" class="d-inline" id="delete-form-{{ $teacher_class->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $teacher_class->id }})">Delete</button>
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
