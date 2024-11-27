@extends('admin.layouts.layouts')
@section('title', 'Assign Student to Parent')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Assign Students to {{ $parent->name }} {{ $parent->last_name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('parent.index') }}">Parents</a></li>
                        <li class="breadcrumb-item active">Assign Students</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('assign.student.submit', $parent->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="student_id">Select Student</label>
                            <select name="student_id" id="student_id" class="form-control">
                                <option value="">Select a student</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} {{ $student->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Assign Student</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
