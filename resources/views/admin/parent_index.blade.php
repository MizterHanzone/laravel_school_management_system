@extends('admin.layouts.layouts')
@section('title', 'Parent')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Parent</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Parent</li>
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
                        <h3 class="card-title m-0">Parent</h3>
                        <a href="{{route('parent.create')}}" class="btn btn-primary"
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
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parents as $parent)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img src="{{ asset('storage/' . $parent->photo) }}" alt="" class="image" width="50" height="50"></td>
                                        <td>{{ $parent->name }}</td>
                                        <td>{{ $parent->last_name }}</td>
                                        <td>{{ $parent->gender == 1 ? 'Male' : 'Female' }}</td>
                                        <td>{{ $parent->email}}</td>
                                        <td>{{ $parent->phone}}</td>
                                        <td>
                                            <a href="{{ route('parent.edit', $parent->id) }}" class="btn btn-success">Edit</a>
                                            <form
                                                action="{{ route('parent.destory', $parent->id) }}"
                                                method="POST" class="d-inline"
                                                id="delete-form-{{ $parent->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $parent->id }})">Delete</button>
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
