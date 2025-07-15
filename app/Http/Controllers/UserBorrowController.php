<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\BorrowRequest;
use Illuminate\Support\Facades\Auth;

class UserBorrowController extends Controller
{
    public function browse()
    {
        $items = Item::orderBy('created_at', 'desc')->get();
        return view('user.browse', compact('items'));
    }

    public function requestBorrow(Request $request, $serial_number)
    {
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

    public function showMyBorrowings()
    {
        $myBorrowings = BorrowRequest::where('user_id', Auth::id())->with('user')->get();
        return view('user.my-borrowings', compact('myBorrowings'));
    }

    public function returnItem($id)
    {
        $borrow = BorrowRequest::where('id', $id)->where('user_id', Auth::id())->where('status', 'approved')->firstOrFail();
        $item = Item::findOrFail($borrow->serial_number);
        $item->stocks += 1;
        $item->save();
        $borrow->status = 'returned';
        $borrow->save();
        return redirect()->back()->with('success', 'Item returned successfully.');
    }
}
