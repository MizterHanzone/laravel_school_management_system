@extends('admin.layouts.layouts')

@section('title', 'Add Exam Schedules')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Exam Schedules</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('exam.schedule.index') }}">Exam Schedules List</a>
                            </li>
                            <li class="breadcrumb-item active">Add Exam Schedules</li>
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
                                <h3 class="card-title">Add Exam Schedules</h3>
                            </div>
                            <form action="{{ route('exam.schedule.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <!-- Examination Selection -->
                                    <div class="form-group">
                                        <label for="examination_id">Select Examination</label>
                                        <select name="examination_id" id="examination_id" class="form-control">
                                            <option value="" disabled selected>Select Examination</option>
                                            @foreach ($examinations as $examination)
                                                <option value="{{ $examination->id }}">{{ $examination->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('examination_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Class Selection -->
                                    <div class="form-group">
                                        <label for="class_id">Select Class</label>
                                        <select name="class_id" id="class_id" class="form-control">
                                            <option value="" disabled selected>Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Time Table Entries -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Exam Date</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Duration (Minutes)</th>
                                                <th>Room Number</th>
                                                <th>Full Mark</th>
                                                <th>Pass Mark</th>
                                            </tr>
                                        </thead>
                                        <tbody id="schedule-rows">
                                            <!-- Rows will be dynamically added here -->
                                        </tbody>
                                    </table>

                                    <!-- Submit Button -->
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{ route('exam.schedule.index') }}" class="btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#class_id').change(function() {
                const classId = $(this).val();
                const examinationId = $('#examination_id').val(); // Get the selected examination ID

                if (classId && examinationId) {
                    $.ajax({
                        url: '{{ route('get.subjects.by.classes') }}', // Correct route
                        type: 'GET',
                        data: {
                            class_id: classId,
                            examination_id: examinationId
                        },
                        success: function(response) {
                            $('#schedule-rows').empty(); // Clear existing rows
                            if (response.length > 0) {
                                response.forEach((subject, index) => {
                                    $('#schedule-rows').append(`
                                <tr>
                                    <td>
                                        <input type="hidden" name="schedules[${index}][subject_id]" value="${subject.id}">
                                        ${subject.name}
                                    </td>
                                    <td><input type="date" name="schedules[${index}][exam_date]" class="form-control"></td>
                                    <td><input type="time" name="schedules[${index}][start_time]" class="form-control"></td>
                                    <td><input type="time" name="schedules[${index}][end_time]" class="form-control"></td>
                                    <td><input type="number" name="schedules[${index}][duration_time]" class="form-control"></td>
                                    <td><input type="text" name="schedules[${index}][room_no]" class="form-control"></td>
                                    <td><input type="number" name="schedules[${index}][full_mark]" class="form-control" step="any" min="1"></td>
                                    <td><input type="number" name="schedules[${index}][pass_mark]" class="form-control" step="any" min="1"></td>
                                </tr>
                            `);
                                });
                            } else {
                                $('#schedule-rows').append(
                                    `<tr><td colspan="8" class="text-center">No available subjects for this class and examination.</td></tr>`
                                    );
                            }
                        },
                        error: function() {
                            alert('Unable to fetch subjects. Please try again.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
