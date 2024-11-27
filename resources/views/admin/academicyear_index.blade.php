@extends('admin.layouts.layouts')
@section('title', 'Academic Year')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Academic Year</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Academic Year</li>
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

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title m-0">Academic Year</h3>
                        <a href="{{route('academic_year.create')}}" class="btn btn-primary"
                            style="position: absolute; right: 20px;">Add New</a>
                    </div>
                    <div class="card-body">
                        <table id="adminTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($academiYears as $academiYear)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $academiYear->id }}</td>
                                        <td>{{ $academiYear->name }}</td>
                                        <td>
                                            <a href="{{ route('academic_year.edit', $academiYear->id) }}" class="btn btn-success">Edit</a>
                                            <form action="{{ route('academic_year.destroy', $academiYear->id) }}" method="POST"
                                                class="d-inline" id="delete-form-{{ $academiYear->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $academiYear->id }})">Delete</button>
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
