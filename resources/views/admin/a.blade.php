@extends('admin.layouts.layouts')
@section('title', 'Edit Class Assignment')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Class Assignment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Class Assignment</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        {{-- <section class="content">
            <div class="container-fluid">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Class Assignment</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('assign_class_to_teacher.update', $class->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="class_name">Class Name</label>
                                <input type="text" id="class_name" class="form-control" value="{{ $class->name }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="user_ids">Assign Teachers</label>
                                <select name="user_ids[]" id="user_ids" class="form-control" multiple>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" 
                                            {{ $class->teachers->contains($teacher->id) ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_ids')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('assign.classe.to.teacher') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </section> --}}
    </div>
@endsection
