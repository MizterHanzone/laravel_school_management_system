<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    // part admin
    public function index(Request $request)
    {
        $query = User::where('role', 'teacher');

        // Apply filters if they are provided
        if ($request->filled('date_of_join_from') && $request->filled('date_of_join_to')) {
            $query->whereBetween('date_of_join', [$request->date_of_join_from, $request->date_of_join_to]);
        } elseif ($request->filled('date_of_join_from')) {
            $query->where('date_of_join', '>=', $request->date_of_join_from);
        } elseif ($request->filled('date_of_join_to')) {
            $query->where('date_of_join', '<=', $request->date_of_join_to);
        }

        if ($request->filled('teacher_status')) {
            $query->where('teacher_status', $request->teacher_status);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $teachers = $query->get();

        return view('admin.teacher_index', compact('teachers'));
    }


    public function create()
    {
        return view('admin.teacher_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:0,1', // Male (1) or Female (0)
            'dob' => 'required|date|before:today', // Date of birth must be a valid date and in the past
            'religion' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Ensure unique email in users table
            'password' => 'required|string|min:6',
            'phone' => 'required|numeric|digits_between:10,15', // Ensure phone number is numeric and between 10-15 digits
            'date_of_join' => 'required|date', // Date of joining must be a valid date and in the past
            'marital_status' => 'nullable|in:single,married,divorced,widowed', // Ensure valid marital status
            'current_address' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'teacher_status' => 'required|in:0,1', // Ensure active (1) or inactive (0) status
            'photo' => 'nullable|max:2048', // Validate photo file
        ]);

        // Handle storing the teacher's data if validation passes
        $teacher = new User();
        $teacher->name = $request->name;
        $teacher->last_name = $request->last_name;
        $teacher->gender = $request->gender;
        $teacher->dob = $request->dob;
        $teacher->religion = $request->religion;
        $teacher->email = $request->email;
        $teacher->password = Hash::make($request->password);
        $teacher->phone = $request->phone;
        $teacher->date_of_join = $request->date_of_join;
        $teacher->marital_status = $request->marital_status;
        $teacher->current_address = $request->current_address;
        $teacher->qualification = $request->qualification;
        $teacher->experience = $request->experience;
        $teacher->teacher_status = $request->teacher_status;
        $teacher->role = "teacher";

        // Handle photo upload if provided
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photoPath = $photo->storeAs('teacherImage', $photoName, 'public');
            $teacher->photo = $photoPath;
        }

        $teacher->save();

        return redirect()->route('teacher.index')->with('success', 'Teacher added successfully!');
    }

    public function edit($id)
    {
        $teacher = User::findOrFail($id);
        return view('admin.teacher_edit', compact('teacher'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:0,1',
            'dob' => 'required|date|before:today',
            'religion' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|numeric|digits_between:10,15',
            'date_of_join' => 'required|date',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'current_address' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'teacher_status' => 'required|in:0,1',
            'photo' => 'nullable|mimes:jpeg,jpg,png|max:2048',
        ]);
        $teacher = User::findOrFail($id);
        $teacher->name = $request->name;
        $teacher->last_name = $request->last_name;
        $teacher->gender = $request->gender;
        $teacher->dob = $request->dob;
        $teacher->religion = $request->religion;
        $teacher->email = $request->email;
        $teacher->phone = $request->phone;
        $teacher->date_of_join = $request->date_of_join;
        $teacher->marital_status = $request->marital_status;
        $teacher->current_address = $request->current_address;
        $teacher->qualification = $request->qualification;
        $teacher->experience = $request->experience;
        $teacher->teacher_status = $request->teacher_status;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Delete the old photo from storage if it exists
            if ($teacher->photo && file_exists(storage_path('app/public/' . $teacher->photo))) {
                unlink(storage_path('app/public/' . $teacher->photo));
            }

            // Store the new photo
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension(); // Custom file name
            $photoPath = $photo->storeAs('teacherImage', $photoName, 'public');
            $teacher->photo = $photoPath;
        }

        $teacher->save();

        return redirect()->route('teacher.index')->with('success', 'Teacher updated successfully!');
    }

    public function destroy($id)
    {
        $teacher = User::findOrFail($id);
        $teacher->delete();

        return redirect()->route('teacher.index')->with('success', 'Teacher created successfully!');
    }

    // part teacher
    public  function teacher_dashboard()
    {
        return view('teacher.dashboard');
    }

    public function teacher_profile()
    {
        $teacher = Auth::user();
        return view('teacher.teacher_profile', compact('teacher'));
    }

    public function teacher_change_password()
    {
        return view('teacher.teacher_update_password');
    }

    public function teacher_update_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6|same:new_password',
        ]);

        $old_password = $request->old_password;
        $new_password = $request->new_password;

        $teacher = User::find(Auth::user()->id);
        // dd($teacher);
        if (Hash::check($old_password, $teacher->password)) {
            $teacher->password = $new_password;
            $teacher->save();
            return redirect()->back()->with('success', 'Password changed successfully!');
        } else {
            return redirect()->back()->with('error', 'Old password do not have!');
        }
    }

    // public function my_classes_subjects()
    // {
    //     $teacher = Auth::user();

    //     // Get classes assigned to the teacher
    //     $classes = $teacher->classes;

    //     // Get subjects assigned to those classes
    //     $subjects = Subject::whereIn('id', function ($query) use ($classes) {
    //         $query->select('subject_id')
    //             ->from('assign_subject_to_classes')
    //             ->whereIn('class_id', $classes->pluck('id'));
    //     })->get();

    //     return view('teacher.my_classes_subjects', compact('classes', 'subjects'));
    // }

    public function my_classes_subjects()
    {
        $teacherId = Auth::id(); // Get the authenticated teacher's ID

        // Fetch classes assigned to the teacher
        $classes = Classes::whereHas('teachers', function ($query) use ($teacherId) {
            $query->where('user_id', $teacherId); // Ensure the teacher is assigned to the class
        })
            ->with([
                'subjects', // Load the subjects for the class
                'timeTables' // Load the timetables for the class
            ])
            ->get();

        return view('teacher.my_classes_subjects', compact('classes'));
    }

    public function get_students_in_teacher_classes()
    {
        $teacher = Auth::user();

        // Get the teacher's class IDs from the pivot table
        $classIds = DB::table('class_teacher') // Pivot table name
            ->where('user_id', $teacher->id)
            ->pluck('class_id');

        // Fetch all students in those classes
        $students = User::where('role', 'student') // Assuming 'role' distinguishes user roles
            ->whereIn('class_id', $classIds) // Assuming students have a class_id column
            ->get();

        // Fetch class details
        $classes = Classes::whereIn('id', $classIds)->get();

        return view('teacher.my_students_in_classes', compact('students', 'classes'));
    }
}
