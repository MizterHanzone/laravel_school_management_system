@extends('admin.layouts.layouts')
@section('title', 'Assign Class To Teacher')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Assign Class To Teacher</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('assign.classe.to.teacher') }}">Assign Class To Teacher List</a></li>
                            <li class="breadcrumb-item active">Assign Class To Teacher</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Assign Class To Teacher</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('assign_class_to_teacher.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="class_id">Select Class</label>
                                        <select name="class_id" id="class_id" class="form-control">
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="user_ids">Select Teachers</label>
                                        @foreach ($teachers as $teacher)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="user_ids[]"
                                                    value="{{ $teacher->id }}" id="teacher_{{ $teacher->id }}">
                                                <label class="form-check-label"
                                                    for="teacher_{{ $teacher->id }}">{{ $teacher->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary">Assign Teachers to Class</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
@endsection
