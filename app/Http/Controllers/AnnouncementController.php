<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\View;

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

        $announcement = Announcement::create($request->all());

        // ✅ Send to all users
        $users = User::all();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new class($announcement) extends Mailable {
                public $announcement;

                public function __construct($announcement)
                {
                    $this->announcement = $announcement;
                }

                public function build()
                {
                    return $this->subject('New Announcement: ' . $this->announcement->title)
                        ->html(View::make('emails.inline_announcement', ['announcement' => $this->announcement])->render());
                }
            });
        }

        return redirect()->route('announcements.index')->with('success', 'Announcement added and emailed successfully!');
    }

    public function userView()
    {
        $announcements = Announcement::latest()->get();
        return view('announcements.user_index', compact('announcements'));
    }

    public function userIndex()
    {
        $announcements = Announcement::latest()->get();
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
