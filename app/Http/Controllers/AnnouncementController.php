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
public function edit($id)
{
    $announcement = Announcement::findOrFail($id);
    return view('announcements.edit', compact('announcement'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'date' => 'required',
        'time' => 'required',
        'description' => 'required',
    ]);

    $announcement = Announcement::findOrFail($id);
    $announcement->update($request->only(['title', 'date', 'time', 'description']));

    return redirect()->route('announcements.index')->with('success', 'Announcement updated.');
}



public function destroy($id)
{
    $announcement = Announcement::findOrFail($id);
    $announcement->delete();

    return redirect()->route('announcements.index');
}

}


