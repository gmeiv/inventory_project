<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminRegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'surname' => 'required',
            'firstname' => 'required',
            'department' => 'required',
            'position' => 'required',
            'employment_type' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|confirmed|min:6',
        ]);

        Admin::create([
            'surname' => $request->surname,
            'middlename' => $request->middlename,
            'firstname' => $request->firstname,
            'department' => $request->department,
            'position' => $request->position,
            'employment_type' => $request->employment_type,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admins.index')->with('success', 'Admin registered successfully.');
    }

    public function browse()
{
    $admins = \App\Models\Admin::all();
    return view('browse_admins', compact('admins'));
}
public function destroy($id)
{
    \App\Models\Admin::destroy($id);
    return redirect()->route('admins.index')->with('success', 'Admin deleted successfully.');
}
public function index()
{
    $admins = Admin::all();
    return view('admins.index', compact('admins'));
}
}

