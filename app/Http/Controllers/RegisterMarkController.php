<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Examination;
use App\Models\ExamSchedule;
use App\Models\RegisterMark;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterMarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch all classes and examinations for filters
        $classes = Classes::all();
        $examinations = Examination::all();

        // Get the selected class and examination from the filters
        $classId = $request->input('class_id');
        $examinationId = $request->input('examination_id');

        // Fetch registered marks based on selected filters
        $registerMarks = RegisterMark::with(['student', 'subject', 'class', 'examination'])
            ->where('class_id', $classId)
            ->where('examination_id', $examinationId)
            ->get();

        // Fetch subjects for the selected class and examination
        $subjects = ExamSchedule::where('class_id', $classId)
            ->where('examination_id', $examinationId)
            ->pluck('subject_id')
            ->map(function ($id) {
                return Subject::find($id);
            });

        return view('admin.register_mark_index', compact('classes', 'examinations', 'registerMarks', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Fetch all classes and examinations for the filters
        $classes = Classes::all();
        $examinations = Examination::all();

        // Check if filters are applied
        $classId = $request->class_id;
        $examinationId = $request->examination_id;

        // Fetch exam schedules for the selected class and examination
        $examSchedules = ExamSchedule::where('class_id', $classId)
            ->where('examination_id', $examinationId)
            ->get();

        // If no exam schedules are found, set subjects and students to empty
        $subjects = $examSchedules->isEmpty() ? collect() : $examSchedules->map->subject;
        $students = $examSchedules->isEmpty() ? collect() : User::where('role', 'student')
            ->where('class_id', $classId)
            ->get();

        return view('admin.register_mark_create', compact('classes', 'examinations', 'subjects', 'students', 'examSchedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->input('marks'); // Fetch marks input data
        $examinationId = $request->input('examination_id');
        $classId = $request->input('class_id');

        foreach ($data as $studentId => $subjects) {
            $totalMarks = 0;
            $subjectCount = count($subjects);
            $totalFullMarks = 0; // To store the sum of all full marks for subjects

            foreach ($subjects as $subjectId => $markData) {
                $markObtained = $markData['mark_obtained'];

                // Fetch the full mark and pass mark from ExamSchedule
                $examSchedule = ExamSchedule::where('examination_id', $examinationId)
                    ->where('class_id', $classId)
                    ->where('subject_id', $subjectId)
                    ->first();

                $fullMark = $examSchedule ? $examSchedule->full_mark : 100; // Default to 100 if not defined
                $passMark = $examSchedule ? $examSchedule->pass_mark : 0;

                // Determine subject result (Pass/Fail)
                $result = ($markObtained > 0 && $markObtained >= $passMark) ? 'Pass' : 'Fail';

                // Store each mark record
                RegisterMark::create([
                    'examination_id' => $examinationId,
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'class_id' => $classId,
                    'mark_obtained' => $markObtained,
                    'result' => $result,
                ]);

                // Add to total marks and total full marks for average calculation
                $totalMarks += $markObtained;
                $totalFullMarks += $fullMark;
            }

            // Calculate average result
            $averageResult = $subjectCount > 0 ? $totalMarks / $subjectCount : 0;

            // Determine overall result based on the average mark
            $overallResult = $totalMarks >= $totalFullMarks ? 'Pass' : 'Fail';

            // Update the student's average result and overall result
            RegisterMark::where('examination_id', $examinationId)
                ->where('student_id', $studentId)
                ->update([
                    'average_result' => number_format($averageResult, 2),
                    'overall_result' => $overallResult,
                ]);
        }

        return redirect()->route('register.mark.index')->with('success', 'Marks registered successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->input('marks'); // Fetch marks input data
        $examinationId = $request->input('examination_id');
        $classId = $request->input('class_id');

        foreach ($data as $studentId => $subjects) {
            $totalMarks = 0;
            $subjectCount = count($subjects);
            $totalFullMarks = 0; // Initialize total full marks

            foreach ($subjects as $subjectId => $markData) {
                $markObtained = $markData['mark_obtained'];

                // Fetch the pass mark from ExamSchedule
                $examSchedule = ExamSchedule::where('examination_id', $examinationId)
                    ->where('class_id', $classId)
                    ->where('subject_id', $subjectId)
                    ->first();

                $passMark = $examSchedule ? $examSchedule->pass_mark : 0;

                // Determine result (Pass/Fail)
                $result = ($markObtained > 0 && $markObtained >= $passMark) ? 'Pass' : 'Fail';

                // Update each mark record
                RegisterMark::updateOrCreate(
                    [
                        'examination_id' => $examinationId,
                        'student_id' => $studentId,
                        'subject_id' => $subjectId,
                        'class_id' => $classId,
                    ],
                    [
                        'mark_obtained' => $markObtained,
                        'result' => $result,
                    ]
                );

                // Add to total marks for average calculation
                $totalMarks += $markObtained;

                // Add to total full marks for overall result comparison
                $totalFullMarks += $examSchedule->full_mark ?? 100;
            }

            // Calculate average result
            $averageResult = $subjectCount > 0 ? $totalMarks / $subjectCount : 0;

            // Calculate overall result (Pass/Fail)
            $overallResult = $totalMarks >= $totalFullMarks ? 'Pass' : 'Fail';

            // Update the student's average result and overall result for this examination
            RegisterMark::where('examination_id', $examinationId)
                ->where('student_id', $studentId)
                ->update([
                    'average_result' => number_format($averageResult, 2),
                    // 'overall_result' => $overallResult, // If you don't want to store this, remove it
                ]);
        }

        return redirect()->route('register.mark.index')->with('success', 'Marks updated successfully.');
    }
}
