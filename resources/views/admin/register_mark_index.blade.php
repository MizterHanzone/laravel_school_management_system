@extends('admin.layouts.layouts')

@section('title', 'Registered Marks')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Registered Marks</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Filter Form -->
            <form action="{{ route('register.mark.index') }}" method="GET">
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
                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                    </div>
                </div>
            </form>

            <!-- Registered Marks Table -->
            @if($registerMarks->isNotEmpty())
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        @foreach($subjects as $subject)
                            <th>{{ $subject->name }}</th>
                        @endforeach
                        <th>Average</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registerMarks->groupBy('student_id') as $studentId => $marks)
                        @php
                            $totalMarks = $marks->sum('mark_obtained');
                            $subjectCount = $marks->count();
                            $average = $subjectCount > 0 ? number_format($totalMarks / $subjectCount, 2) : 0;
                            $overallResult = $marks->every(fn($mark) => $mark->result === 'Pass') ? 'Pass' : 'Fail';
                        @endphp
                        <tr>
                            <td>{{ $marks->first()->student->name }}</td>
                            @foreach($subjects as $subject)
                                @php
                                    $mark = $marks->where('subject_id', $subject->id)->first();
                                    $subjectResult = $mark ? $mark->result : '-';
                                @endphp
                                <td>
                                    {{ $mark ? $mark->mark_obtained : '-' }}<br>
                                    <strong>{{ $subjectResult }}</strong>
                                </td>
                            @endforeach
                            <td>{{ $average }}</td>
                            <td>{{ $overallResult }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="mt-4">No marks registered for the selected class and examination.</p>
            @endif
        </div>
    </section>
</div>
@endsection
