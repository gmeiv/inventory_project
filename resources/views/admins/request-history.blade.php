<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction History</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/request-history.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="accept-requests-container">
        <form action="{{ route('admin.dashboard') }}" method="GET" style="display:inline; margin-bottom: 1.2rem;">
            <button type="submit" class="accept-requests-action-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</button>
        </form>
        <h1 class="accept-requests-title">Transaction History</h1>

        
        <div class="filter-container">
            <form method="GET" action="{{ route('admin.requestHistory') }}" id="filter-form">
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="status">Status:</label>
                        <select name="status" id="status">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="user">User Name:</label>
                        <input type="text" name="user" id="user" value="{{ request('user') }}" placeholder="Search by user name">
                    </div>
                    <div class="filter-group">
                        <label for="serial_number">Serial Number:</label>
                        <input type="text" name="serial_number" id="serial_number" value="{{ request('serial_number') }}" placeholder="Search by serial number">
                    </div>
                    <div class="filter-buttons">
                        <button type="submit" class="accept-requests-action-btn">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <button type="button" class="accept-requests-action-btn" onclick="window.location.href='{{ route('admin.requestHistory') }}'">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </div>
            </form>
        </div>

       
        <div style="color: #cce6ff; margin-bottom: 1rem;">
            Showing {{ $requests->firstItem() ?? 0 }} to {{ $requests->lastItem() ?? 0 }} of {{ $requests->total() }} requests
        </div>

        
        <table class="accept-requests-table history-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Item</th>
                    <th>Serial Number</th>
                    <th>Status</th>
                    <th>Request Date</th>
                    <th>Updated Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                    <tr>
                        <td>
                            <strong>{{ $request->user->firstname ?? 'Unknown' }} {{ $request->user->surname ?? '' }}</strong><br>
                            <small style="color: #999;">{{ $request->user->email ?? 'N/A' }}</small>
                        </td>
                        <td>
                            @if($request->item)
                                <strong>{{ $request->item->name }}</strong><br>
                                <small style="color: #999;">Location: {{ $request->item->location }}</small>
                            @else
                                <span style="color: #999;">Item not found</span>
                            @endif
                        </td>
                        <td>{{ $request->serial_number }}</td>
                        <td>
                            <span class="status-badge status-{{ $request->status }}">
                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                            </span>
                        </td>
                        <td>{{ $request->created_at->format('M d, Y g:i A') }}</td>
                        <td>{{ $request->updated_at->format('M d, Y g:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="accept-requests-empty">No requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        
        @if($requests->hasPages())
            <div class="pagination">
                @if($requests->onFirstPage())
                    <span>&laquo; Previous</span>
                @else
                    <a href="{{ $requests->previousPageUrl() }}">&laquo; Previous</a>
                @endif

                @foreach($requests->getUrlRange(1, $requests->lastPage()) as $page => $url)
                    @if($page == $requests->currentPage())
                        <span class="current">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($requests->hasMorePages())
                    <a href="{{ $requests->nextPageUrl() }}">Next &raquo;</a>
                @else
                    <span>Next &raquo;</span>
                @endif
            </div>
        @endif
    </div>
</body>
</html> 