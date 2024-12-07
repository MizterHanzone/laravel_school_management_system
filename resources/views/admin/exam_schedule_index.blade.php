@extends('admin.layouts.layouts')
@section('title', 'Print Exam Schedule')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Print Exam Schedule</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Print Exam Schedule</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Exam Schedule</h3>
                        <button class="btn btn-info" onclick="window.print()">Print</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
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
                                            <td>{{ $schedule->exam_date }}</td>
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

@section('script')
    <script>
        $(document).ready(function() {
            // Optional: You can trigger the print directly when page is loaded, or use the button
            // window.print();
        });
    </script>
@endsection

<style>
    @media print {
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            width: 100%;
            padding: 10px;
        }

        .card {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .breadcrumb {
            display: none;
        }

        .btn-info {
            display: none;
        }

        /* Add Landscape Orientation and Adjust Margins */
        @page {
            size: landscape;
            margin: 20mm;
        }

        /* Adjust font size for print */
        th, td {
            font-size: 12px;
            padding: 6px;
        }

        /* Table and header styling for print */
        .card-header, .card-body {
            display: block;
        }
    }
</style>
