<?php

namespace App\Http\Controllers;

use App\Models\AssignClassToTeacher;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Request;

class AssignClassToTeacherController extends Controller
{
    //
    public function index(Request $request)
    {
        // Get all classes
        $classes = Classes::all();

        // Query teacher classes with filter if class_id is provided
        $query = AssignClassToTeacher::with(['classes', 'user']);

        if ($request->has('class_id') && $request->class_id != '') {
            $query->where('class_id', $request->class_id);
        }

        $teacher_classes = $query->get();

        return view('admin.assign_class_teacher_index', compact('teacher_classes', 'classes'));
    }


    public function create()
    {
        $teachers = User::where('role', 'teacher')->get(); // Assuming users have roles
        $classes = Classes::all(); // Get all classes
        return view('admin.assign_class_teacher_create', compact('teachers', 'classes'));
    }


    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'user_ids' => 'required|array', // Ensure at least one teacher is selected
            'user_ids.*' => 'exists:users,id', // Ensure each teacher exists in the users table
            'class_id' => 'required|exists:classes,id', // Ensure class exists
        ]);

        // Get the class_id from the request
        $class_id = $request->class_id;

        // Attach the selected teachers to the class
        $class = Classes::find($class_id);

        // Attach multiple teachers to the class using the user_ids array
        $class->teachers()->sync($request->user_ids); // sync will add teachers and remove any previous assignments

        // Return success message or redirect to a relevant page
        return redirect()->route('assign.classe.to.teacher')->with('success', 'Teachers successfully assigned to the class.');
    }

    public function edit($id)
    {
        // Find the specific assignment
        $teacher_class = AssignClassToTeacher::with(['class', 'teacher'])->findOrFail($id);

        // Fetch all classes and teachers
        $classes = Classes::all();
        $teachers = User::where('role', 'teacher')->get();

        // Pass data to the view
        return view('admin.assign_class_teacher_edit', compact('teacher_class', 'classes', 'teachers'));
    }

    public function update(Request $request, $class_id)
    {
        // Validate the input data
        $request->validate([
            'user_ids' => 'required|array', // Ensure at least one teacher is selected
            'user_ids.*' => 'exists:users,id', // Ensure each teacher exists in the users table
        ]);

        // Find the class to update
        $class = Classes::findOrFail($class_id);

        // Update the teachers assigned to the class using the user_ids array
        $class->teachers()->sync($request->user_ids); // sync will update the assignments

        // Return success message or redirect to a relevant page
        return redirect()->route('assign.classe.to.teacher')->with('success', 'Teachers successfully updated for the class.');
    }

    public function destroy($id)
    {
        $teacher_class = AssignClassToTeacher::findOrFail($id);
        $teacher_class->delete();

        return redirect()->route('assign.classe.to.teacher')->with('success', 'Teachers successfully unassigned to the class.');
    }
}
