<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\BorrowRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserBorrowController extends Controller
{
    public function browse()
    {
        $items = Item::orderBy('created_at', 'desc')->get();
        return view('user.browse', compact('items'));
    }

    public function requestBorrow(Request $request, $serial_number)
    {
        $item = Item::where('serial_number', $serial_number)->firstOrFail();

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->stocks,
            'borrow_until' => 'required|date|after:today',
        ]);

        $existing = BorrowRequest::where('serial_number', $serial_number)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return back()->with('success', 'You already have a pending request for this item.');
        }

        $borrowRequest = BorrowRequest::create([
            'serial_number' => $serial_number,
            'user_id' => Auth::id(),
            'status' => 'pending',
            'quantity' => $request->quantity,
            'borrow_until' => $request->borrow_until,
        ]);

        // ✅ Notify all admins by email
        $admins = Admin::all();
        foreach ($admins as $admin) {
            Mail::send([], [], function ($message) use ($admin, $borrowRequest, $item) {
                $message->to($admin->email)
                    ->subject('New Borrow Request Submitted')
                    ->html("
                        <p>Hello <strong>{$admin->firstname}</strong>,</p>
                        <p>A new borrow request has been submitted:</p>
                        <ul>
                            <li><strong>Item:</strong> {$item->name}</li>
                            <li><strong>Serial Number:</strong> {$borrowRequest->serial_number}</li>
                            <li><strong>Quantity:</strong> {$borrowRequest->quantity}</li>
                            <li><strong>Borrow Until:</strong> {$borrowRequest->borrow_until}</li>
                            <li><strong>Requested By:</strong> {$borrowRequest->user->firstname} {$borrowRequest->user->surname}</li>
                        </ul>
                        <p>Please log in to the admin panel to review this request.</p>
                        <p><strong>ARICC System</strong></p>
                    ");
            });
        }

        return back()->with('success', 'Borrow request sent for item: ' . $serial_number);
    }

    public function showMyBorrowings()
    {
        $myBorrowings = BorrowRequest::where('user_id', Auth::id())->with('user')->get();
        return view('user.my-borrowings', compact('myBorrowings'));
    }

    public function returnItem($id)
    {
        $borrow = BorrowRequest::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->first();

        if (!$borrow) {
            return redirect()->back()->with('error', 'This borrow request cannot be returned.');
        }

        $borrow->status = 'returned';
        $borrow->save();

        // ✅ Notify all admins about the return
        $admins = Admin::all();
        foreach ($admins as $admin) {
            Mail::send([], [], function ($message) use ($admin, $borrow) {
                $message->to($admin->email)
                    ->subject('Borrowed Item Returned')
                    ->html("
                        <p>Hello <strong>{$admin->firstname}</strong>,</p>
                        <p>A user has returned an item:</p>
                        <ul>
                            <li><strong>Item:</strong> {$borrow->item->name}</li>
                            <li><strong>Serial Number:</strong> {$borrow->serial_number}</li>
                            <li><strong>Quantity:</strong> {$borrow->quantity}</li>
                            <li><strong>User:</strong> {$borrow->user->firstname} {$borrow->user->surname}</li>
                        </ul>
                        <p>Please log in to confirm the return.</p>
                        <p><strong>ARICC System</strong></p>
                    ");
            });
        }

        return redirect()->back()->with('success', 'Item returned successfully.');
    }
}
