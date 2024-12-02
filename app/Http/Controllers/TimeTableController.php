<?php

namespace App\Http\Controllers;

use App\Models\AssignSubjectToClass;
use App\Models\Classes;
use App\Models\Day;
use App\Models\Subject;
use App\Models\TimeTable;
use Illuminate\Http\Request;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $days = Day::all();
        $classes = Classes::all();
        $subjects = Subject::all();

        $class_id = $request->input('class_id');
        $timeTables = null;

        if ($class_id) {
            // Fetch time table data for the selected class
            $timeTables = TimeTable::where('class_id', $class_id)
                ->with(['class', 'subject', 'day'])
                ->get();
        }

        return view('admin.time_table_index', compact('days', 'classes', 'subjects', 'timeTables', 'class_id'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classes::all(); // Replace `ClassModel` with your actual class model
        $days = Day::all(); // Assuming you have a `Day` model
        $subjects = Subject::all(); // Load all subjects for initial use

        return view('admin.time_table_create', compact('classes', 'days', 'subjects'));
    }


    /**
     * Store a newly created time table in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'class_id' => 'required|integer|exists:classes,id',
                'time_tables' => 'required|array',
                'time_tables.*.day_id' => 'required|integer|exists:days,id',
                'time_tables.*.subject_id' => 'nullable|integer|exists:subjects,id',
                'time_tables.*.start_time' => 'nullable|date_format:H:i',
                'time_tables.*.end_time' => 'nullable|date_format:H:i',
                'time_tables.*.room_no' => 'nullable|string',
            ]);

            // Loop through each time table entry and store them
            foreach ($validated['time_tables'] as $timeTable) {
                TimeTable::create([
                    'class_id' => $validated['class_id'],
                    'day_id' => $timeTable['day_id'], // Ensure 'day_id' is being passed
                    'subject_id' => $timeTable['subject_id'],
                    'start_time' => $timeTable['start_time'],
                    'end_time' => $timeTable['end_time'],
                    'room_no' => $timeTable['room_no'],
                ]);
            }

            return redirect()->route('time.table.index')->with('success', 'Time Table saved successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get subjects for the selected class via AJAX.
     */
    public function getSubjectsByClass(Request $request)
    {
        $request->validate(['class_id' => 'required|integer|exists:classes,id']);

        $subjects = AssignSubjectToClass::where('class_id', $request->class_id)
            ->with('subject')
            ->get()
            ->map(function ($assign) {
                return [
                    'id' => $assign->subject->id,
                    'name' => $assign->subject->name,
                ];
            });

        return response()->json($subjects);
    }

    /**
     * Show the form for editing the specified time table entry.
     */
    /**
     * Show the form for editing the specified time table entry.
     */
    public function edit($id)
    {
        $timeTable = TimeTable::with('timeTables')->findOrFail($id);
        $classes = Classes::all();
        $days = Day::all();
        $subjects = Subject::all();

        return view('admin.time_table_edit', compact('timeTable', 'classes', 'days', 'subjects'));
    }

    /**
     * Update the specified time table entry in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:classes,id',
            'time_tables' => 'required|array',
            'time_tables.*.day_id' => 'required|integer|exists:days,id',
            // 'time_tables.*.subject_id' => 'nullable|integer|exists:subjects,id',
            // 'time_tables.*.start_time' => 'nullable|date_format:H:i',
            // 'time_tables.*.end_time' => 'nullable|date_format:H:i',
            // 'time_tables.*.room_no' => 'nullable|string',
        ]);

        try {
            $classId = $request->class_id;

            // Retrieve existing time table for the given class
            $timeTableEntries = TimeTable::where('class_id', $classId)->get();

            $updatedIds = [];

            foreach ($request->time_tables as $entry) {
                $timeTable = TimeTable::updateOrCreate(
                    [
                        'id' => $entry['id'] ?? null, // Check if this entry already exists
                        'class_id' => $classId,
                    ],
                    [
                        'day_id' => $entry['day_id'],
                        'subject_id' => $entry['subject_id'],
                        'start_time' => $entry['start_time'],
                        'end_time' => $entry['end_time'],
                        'room_no' => $entry['room_no'],
                    ]
                );

                $updatedIds[] = $timeTable->id;
            }

            // Delete any time table entries that were not part of the updated IDs
            $timeTableEntries->whereNotIn('id', $updatedIds)->each(function ($entry) {
                $entry->delete();
            });

            return redirect()->route('time.table.index')->with('success', 'Time Table updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($class_id)
    {
        try {
            // Delete all time tables for the specified class_id
            TimeTable::where('class_id', $class_id)->delete();

            return redirect()->route('time.table.index')->with('success', 'All time table entries for the class have been deleted.');
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
            ]);
        }
    }
}
