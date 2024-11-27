@extends('admin.layouts.layouts')
@section('title', 'Assign Subject')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Assign Subject</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('assign_subject_to_class.index') }}">Assign Subject</a></li>
                            <li class="breadcrumb-item active">Assign Subject To Class</li>
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
                                <h3 class="card-title">Assign Subject</h3>
                            </div>
                            <form action="{{route('assign_subject_to_class.store')}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="class_id">Assign Subject</label>
                                        <select name="class_id" id="" class="form-control">
                                            <option value="" disabled selected>Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('class_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group">
                                        <label for="status">Subjecct</label>
                                        @foreach ($subjects->chunk(6) as $chunk)
                                            <div class="row">
                                                @foreach ($chunk as $subject)
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="subject_id[]" id="subject-{{ $subject->id }}" value="{{ $subject->id }}" class="form-check-input">
                                                            <label for="subject-{{ $subject->id }}" class="form-check-label">{{ $subject->name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>                                    
                                    @error('subject_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">InActive</option>
                                        </select>
                                    </div>
                                    @error('status')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
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
