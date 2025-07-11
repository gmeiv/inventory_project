<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Borrowings</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="accept-requests-container">
        <form action="{{ route('user.dashboard') }}" method="GET" style="display:inline; margin-bottom: 1.2rem;">
            <button type="submit" class="accept-requests-action-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</button>
        </form>
        <h1 class="accept-requests-title">My Borrowings</h1>
        <table class="accept-requests-table">
            <thead>
                <tr>
                    <th>Item Serial Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($myBorrowings as $borrow)
                    <tr>
                        <td>{{ $borrow->serial_number }}</td>
                        <td>
                            @if($borrow->status === 'returned')
                                Pending
                            @elseif($borrow->status === 'approved')
                                Approved
                            @elseif($borrow->status === 'confirmed_returned')
                                Confirmed Returned
                            @else
                                {{ ucfirst($borrow->status) }}
                            @endif
                        </td>
                        <td>
                            @if($borrow->status === 'approved')
                            <form action="{{ route('user.returnItem', $borrow->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="accept-requests-action-btn"><i class="fas fa-undo-alt"></i> Return Item</button>
                            </form>
                            @else
                                <span style="color: #aaa;">Returned</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="accept-requests-empty">You have not borrowed any items.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html> 