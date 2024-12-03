<?php

namespace App\Http\Controllers;

use App\Models\AcademiYear;
use App\Models\Classes;
use App\Models\TimeTable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentControllercls extends Controller
{
    // path admin
    public function index(Request $request)
    {
        $studentsQuery = User::with('class', 'academiYear')->where('role', 'student');
        if ($request->has('class_id') && $request->class_id != '') {
            $studentsQuery->where('class_id', $request->class_id);
        }

        if ($request->has('acdemi_year_id') && $request->acdemi_year_id != '') {
            $studentsQuery->where('acdemi_year_id', $request->acdemi_year_id);
        }

        if ($request->filled('gender')) {
            $studentsQuery->where('gender', $request->gender);
        }

        if ($request->has('status') && $request->status != '') {
            $studentsQuery->where('status', $request->status);
        }

        $students = $studentsQuery->orderBy('id', 'desc')->get();
        $classes = Classes::all();
        $academi_years = AcademiYear::all();

        return view('admin.student_index', compact('students', 'classes', 'academi_years'));
    }

    public function create()
    {
        $academi_years = AcademiYear::all();
        $classes = Classes::all();
        return view('admin.student_create', compact('classes', 'academi_years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:0,1', // 0 for female, 1 for male
            'dob' => 'required|date',
            'religion' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6', // assuming you have a password confirmation field
            'phone' => 'required|numeric|min:10',
            'admission_date' => 'required|date',
            'acdemi_year_id' => 'required|exists:academi_years,id',
            'class_id' => 'required|exists:classes,id',
            'status' => 'required|in:Studying,Drop Out,Graduation', // Validates the status field
            // 'image' => "mimes:png,jpg,jpeg|max:2048", 
            'photo' => "mimes:png,jpg,jpeg|max:2048", // Optional, but if provided must be a valid image
        ]);

        // Create the student
        $student = new User();
        $student->name = $request->name;
        $student->last_name = $request->last_name;
        $student->gender = $request->gender;
        $student->dob = $request->dob;
        $student->religion = $request->religion;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->phone = $request->phone;
        $student->admission_date = $request->admission_date;
        $student->acdemi_year_id = $request->acdemi_year_id;
        $student->class_id = $request->class_id;
        $student->status = $request->status;

        // Handle the photo upload
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension(); // Custom file name
            $photoPath = $photo->storeAs('studentImage', $photoName, 'public');
            $student->photo = $photoPath;
        }
        // dd($student->all());

        $student->save();

        return redirect()->route('student.index')->with('success', 'Student added successfully!');
    }

    public function edit($id)
    {
        $student = User::findOrFail($id);
        $classes = Classes::all();
        $academi_years = AcademiYear::all();

        // Return to edit view with student data
        return view('admin.student_edit', compact('student', 'classes', 'academi_years'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:0,1', // 0 for female, 1 for male
            'dob' => 'required|date',
            'religion' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Ensure unique email, except for this student
            'phone' => 'required|numeric|min:10',
            'admission_date' => 'required|date',
            'acdemi_year_id' => 'required|exists:academi_years,id',
            'class_id' => 'required|exists:classes,id',
            'status' => 'required|in:Studying,Drop Out,Graduation', // Validates the status field
            'photo' => "mimes:png,jpg,jpeg|max:2048", // Optional image validation
        ]);

        // Find the student by ID
        $student = User::findOrFail($id);

        // Update student data
        $student->name = $request->name;
        $student->last_name = $request->last_name;
        $student->gender = $request->gender;
        $student->dob = $request->dob;
        $student->religion = $request->religion;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->admission_date = $request->admission_date;
        $student->acdemi_year_id = $request->acdemi_year_id;
        $student->class_id = $request->class_id;
        $student->status = $request->status;

        // Handle photo upload if a new photo is provided
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Delete the old photo from storage if it exists
            if ($student->photo && file_exists(storage_path('app/public/' . $student->photo))) {
                unlink(storage_path('app/public/' . $student->photo));
            }

            // Store the new photo
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension(); // Custom file name
            $photoPath = $photo->storeAs('studentImage', $photoName, 'public');
            $student->photo = $photoPath;
        }

        // Save updated student record
        $student->save();

        // Redirect with success message
        return redirect()->route('student.index')->with('success', 'Student updated successfully!');
    }

    public function destroy($id)
    {
        $student = User::findOrFail($id);
        $student->delete();

        return redirect()->route('student.index')->with('success', 'Student deleted successfully!');
    }

    // part student
    public function student_dashboard()
    {
        return view('student.dashboard');
    }

    public function profile()
    {
        $student = User::with(['class', 'academiYear'])->find(Auth::id());
        return view('student.student_profile', compact('student'));
    }

    public function student_change_password()
    {
        return view('student.student_update_password');
    }

    public function student_update_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6|same:new_password',
        ]);

        $old_password = $request->old_password;
        $new_password = $request->new_password;

        $student = User::find(Auth::user()->id);
        // dd($student);
        if (Hash::check($old_password, $student->password)) {
            $student->password = $new_password;
            $student->save();
            return redirect()->back()->with('success', 'Password changed successfully!');
        } else {
            return redirect()->back()->with('error', 'Old password do not have!');
        }
    }

    public function my_subject()
    {
        $student = Auth::user(); // Get the authenticated student

        // Load subjects for the student's class
        $subjects = $student->class->subjects ?? collect();

        return view('student.my_subjects', compact('subjects'));
    }

    public function my_time_table()
    {
        // Assuming a student is logged in and their class_id is stored in their profile
        $student = Auth::user();
        $class_id = $student->class_id;

        // Fetch the timetable for the student's class
        $timeTables = TimeTable::where('class_id', $class_id)
            ->with(['day', 'subject'])
            ->orderBy('day_id')
            ->orderBy('start_time')
            ->get();

        return view('student.my_time_table', compact('timeTables'));
    }
}
