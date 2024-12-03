@extends('teacher.layouts.layouts')
@section('title', 'My Classes and Subjects')

@section('content')
    <div class="content-wrapper">
        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h1>My Classes and Subjects</h1>
                    </div>
                    <div class="col-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Classes and Subjects</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Classes and Subjects Table -->
        <section class="content">
            <div class="container-fluid">
                @if ($classes->isNotEmpty())
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Room</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $class)
                                @if ($class->subjects->isNotEmpty())
                                    @foreach ($class->subjects as $subject)
                                        @php
                                            $subjectTimeTables = $class->timeTables->where('subject_id', $subject->id);
                                        @endphp
                                        @if ($subjectTimeTables->isNotEmpty())
                                            @foreach ($subjectTimeTables as $timeTable)
                                                <tr>
                                                    <td>{{ $class->name }}</td>
                                                    <td>{{ $subject->name }}</td>
                                                    <td>{{ $timeTable->day->name }}</td>
                                                    <td>{{ $timeTable->start_time }} - {{ $timeTable->end_time }}</td>
                                                    <td>{{ $timeTable->room_no }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>{{ $class->name }}</td>
                                                <td>{{ $subject->name }}</td>
                                                <td colspan="3">No timetable available</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td>{{ $class->name }}</td>
                                        <td colspan="4">No subjects assigned to this class</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="card">
                        <div class="card-body">
                            <p>No classes assigned to you.</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
