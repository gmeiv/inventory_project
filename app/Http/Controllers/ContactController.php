<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        $data = $request->only('name', 'email', 'message');

        Mail::html("
            <h2>{$data['name']} Message to ARICC Inventory</h2>
            <p><strong>Name:</strong> {$data['name']}</p>
            <p><strong>Email:</strong> {$data['email']}</p>
            <p><strong>Message:</strong><br>{$data['message']}</p>
        ", function ($msg) use ($data) {
            $msg->to('bulsudioariccs@gmail.com')
                ->from($data['email'], $data['name'])
                ->subject('Message - ARICC Inventory');
        });

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
