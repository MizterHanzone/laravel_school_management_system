<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function admin_list()
    {
        $admins = User::where('role', 'admin')->orderBy('id', 'desc')->get();
        return view('admin.admin_list', compact('admins'));
    }

    public function admin_create()
    {
        return view('admin.admin_create');
    }

    public function admin_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'photo' => 'nullable|max:2048',
        ]);

        $admin = new User();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = $request->name;
        $admin->role = 'admin';

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension(); // Custom file name
            $photoPath = $photo->storeAs('adminImage', $photoName, 'public'); // Store in 'parentImage' folder
            $admin->photo = $photoPath;
        }

        $admin->save();

        return redirect()->route('admin.list')->with('success', 'Admin created successfully!');
    }

    public function admin_edit($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.admin_edit', compact('admin'));
    }

    public function admin_update(Request $request, $id)
    {
        $admin = User::findOrFail($request->id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'photo' => 'nullable|max:2048',
        ]);
        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Delete the old photo from storage if it exists
            if ($admin->photo && file_exists(storage_path('app/public/' . $admin->photo))) {
                unlink(storage_path('app/public/' . $admin->photo));
            }

            // Store the new photo
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension(); // Custom file name
            $photoPath = $photo->storeAs('adminImage', $photoName, 'public');
            $admin->photo = $photoPath;
        }
        $admin->save();

        return redirect()->route('admin.list')->with('success', 'Admin updated successfully!');
    }

    public function admin_delete($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.list')->with('success', 'Admin deleted successfully!');
    }

    public function admin_change_password()
    {
        return view('admin.admin_update_password');
    }

    public function admin_update_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6|same:new_password',
        ]);

        $old_password = $request->old_password;
        $new_password = $request->new_password;

        $admin = User::find(Auth::user()->id);
        // dd($admin);
        if (Hash::check($old_password, $admin->password)) {
            $admin->password = $new_password;
            $admin->save();
            return redirect()->back()->with('success', 'Password changed successfully!');
        } else {
            return redirect()->back()->with('error', 'Old password do not have!');
        }
    }
}
