<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Borrow Requests</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome (optional, if you want icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="accept-requests-container">
        <form action="{{ route('admin.dashboard') }}" method="GET" style="display:inline; margin-bottom: 1.2rem;">
            <button type="submit" class="accept-requests-action-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</button>
        </form>
        <h1 class="accept-requests-title">Pending Borrow Requests</h1>
        <table class="accept-requests-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Item Serial Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pendingRequests as $request)
                    <tr>
                        <td>{{ $request->user->name ?? 'Unknown' }}</td>
                        <td>{{ $request->serial_number }}</td>
                        <td>
                            <form action="{{ route('admin.acceptRequest', $request->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="accept-requests-action-btn">Accept Request</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="accept-requests-empty">No pending requests.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html> 