<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'description' => 'required|string',
        ]);

        Announcement::create($request->all());

        return redirect()->route('announcements.index')->with('success', 'Announcement added successfully!');
    }

public function userView()
{
    $announcements = Announcement::latest()->get();
    return view('announcements.user_index', compact('announcements'));
}

public function userIndex()
{
    $announcements = Announcement::latest()->get(); // or whatever query you need
    return view('announcements.user_index', compact('announcements'));
}
}


