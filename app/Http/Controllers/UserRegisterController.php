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
            'surname' => 'required',
            'middlename' => 'nullable',
            'firstname' => 'required',
            'department' => 'required',
            'course' => 'required',
            'year_level' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'surname' => $request->surname,
            'middlename' => $request->middlename,
            'firstname' => $request->firstname,
            'department' => $request->department,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful!');
    }
}
