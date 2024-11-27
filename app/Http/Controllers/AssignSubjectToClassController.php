<?php

namespace App\Http\Controllers;

use App\Models\AssignSubjectToClass;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;

class AssignSubjectToClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $assignSubjectToClasses = AssignSubjectToClass::with(['class', 'subject']);

        if ($request->has('class_id') && $request->class_id != '') {
            $assignSubjectToClasses = $assignSubjectToClasses->where('class_id', $request->class_id);
        }

        if ($request->has('subject_id') && $request->subject_id != '') {
            $assignSubjectToClasses = $assignSubjectToClasses->where('subject_id', $request->subject_id);
        }
        $assignSubjectToClasses = $assignSubjectToClasses->get();
        $classes = Classes::all();
        $subjects = Subject::all();

        return view('admin.assign_subject_index', compact('assignSubjectToClasses', 'classes', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $classes = Classes::where('status', 1)->get();
        $subjects = Subject::where('status', 1)->get();
        return view('admin.assign_subject_create', compact('classes', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required|array', // Ensure that subject_id is an array
            'subject_id.*' => 'exists:subjects,id', // Validate that each subject_id exists in the subjects table
            'status' => 'required|boolean', // Ensure status is provided as a boolean value (1 or 0)
        ]);

        $class_id = $request->class_id;
        $subject_ids = $request->subject_id;
        $status = $request->status; // Retrieve the status from the form

        // Loop through the subject IDs and assign to class
        foreach ($subject_ids as $subject_id) {
            AssignSubjectToClass::updateOrCreate(
                [
                    'class_id' => $class_id,
                    'subject_id' => $subject_id,
                ],
                [
                    'status' => $status,  // Use the status from the request
                ]
            );
        }

        // Redirect with success message
        return redirect()->route('assign_subject_to_class.index')->with('success', 'Assigned subject to class successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $assignSubjectToClasses = AssignSubjectToClass::find($id); // Use find instead of findOrFail
        if (!$assignSubjectToClasses) {
            return redirect()->route('assign_subject.index')->with('error', 'Record not found');
        }

        $classes = Classes::all();
        $subjects = Subject::all();

        return view('admin.assign_subject_edit', compact('assignSubjectToClasses', 'classes', 'subjects'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|array',
            'subject_id.*' => 'exists:subjects,id',
            'status' => 'required|boolean',
        ]);

        $class_id = $request->class_id;
        $subject_ids = $request->subject_id; // Get the array of subject IDs
        $status = $request->status; // Get the status from the request

        // Loop through the subject IDs and either update or create the records
        foreach ($subject_ids as $subject_id) {
            AssignSubjectToClass::updateOrCreate(
                [
                    'class_id' => $class_id,
                    'subject_id' => $subject_id,
                ],
                [
                    'status' => $status,  // Use the status from the request
                ]
            );
        }

        return redirect()->route('assign_subject_to_class.index')->with('success', 'Subjects updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $assignSubjectToClass = AssignSubjectToClass::findOrFail($id);
        $assignSubjectToClass->delete();

        return redirect()->route('assign_subject_to_class.index')->with('success', 'Subjects deleted successfully!');
    }
}
