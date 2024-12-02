@extends('admin.layouts.layouts')
@section('title', 'Time Table')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Time Table</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Time Table</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Search Time Table</h3>
                            </div>
                            <form action="{{ route('time.table.index') }}" method="GET">
                                <div class="card-body row align-items-end d-flex">
                                    <div class="form-group col-md-6">
                                        <label for="class_id">Select Class</label>
                                        <select name="class_id" id="class_id" class="form-control">
                                            <option value="" disabled
                                                {{ request()->input('class_id') ? '' : 'selected' }}>
                                                Select Class
                                            </option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ request()->input('class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2 d-flex">
                                        <button type="submit" class="btn btn-primary mt-auto mr-2">Search</button>
                                        <a href="{{ route('time.table.create') }}" class="btn btn-primary mt-auto">Add
                                            New</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if (isset($timeTables) && $timeTables->isNotEmpty())
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Time Table</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <th>Subject</th>
                                                <th>Day</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Room No</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($timeTables as $timeTable)
                                                <tr>
                                                    <td>{{ $timeTable->class->name }}</td>
                                                    <td>{{ $timeTable->subject->name ?? 'N/A' }}</td>
                                                    <!-- If subject is null -->
                                                    <td>{{ $timeTable->day->name }}</td>
                                                    <td>{{ $timeTable->start_time }}</td>
                                                    <td>{{ $timeTable->end_time }}</td>
                                                    <td>{{ $timeTable->room_no }}</td>
                                                    <td>
                                                        <a href="{{ route('time.table.edit', $timeTable->id) }}"
                                                            class="btn btn-warning btn-sm">Edit</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <form action="{{ route('time.table.destroy', $class_id) }}" method="POST"
                                        class="d-inline" id="delete-form-{{ $class_id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmDelete({{ $class_id }})">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @elseif (isset($class_id))
                            <div class="alert alert-warning">No time table found for the selected class.</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
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
