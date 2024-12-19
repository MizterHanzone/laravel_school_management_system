@extends('admin.layouts.layouts')

@section('title', 'Register Marks')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Register Marks</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Filter Form -->
            <form action="{{ route('register.mark.create') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <label for="class_id">Class</label>
                        <select name="class_id" id="class_id" class="form-control">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="examination_id">Examination</label>
                        <select name="examination_id" id="examination_id" class="form-control">
                            <option value="">Select Examination</option>
                            @foreach($examinations as $exam)
                                <option value="{{ $exam->id }}" {{ request('examination_id') == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary mt-4">Fetch</button>
                    </div>
                </div>
            </form>

            <!-- Marks Entry Form -->
            @if(!empty($students) && !empty($subjects))
            <form action="{{ route('register.mark.store') }}" method="POST">
                @csrf
                <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                <input type="hidden" name="examination_id" value="{{ request('examination_id') }}">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student</th>
                            @foreach($subjects as $subject)
                                <th>{{ $subject->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                @foreach($subjects as $subject)
                                    <td>
                                        <input type="number" name="marks[{{ $student->id }}][{{ $subject->id }}][mark_obtained]" class="form-control" required>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit" class="btn btn-success">Submit Marks</button>
            </form>
            @endif
        </div>
    </section>
</div>
@endsection
