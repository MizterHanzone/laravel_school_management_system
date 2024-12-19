@extends('admin.layouts.layouts')
@section('title', 'Edit Exam Schedule')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Exam Schedule</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('exam.schedule.index') }}">Exam Schedules</a></li>
                        <li class="breadcrumb-item active">Edit Exam Schedule</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Exam Schedule</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('exam.schedule.update', $schedule->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    
                        <div class="form-group">
                            <label for="examination_id">Examination</label>
                            <select name="examination_id" class="form-control" required>
                                @foreach ($examinations as $examination)
                                    <option value="{{ $examination->id }}" {{ $schedule->examination_id == $examination->id ? 'selected' : '' }}>
                                        {{ $examination->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label for="class_id">Class</label>
                            <select name="class_id" class="form-control" required>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" {{ $schedule->class_id == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label for="subject_id">Subject</label>
                            <select name="subject_id" class="form-control" required>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $schedule->subject_id == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label for="exam_date">Exam Date</label>
                            <input type="date" name="exam_date" class="form-control" value="{{ $schedule->exam_date }}" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="start_time">Start Time</label>
                            <input type="time" name="start_time" class="form-control" value="{{ $schedule->start_time }}" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="end_time">End Time</label>
                            <input type="time" name="end_time" class="form-control" value="{{ $schedule->end_time }}" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="room_no">Room Number</label>
                            <input type="text" name="room_no" class="form-control" value="{{ $schedule->room_no }}" required>
                        </div>
                    
                        <button type="submit" class="btn btn-success">Update</button>
                    </form>                                        
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
