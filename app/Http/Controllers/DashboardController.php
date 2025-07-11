<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowRequest;
use App\Models\User;
use App\Models\Item;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard'); // blade file: resources/views/dashboard.blade.php
    }

    // Show pending borrow requests
    public function showPendingRequests()
    {
        $pendingRequests = BorrowRequest::where('status', 'pending')->with('user')->get();
        return view('admins.accept-requests', compact('pendingRequests'));
    }

    // Accept a borrow request
    public function acceptRequest($id)
    {
        $request = BorrowRequest::findOrFail($id);
        $item = Item::findOrFail($request->serial_number);
        if ($item->stocks < 1) {
            return redirect()->back()->with('error', 'Not enough stock to fulfill this request.');
        }
        $item->stocks -= 1;
        $item->save();
        $request->status = 'approved';
        $request->save();
        return redirect()->back()->with('success', 'Request accepted and stock updated.');
    }
}
