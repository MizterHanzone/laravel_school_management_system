<?php

namespace App\Http\Controllers;

use App\Models\AssignSubjectToClass;
use App\Models\Classes;
use App\Models\Examination;
use App\Models\ExamSchedule;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExamScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch related data
        $classes = Classes::all();
        $examinations = Examination::all();
        $subjects = Subject::all();

        // Capture the selected class ID and examination ID
        $class_id = $request->input('class_id');
        $examination_id = $request->input('examination_id');

        // Default to an empty collection
        $exam_schedules = collect();

        // If class_id and examination_id are selected, filter the exam schedules accordingly
        if ($class_id && $examination_id) {
            $exam_schedules = ExamSchedule::where('class_id', $class_id)
                ->where('examination_id', $examination_id)
                ->with(['class', 'subject', 'examination'])
                ->get();
        } elseif ($class_id) {
            $exam_schedules = ExamSchedule::where('class_id', $class_id)
                ->with(['class', 'subject', 'examination'])
                ->get();
        } elseif ($examination_id) {
            $exam_schedules = ExamSchedule::where('examination_id', $examination_id)
                ->with(['class', 'subject', 'examination'])
                ->get();
        }

        // Debugging data
        // Log::info('Selected Class ID:', ['class_id' => $class_id]);
        // Log::info('Selected Examination ID:', ['examination_id' => $examination_id]);
        // Log::info('Fetched Exam Schedules:', ['data' => $exam_schedules]);

        // Pass data to the view
        return view('admin.exam_schedule_index', compact('classes', 'examinations', 'subjects', 'exam_schedules', 'class_id', 'examination_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classes::all();
        $examinations = Examination::all();

        return view('admin.exam_schedule_create', compact('classes', 'examinations'));
    }

    // Fetch subjects based on the selected class
    public function getSubjectsByClass(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:classes,id',
            'examination_id' => 'required|integer|exists:examinations,id',
        ]);

        $classId = $request->class_id;
        $examinationId = $request->examination_id;

        // Get subjects assigned to the class
        $assignedSubjects = AssignSubjectToClass::where('class_id', $classId)
            ->with('subject')
            ->get();

        // Get subject IDs already scheduled for the class and examination
        $scheduledSubjectIds = ExamSchedule::where('class_id', $classId)
            ->where('examination_id', $examinationId)
            ->pluck('subject_id')
            ->toArray();

        // Exclude already scheduled subjects
        $availableSubjects = $assignedSubjects->filter(function ($assign) use ($scheduledSubjectIds) {
            return !in_array($assign->subject->id, $scheduledSubjectIds);
        })->map(function ($assign) {
            return [
                'id' => $assign->subject->id,
                'name' => $assign->subject->name,
            ];
        });

        return response()->json($availableSubjects);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'examination_id' => 'required|exists:examinations,id',
            'class_id' => 'required|exists:classes,id',
            'schedules' => 'required|array',
            'schedules.*.subject_id' => 'required|exists:subjects,id',
            'schedules.*.exam_date' => 'required|date',
            'schedules.*.start_time' => 'required|date_format:H:i',
            'schedules.*.end_time' => 'required|date_format:H:i',
            'schedules.*.duration_time' => 'required|integer|min:1',
            'schedules.*.room_no' => 'required|string|max:20',
            'schedules.*.full_mark' => 'required|numeric|min:0',
            'schedules.*.pass_mark' => 'required|numeric|min:0',
        ]);

        // Insert each schedule into the database
        foreach ($request->input('schedules') as $schedule) {
            ExamSchedule::create([
                'examination_id' => $request->input('examination_id'),
                'class_id' => $request->input('class_id'),
                'subject_id' => $schedule['subject_id'],
                'exam_date' => $schedule['exam_date'],
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time'],
                'duration_time' => $schedule['duration_time'],
                'room_no' => $schedule['room_no'],
                'full_mark' => $schedule['full_mark'],
                'pass_mark' => $schedule['pass_mark'],
            ]);
        }

        return redirect()->route('exam.schedule.index')->with('success', 'Exam schedules added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the exam schedule by its ID
        $schedule = ExamSchedule::findOrFail($id);
        // Pass the schedule and other necessary data (like classes, examinations) to the view
        $classes = Classes::all(); // Or your specific method for getting classes
        $examinations = Examination::all(); // Or your specific method for getting examinations
        $subjects = Subject::all(); // Assuming you have a subject table or model

        return view('admin.exam_schedule_edit', compact('schedule', 'classes', 'examinations', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'examination_id' => 'required',
            'class_id' => 'required',
            'subject_id' => 'required',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'room_no' => 'required',
        ]);

        $exam_schedule = ExamSchedule::findOrFail($id);
        $exam_schedule->examination_id = $request->examination_id;
        $exam_schedule->class_id = $request->class_id;
        $exam_schedule->subject_id = $request->subject_id;
        $exam_schedule->exam_date = $request->exam_date;
        $exam_schedule->start_time = $request->start_time;
        $exam_schedule->end_time = $request->end_time;
        $exam_schedule->room_no = $request->room_no;
        $exam_schedule->save();

        return redirect()->route('exam.schedule.index')->with('success', 'Exam Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamSchedule $examSchedule)
    {
        //
    }
}
