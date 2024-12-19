<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classes = Classes::all();

        $query = StudentAttendance::with(['student', 'class']);

        // Apply class filter if a class is selected
        if ($request->has('class_id') && $request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(10);

        return view('admin.student_attendance_index', compact('classes', 'attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $classes = Classes::all();
        $students = null;

        if ($request->has('class_id') && $request->class_id) {
            $students = User::where('role', 'student')
                ->where('class_id', $request->class_id)
                ->get();
        }

        return view('admin.student_attendance_create', compact('classes', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
        ]);

        foreach ($request->attendance as $student_id => $status) {
            // Add attendance for each student on the given date
            StudentAttendance::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'class_id' => $request->class_id,
                    'date' => $request->date,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return redirect()->route('student.attendance.index')->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentAttendance $studentAttendance)
    {
        //
    }
}
