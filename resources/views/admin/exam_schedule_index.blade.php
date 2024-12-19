@extends('admin.layouts.layouts')
@section('title', 'Exam Schedules')

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
                        <h3 class="card-title">Filter by Class</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('exam.schedule.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="class_id" class="form-control" onchange="this.form.submit()">
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ $class_id == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
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
                                <a href="{{route('exam.schedule.create')}}" class="btn btn-primary">Add New</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Exam Schedules</h3>
                        <!-- Add Print Button -->
                        <button onclick="printTable()" class="btn btn-info float-right">Print</button>
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
                                            <td>
                                                <a href="{{ route('exam.schedule.edit', $schedule->id) }}" class="btn btn-warning btn-sm">Edit</a> <!-- Edit button -->
                                            </td>
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
        // Print table functionality
        function printTable() {
            var printWindow = window.open('', '', 'height=600,width=800');

            // Get the selected examination
            var examinationName = document.querySelector('select[name="examination_id"] option:checked') ?
                document.querySelector('select[name="examination_id"] option:checked').textContent : 'Not selected';

            // Write the content to the print window
            printWindow.document.write('<html><head><title>Exam Schedules</title>');

            // Add CSS for landscape orientation and realistic exam form design
            printWindow.document.write('<style>');
            printWindow.document.write('@page { size: landscape; margin: 20mm; }'); // Landscape orientation
            printWindow.document.write('body { font-family: Arial, sans-serif; }');
            printWindow.document.write('.container { width: 100%; max-width: 1200px; margin: 0 auto; }');
            printWindow.document.write('h1 { text-align: center; font-size: 24px; margin-bottom: 20px; }');
            printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
            printWindow.document.write(
                'th, td { padding: 10px; text-align: center; border: 1px solid #ddd; font-size: 14px; }');
            printWindow.document.write('th { background-color: #f2f2f2; font-weight: bold; }');
            printWindow.document.write('td { background-color: #fff; }');
            printWindow.document.write('.header { font-size: 18px; margin-bottom: 10px; }');
            printWindow.document.write('.footer { font-size: 12px; text-align: center; margin-top: 20px; }');
            printWindow.document.write('</style>');

            printWindow.document.write('</head><body>');

            // Add header information
            printWindow.document.write('<div class="container">');
            printWindow.document.write('<div class="header">');
            printWindow.document.write('<h1>Exam Schedule</h1>');
            printWindow.document.write('<p><strong>Institution Name:</strong> Blue School</p>');
            printWindow.document.write('<p><strong>Examination:</strong> ' + examinationName + '</p>'); // Updated
            printWindow.document.write('<p><strong>Class:</strong> ' + document.querySelector(
                'select[name="class_id"] option:checked').textContent + '</p>');
            printWindow.document.write('</div>');

            // Add the exam schedule table
            printWindow.document.write('<table>');
            printWindow.document.write('<thead>');
            printWindow.document.write('<tr>');
            printWindow.document.write('<th>Subject</th>');
            printWindow.document.write('<th>Date</th>');
            printWindow.document.write('<th>Start Time</th>');
            printWindow.document.write('<th>End Time</th>');
            printWindow.document.write('<th>Room</th>');
            printWindow.document.write('</tr>');
            printWindow.document.write('</thead>');
            printWindow.document.write('<tbody>');

            // Loop through each exam schedule
            var examSchedules = document.querySelectorAll('#examScheduleTable tbody tr');
            examSchedules.forEach(function(row, index) {
                printWindow.document.write('<tr>');
                printWindow.document.write('<td>' + row.cells[3].textContent + '</td>');
                printWindow.document.write('<td>' + row.cells[4].textContent + '</td>');
                printWindow.document.write('<td>' + row.cells[5].textContent + '</td>');
                printWindow.document.write('<td>' + row.cells[6].textContent + '</td>');
                printWindow.document.write('<td>' + row.cells[7].textContent + '</td>');
                printWindow.document.write('</tr>');
            });

            printWindow.document.write('</tbody>');
            printWindow.document.write('</table>');

            // Add footer with contact details
            printWindow.document.write('<div class="footer">');
            printWindow.document.write('<p>For any queries, contact: sokhankheave@gmail.com</p>');
            printWindow.document.write('</div>');

            printWindow.document.write('</div>');

            printWindow.document.close();

            // Trigger the print dialog
            printWindow.print();
        }
    </script>
@endsection
