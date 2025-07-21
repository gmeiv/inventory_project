<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction History</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
    <link rel="stylesheet" href="{{ asset('css/error-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/request-history.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <a href="{{ route('admin.dashboard') }}" class="back-button">&larr; Back to Dashboard</a>

    <div class="items-wrapper">
        <h1 class="title" style="text-align:center;">Transaction History</h1>
        <div class="header-row" style="justify-content:center;"></div>

        <!-- Filter -->
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

        <!-- Result Count -->
        <div style="color: #cce6ff; margin-bottom: 1rem;">
            Showing {{ $requests->firstItem() ?? 0 }} to {{ $requests->lastItem() ?? 0 }} of {{ $requests->total() }} requests
        </div>

        <div class="table-scroll-wrapper">
        <table class="items-table history-table">
            <thead>
                <tr>
                    <th class="sortable" onclick="sortTable(0)">User <span id="sort-indicator-0"></span></th>
                    <th class="sortable" onclick="sortTable(1)">Item <span id="sort-indicator-1"></span></th>
                    <th class="sortable" onclick="sortTable(2)">Serial Number <span id="sort-indicator-2"></span></th>
                    <th class="sortable" onclick="sortTable(3)">Quantity <span id="sort-indicator-3"></span></th>
                    <th class="sortable" onclick="sortTable(4)">Borrow Until <span id="sort-indicator-4"></span></th>
                    <th class="sortable" onclick="sortTable(5)">Status <span id="sort-indicator-5"></span></th>
                    <th class="sortable" onclick="sortTable(6)">Request Date <span id="sort-indicator-6"></span></th>
                    <th class="sortable" onclick="sortTable(7)">Updated Date <span id="sort-indicator-7"></span></th>
                    <th class="sortable approved-by-col" onclick="sortTable(8)">
                        Approved By <span id="sort-indicator-8"></span>
                    </th>
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
                        <td>{{ $request->quantity ?? '-' }}</td>
                        <td>{{ $request->borrow_until ? \Carbon\Carbon::parse($request->borrow_until)->format('M d, Y') : '-' }}</td>
                        <td>
                            <span class="status-badge status-{{ $request->status }}">
                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                            </span>
                        </td>
                        <td>{{ $request->created_at->format('M d, Y g:i A') }}</td>
                        <td>{{ $request->updated_at->format('M d, Y g:i A') }}</td>
                        <td class="approved-by-col">
                            @if($request->approvedByAdmin)
                                <div>Borrow: {{ $request->approvedByAdmin->firstname }} {{ $request->approvedByAdmin->surname }}</div>
                            @endif
                            @if($request->returnApprovedByAdmin)
                                <div>Return: {{ $request->returnApprovedByAdmin->firstname }} {{ $request->returnApprovedByAdmin->surname }}</div>
                            @endif
                            @if(!$request->approvedByAdmin && !$request->returnApprovedByAdmin)
                                <span style="color: #999;">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="accept-requests-empty">No requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <!-- Pagination -->
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
<script>
let lastSortedCol = null;
let lastSortDir = 'asc';

document.addEventListener('DOMContentLoaded', function() {
    window.sortTable = function(n) {
        const table = document.querySelector('.history-table');
        const tbody = table.tBodies[0];
        let rows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.querySelectorAll('td').length === 9);
        if (rows.length < 2) return; // Nothing to sort

        // Determine direction
        let dir = 'asc';
        if (lastSortedCol === n && lastSortDir === 'asc') {
            dir = 'desc';
        }
        lastSortedCol = n;
        lastSortDir = dir;

        // Remove all indicators
        for (let i = 0; i < 7; i++) {
            const indicator = document.getElementById('sort-indicator-' + i);
            if (indicator) indicator.textContent = '';
        }
        // Set indicator for this column
        const indicator = document.getElementById('sort-indicator-' + n);
        if (indicator) indicator.textContent = dir === 'asc' ? '▲' : '▼';

        let switching = true;
        while (switching) {
            switching = false;
            let shouldSwitch = false;
            for (let i = 0; i < rows.length - 1; i++) {
                let x = rows[i].getElementsByTagName('TD')[n];
                let y = rows[i + 1].getElementsByTagName('TD')[n];
                if (!x || !y) continue;
                let xContent = x.textContent.trim();
                let yContent = y.textContent.trim();
                let compareResult = 0;
                if (n === 6 || n === 7) { // Date columns (adjusted for new column positions)
                    let xDate = Date.parse(xContent);
                    let yDate = Date.parse(yContent);
                    if (!isNaN(xDate) && !isNaN(yDate)) {
                        compareResult = xDate - yDate;
                    } else {
                        compareResult = xContent.localeCompare(yContent, undefined, {sensitivity: 'base'});
                    }
                } else if (n === 2) { // Serial Number column
                    let xNum = parseFloat(xContent.replace(/[^\d.\-]/g, ''));
                    let yNum = parseFloat(yContent.replace(/[^\d.\-]/g, ''));
                    if (!isNaN(xNum) && !isNaN(yNum)) {
                        compareResult = xNum - yNum;
                    } else {
                        compareResult = xContent.localeCompare(yContent, undefined, {sensitivity: 'base'});
                    }
                } else { // Alphabetical for all other columns
                    compareResult = xContent.localeCompare(yContent, undefined, {sensitivity: 'base'});
                }
                if (dir === 'asc') {
                    if (compareResult > 0) {
                        shouldSwitch = i;
                        break;
                    }
                } else if (dir === 'desc') {
                    if (compareResult < 0) {
                        shouldSwitch = i;
                        break;
                    }
                }
            }
            if (shouldSwitch !== false) {
                tbody.insertBefore(rows[shouldSwitch + 1], rows[shouldSwitch]);
                rows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.querySelectorAll('td').length === 9);
                switching = true;
            }
        }
    }
});
</script>
</html>
