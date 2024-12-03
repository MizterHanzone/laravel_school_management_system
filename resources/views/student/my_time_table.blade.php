@extends('student.layouts.layouts')
@section('title', 'My Time Table')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Time Table</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Time Table</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if ($timeTables->isEmpty())
                <div class="alert alert-info">
                    No time table available for your class.
                </div>
            @else
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Time Table</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Subject</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Room No</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timeTables as $entry)
                                    <tr>
                                        <td>{{ $entry->day->name }}</td>
                                        <td>{{ $entry->subject->name }}</td>
                                        <td>{{ date('h:i A', strtotime($entry->start_time)) }}</td>
                                        <td>{{ date('h:i A', strtotime($entry->end_time)) }}</td>
                                        <td>{{ $entry->room_no }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
