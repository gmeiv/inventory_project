<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowRequest;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard'); 
    }


    public function showPendingRequests()
    {
        $pendingRequests = BorrowRequest::where('status', 'pending')->with('user')->orderBy('created_at', 'desc')->get();
        return view('admins.accept-requests', compact('pendingRequests'));
    }


 public function acceptRequest($id)
{
    $request = BorrowRequest::with('user', 'item')->findOrFail($id);

    $item = Item::findOrFail($request->serial_number);
    if ($item->stocks < 1) {
        return redirect()->back()->with('error', 'Not enough stock to fulfill this request.');
    }

    $item->stocks -= 1;
    $item->save();

    $request->status = 'approved';
    $request->save();

    // ✅ Get image URL (adjust depending on how you store images)
   $imageUrl = url('storage/serial_images/' . $item->image);
    
    // ✅ Send HTML email with image
    Mail::send([], [], function ($message) use ($request, $imageUrl) {
        $message->to($request->user->email)
                ->subject('Your Borrow Request Has Been Approved')
                ->html("
                    <p>Hello <strong>{$request->user->firstname}</strong>,</p>

                    <p>Your request to borrow the item <strong>\"{$request->item->name}\"</strong> has been approved.</p>
                    <p><strong>Serial Number:</strong> {$request->serial_number}</p>
                    <p><strong>Quantity:</strong> {$request->quantity}</p>
                    <p><strong>Status:</strong> Approved</p>
                    <p><strong>Pickup Location:</strong> Bulacan State University - Alvarado Hall [Room303]</p>
                    <p><strong>Pickup Date:</strong> Please collect the item within 3 days.</p>
                    <p><strong>Item Preview:</strong><br>
                   <!-- <img src=\"{$imageUrl}\" alt=\"Item Image\" style=\"max-width: 300px; border: 1px solid #ddd; padding: 5px;\">
                    </p> -->

                    <p>Please make arrangements to collect the item.</p>

                    <p>Thank you,<br><strong>ARICC Admin Team</strong></p>
                ");
    });

    return redirect()->back()->with('success', 'Request accepted, stock updated, and user notified.');
}

    


    public function showReturnRequests()
    {
        $returnRequests = BorrowRequest::where('status', 'returned')->with('user')->orderBy('created_at', 'desc')->get();
        return view('admins.return-requests', compact('returnRequests'));
    }


    public function confirmReturn($id)
    {
        $request = BorrowRequest::findOrFail($id);
        $request->status = 'confirmed_returned';
        $request->save();
        return redirect()->back()->with('success', 'Return confirmed.');
    }


    public function showRequestHistory(Request $request)
    {
        $query = BorrowRequest::with(['user', 'item']);


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        if ($request->has('user') && $request->user !== '') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('firstname', 'like', '%' . $request->user . '%')
                  ->orWhere('surname', 'like', '%' . $request->user . '%');
            });
        }


        if ($request->has('serial_number') && $request->serial_number !== '') {
            $query->where('serial_number', 'like', '%' . $request->serial_number . '%');
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(20);

        $statuses = BorrowRequest::distinct()->pluck('status')->sort();

        return view('admins.request-history', compact('requests', 'statuses'));
    }
    
}
