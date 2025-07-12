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

    // Show return requests (pending admin confirmation)
    public function showReturnRequests()
    {
        $returnRequests = BorrowRequest::where('status', 'returned')->with('user')->get();
        return view('admins.return-requests', compact('returnRequests'));
    }

    // Confirm a returned item
    public function confirmReturn($id)
    {
        $request = BorrowRequest::findOrFail($id);
        $request->status = 'confirmed_returned';
        $request->save();
        return redirect()->back()->with('success', 'Return confirmed.');
    }

    // Show all request history
    public function showRequestHistory(Request $request)
    {
        $query = BorrowRequest::with(['user', 'item']);

        // Filter by status if provided and not empty
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by user if provided
        if ($request->has('user') && $request->user !== '') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('firstname', 'like', '%' . $request->user . '%')
                  ->orWhere('surname', 'like', '%' . $request->user . '%');
            });
        }

        // Filter by item serial number if provided
        if ($request->has('serial_number') && $request->serial_number !== '') {
            $query->where('serial_number', 'like', '%' . $request->serial_number . '%');
        }

        // Sort by created_at descending (newest first)
        $requests = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get unique statuses for filter dropdown
        $statuses = BorrowRequest::distinct()->pluck('status')->sort();

        return view('admins.request-history', compact('requests', 'statuses'));
    }
}
