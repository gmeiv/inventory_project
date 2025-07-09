<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\BorrowRequest;
use Illuminate\Support\Facades\Auth;

class UserBorrowController extends Controller
{
    // Show all items to borrow
    public function browse()
    {
        $items = Item::all();
        return view('user.browse', compact('items'));
    }

    // Handle borrow request
    public function requestBorrow(Request $request, $serial_number)
    {
        // Optional: Check if already requested
        $existing = BorrowRequest::where('serial_number', $serial_number)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return back()->with('success', 'You already have a pending request for this item.');
        }

        BorrowRequest::create([
            'serial_number' => $serial_number,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Borrow request sent for item: ' . $serial_number);
    }
}
