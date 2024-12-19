@extends('student.layouts.layouts')
@section('title', 'My Exam Schedule')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Exam Schedules</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Exam Schedules</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Filter by Examination</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('student.my.exam.schedule') }}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="examination_id" class="form-control" onchange="this.form.submit()">
                                        <option value="">Select Examination</option>
                                        @foreach ($examinations as $examination)
                                            <option value="{{ $examination->id }}"
                                                {{ $examination_id == $examination->id ? 'selected' : '' }}>
                                                {{ $examination->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Exam Schedules</h3>
                    </div>
                    <div class="card-body">
                        <table id="examScheduleTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Examination</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Room</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($exam_schedules->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">No Exam Schedules Found</td>
                                    </tr>
                                @else
                                    @foreach ($exam_schedules as $schedule)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $schedule->examination->name }}</td>
                                            <td>{{ $schedule->class->name }}</td>
                                            <td>{{ $schedule->subject->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($schedule->exam_date)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
                                            <td>{{ $schedule->room_no }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection