@extends('parent.layouts.layouts')
@section('title', 'Student Time Table')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $my_students->name }}'s Time Table</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('parent.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Time Table</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @if ($timeTables->isNotEmpty())
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Day</th>
                                <th>Subject</th>
                                <th>Time</th>
                                <th>Room</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timeTables as $timeTable)
                                <tr>
                                    <td>{{ $timeTable->class->name }}</td> <!-- Assuming `class` is related -->
                                    <td>{{ $timeTable->day->name }}</td>
                                    <td>{{ $timeTable->subject->name }}</td>
                                    <td>{{ $timeTable->start_time }} - {{ $timeTable->end_time }}</td>
                                    <td>{{ $timeTable->room_no }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="card">
                        <div class="card-body">
                            <p>No timetable available for this student.</p>
                        </div>
                    </div>
                @endif

            </div>
        </section>
    </div>
@endsection
