<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'surname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'firstname' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:20',
            'role' => 'required|in:Student,Faculty Member,Staff,Others',
            'department' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'surname' => $request->surname,
            'middlename' => $request->middlename,
            'firstname' => $request->firstname,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'department' => $request->department,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Member deleted successfully.');
    }
}
