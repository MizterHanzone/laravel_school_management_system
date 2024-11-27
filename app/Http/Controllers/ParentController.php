<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    // path admin
    public function index()
    {
        $parents = User::OrderBy('id', 'desc')->where('role', 'parent')->get();
        return view('admin.parent_index', compact('parents'));
    }

    public function create()
    {
        return view('admin.parent_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:0,1',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|numeric|min:10',
            'photo' => "mimes:png,jpg,jpeg|max:2048",
        ]);

        $parent = new User();
        $parent->name = $request->name;
        $parent->last_name = $request->last_name;
        $parent->gender = $request->gender;
        $parent->email = $request->email;
        $parent->password = Hash::make($request->password);
        $parent->phone = $request->phone;
        $parent->role = 'parent';

        // Handle photo upload if it's provided
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension(); // Custom file name
            $photoPath = $photo->storeAs('parentImage', $photoName, 'public'); // Store in 'parentImage' folder
            $parent->photo = $photoPath;
        }

        $parent->save();

        return redirect()->route('parent.index')->with('success', 'Parent added successfully!');
    }

    public function edit($id)
    {
        $parent = User::findOrFail($id);
        return view('admin.parent_edit', compact('parent'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:0,1',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|numeric|min:10',
            'photo' => "mimes:png,jpg,jpeg|max:2048",
        ]);
        $parent = User::findOrFail($id);
        $parent->name = $request->name;
        $parent->last_name = $request->last_name;
        $parent->gender = $request->gender;
        $parent->email = $request->email;
        $parent->phone = $request->phone;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Delete the old photo from storage if it exists
            if ($parent->photo && file_exists(storage_path('app/public/' . $parent->photo))) {
                unlink(storage_path('app/public/' . $parent->photo));
            }

            // Store the new photo
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension(); // Custom file name
            $photoPath = $photo->storeAs('parentImage', $photoName, 'public');
            $parent->photo = $photoPath;
        }

        $parent->save();

        return redirect()->route('parent.index')->with('success', 'Parent updated successfully!');
    }

    // parth parent
    public function parent_dashboard()
    {
        return view('parent.dashboard');
    }

    public function parent_profile()
    {
        $parent = User::where('role', 'parent')->find(Auth::id());

        return view('parent.parent_profile', compact('parent'));
    }

    public function parent_change_password()
    {
        return view('parent.parent_update_password');
    }

    public function parent_update_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6|same:new_password',
        ]);

        $old_password = $request->old_password;
        $new_password = $request->new_password;

        $parent = User::find(Auth::user()->id);
        // dd($parent);
        if (Hash::check($old_password, $parent->password)) {
            $parent->password = $new_password;
            $parent->save();
            return redirect()->back()->with('success', 'Password changed successfully!');
        } else {
            return redirect()->back()->with('error', 'Old password do not have!');
        }
    }
}
