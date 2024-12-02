@extends('admin.layouts.layouts')

@section('title', 'Add Time Table')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Time Table</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('time.table.index') }}">Time Table List</a></li>
                            <li class="breadcrumb-item active">Add Time Table</li>
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
                                <h3 class="card-title">Add Time Table</h3>
                            </div>
                            <form action="{{ route('time.table.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <!-- Class Selection -->
                                    <div class="form-group">
                                        <label for="class_id">Select Class</label>
                                        <select name="class_id" id="class_id" class="form-control">
                                            <option value="" disabled {{ old('class_id') ? '' : 'selected' }}>Select
                                                Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
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
                                                <th>Day</th>
                                                <th>Subject</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Room Number</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($days as $index => $day)
                                                <tr>
                                                    <td>
                                                        {{ $day->name }}
                                                        <input type="hidden"
                                                            name="time_tables[{{ $index }}][day_id]"
                                                            value="{{ $day->id }}">
                                                    </td>
                                                    <td>
                                                        <!-- Subject Selection for each day -->
                                                        <select name="time_tables[{{ $index }}][subject_id]" class="form-control subject-select">
                                                            <option value="" disabled selected>Select Subject</option>
                                                            @foreach ($subjects as $subject)
                                                                <option value="{{ $subject->id }}">
                                                                    {{ $subject->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error("time_tables.$index.subject_id")
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror                                                        
                                                    </td>
                                                    <td>
                                                        <input type="time"
                                                            name="time_tables[{{ $index }}][start_time]"
                                                            class="form-control"
                                                            value="{{ old('time_tables.' . $index . '.start_time') }}">
                                                        @error("time_tables.$index.start_time")
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="time"
                                                            name="time_tables[{{ $index }}][end_time]"
                                                            class="form-control"
                                                            value="{{ old('time_tables.' . $index . '.end_time') }}">
                                                        @error("time_tables.$index.end_time")
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="time_tables[{{ $index }}][room_no]"
                                                            class="form-control"
                                                            value="{{ old('time_tables.' . $index . '.room_no') }}">
                                                        @error("time_tables.$index.room_no")
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Submit Button -->
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
        $('#class_id').change(function() {
            var classId = $(this).val();
            if (classId) {
                $.ajax({
                    url: '{{ route('get.subjects.by.class') }}',
                    type: 'GET',
                    data: {
                        class_id: classId
                    },
                    success: function(response) {
                        $('.subject-select').each(function() {
                            $(this).empty().append('<option value="">Select Subject</option>');
                            $.each(response, function(index, subject) {
                                $(this).append('<option value="' + subject.id + '">' +
                                    subject.name + '</option>');
                            }.bind(this));
                        });
                    }
                });
            }
        });
    </script>
@endsection
