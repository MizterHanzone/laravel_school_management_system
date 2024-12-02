@extends('admin.layouts.layouts')
@section('title', 'Edit Time Table')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Time Table</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Time Table</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card card-primary">
                            <form action="{{ route('time.table.update', $timeTable->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="class_id">Class</label>
                                        <select name="class_id" id="class_id" class="form-control" required>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ $timeTable->class_id == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="time_tables">Time Table Entries</label>
                                        <div id="time-tables">
                                            @foreach ($timeTable->timeTables as $entry)
                                                <div class="row mb-2">
                                                    <div class="col-md-2">
                                                        <select name="time_tables[{{ $loop->index }}][day_id]" class="form-control">
                                                            @foreach ($days as $day)
                                                                <option value="{{ $day->id }}"
                                                                    {{ $entry->day_id == $day->id ? 'selected' : '' }}>
                                                                    {{ $day->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="time_tables[{{ $loop->index }}][subject_id]" class="form-control">
                                                            @foreach ($subjects as $subject)
                                                                <option value="{{ $subject->id }}"
                                                                    {{ $entry->subject_id == $subject->id ? 'selected' : '' }}>
                                                                    {{ $subject->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="time" name="time_tables[{{ $loop->index }}][start_time]"
                                                            class="form-control" value="{{ $entry->start_time }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="time" name="time_tables[{{ $loop->index }}][end_time]"
                                                            class="form-control" value="{{ $entry->end_time }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="time_tables[{{ $loop->index }}][room_no]"
                                                            class="form-control" placeholder="Room No"
                                                            value="{{ $entry->room_no }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success">Update Time Table</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
