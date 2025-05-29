<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::when(request('query'), function($q) {
                $q->where('fullname', 'like', '%' . request('query') . '%');
            })
            ->when(request('user_role'), function($q) {
                $q->where('user_role', request('user_role'));
            })
            ->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:50',
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'regex:/[0-9]/', // at least one number
                'regex:/[^A-Za-z0-9]/', // at least one special character
            ],
            'user_role' => 'required|string|in:Student,Admin',
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must include at least one number and one special symbol.',
        ]);

        User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'user_role' => $request->user_role,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:50',
            'user_role' => 'required|in:Student,Admin',
            'current_password' => 'required|string',
            'password' => [
                'nullable',
                'string',
                'confirmed',
                'min:8',
                'regex:/[0-9]/', // at least one number
                'regex:/[^A-Za-z0-9]/', // at least one special character
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must include at least one number and one special symbol.',
        ]);

        // Check current password
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'user_role' => $request->user_role,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
