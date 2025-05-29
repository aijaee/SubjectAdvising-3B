<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle the registration form submission
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:50',
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'regex:/[0-9]/', // at least one number
                'regex:/[^A-Za-z0-9]/', // at least one special character
            ],
            'user_role' => 'required|in:Student,Admin',
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must include at least one number and one special symbol.',
        ]);

        User::create([
            'fullname' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone,
            'user_role' => $request->user_role,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }
}
