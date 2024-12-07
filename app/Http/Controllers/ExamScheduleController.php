<?php

namespace App\Http\Controllers;

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

        // Capture the selected class ID
        $class_id = $request->input('class_id');

        // Default to an empty collection
        $exam_schedules = collect();

        if ($class_id) {
            // Fetch exam schedules for the selected class
            $exam_schedules = ExamSchedule::where('class_id', $class_id)
                ->with(['class', 'subject', 'examination'])
                ->get();

            // Debugging data
            Log::info('Selected Class ID:', ['class_id' => $class_id]);
            Log::info('Fetched Exam Schedules:', ['data' => $exam_schedules]);
        }

        // Pass data to the view
        return view('admin.exam_schedule_index', compact('classes', 'examinations', 'subjects', 'exam_schedules', 'class_id'));
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
        $classId = $request->input('class_id');
        $subjects = Subject::where('class_id', $classId)->get(['id', 'name']);
        return response()->json($subjects);
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
    public function edit(ExamSchedule $examSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamSchedule $examSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamSchedule $examSchedule)
    {
        //
    }
}
