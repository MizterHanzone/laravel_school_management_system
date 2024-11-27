<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //
    public function login()
    {
        if (Auth::check()) {
            // Redirect based on the user role
            $role = Auth::user()->role;
            switch ($role) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'student':
                    return redirect('/student/dashboard');
                case 'teacher':
                    return redirect('/teacher/dashboard');
                case 'parent':
                    return redirect('/parent/dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login');
            }
        }
        return view('auth.login');
    }


    public function authentication(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            // Redirect based on user role
            $role = Auth::user()->role;
            switch ($role) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'student':
                    return redirect('/student/dashboard');
                case 'teacher':
                    return redirect('/teacher/dashboard');
                case 'parent':
                    return redirect('/parent/dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Email or Password incorrect!');
            }
        } else {
            return redirect()->back()->with('error', 'Email or Password incorrect!');
        }
    }



    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }

    public function forgot_password()
    {
        return view('auth.forgo_password');
    }

    public function confirm_forgot_password(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Retrieve the user by email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Ensure the user exists and has a valid email
            $user->remember_token = Str::random(30); // Set the remember_token
            $user->save(); // Save the user with the new token

            // Send the password reset email
            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->with('success', 'Please check your email.');
        } else {
            // If no user is found, redirect back with error
            return redirect()->back()->with('error', 'Email address not found.');
        }
    }
}
