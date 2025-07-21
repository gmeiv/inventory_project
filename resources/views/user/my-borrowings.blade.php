<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Borrowings</title>
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
    <link rel="stylesheet" href="{{ asset('css/request-history.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<a href="{{ url('user.dashboard') }}" class="back-button">&larr; Back to Dashboard</a>
<div class="items-wrapper">
    <h1 class="title">My Borrowings</h1>
    @php
        $sortedBorrowings = $myBorrowings->sortByDesc('created_at');
    @endphp
    <table class="history-table" style="text-align:center;">
            <thead>
                <tr>
                <th style="text-align:center;">Item Serial Number</th>
                <th style="text-align:center;">Item Name</th>
                <th style="text-align:center;">Quantity</th>
                <th style="text-align:center;">Borrow Until</th>
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sortedBorrowings as $borrow)
                <tr style="text-align:center;">
                        <td>{{ $borrow->serial_number }}</td>
                        <td>{{ $borrow->item->name ?? '-' }}</td>
                        <td>{{ $borrow->quantity ?? '-' }}</td>
                        <td>{{ $borrow->borrow_until ? \Carbon\Carbon::parse($borrow->borrow_until)->format('M d, Y') : '-' }}</td>
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
                        <button type="button" class="action-btn" onclick="showConfirmPopup('return', '{{ $borrow->id }}', '{{ $borrow->serial_number }}')"><i class="fas fa-undo-alt"></i> Return Item</button>
                            @else
                                <span style="color: #aaa;">Returned</span>
                            @endif
                        </td>
                    </tr>
                @empty
                <tr style="text-align:center;">
                        <td colspan="6" class="accept-requests-empty">You have not borrowed any items.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="confirm-popup-overlay" id="confirmPopup">
        <div class="confirm-popup">
            <h3 id="popupTitle">Confirm Action</h3>
            <p id="popupMessage">Are you sure you want to proceed?</p>
            <div class="confirm-popup-buttons">
                <button class="confirm-popup-btn confirm" id="confirmBtn">Confirm</button>
                <button class="confirm-popup-btn cancel" onclick="hideConfirmPopup()">Cancel</button>
            </div>
        </div>
    </div>

    <form id="actionForm" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="notification-container" id="notificationContainer"></div>

    <script>
        function showConfirmPopup(action, borrowId, serialNumber) {
        const popup = document.getElementById('confirmPopup');
        const title = document.getElementById('popupTitle');
        const message = document.getElementById('popupMessage');
        const confirmBtn = document.getElementById('confirmBtn');
        const form = document.getElementById('actionForm');

        const returnRoute = "{{ url('/user/return-item') }}"; 

        if (action === 'return') {
            title.textContent = 'Confirm Return';
            message.textContent = `Are you sure you want to return item ${serialNumber}?`;
            form.action = `${returnRoute}/${borrowId}`;
        }

        confirmBtn.onclick = function() {
            form.submit();
        };

        popup.style.display = 'flex';
    }

        function hideConfirmPopup() {
        document.getElementById('confirmPopup').style.display = 'none';
        }
        
        document.getElementById('confirmPopup').addEventListener('click', function(e) {
            if (e.target === this) {
                hideConfirmPopup();
            }
        });
        
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            const icon = type === 'success' ? 'fas fa-check-circle' : 
                        type === 'error' ? 'fas fa-exclamation-circle' : 
                        'fas fa-info-circle';
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="${icon} notification-icon"></i>
                    <span class="notification-message">${message}</span>
                </div>
                <button class="notification-close" onclick="removeNotification(this)">&times;</button>
            `;
            container.appendChild(notification);
            setTimeout(() => {
                removeNotification(notification.querySelector('.notification-close'));
            }, 5000);
        }

        function removeNotification(button) {
            const notification = button.closest('.notification');
            notification.classList.add('removing');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
        
        @if (session('success'))
            showNotification("{{ session('success') }}", 'success');
        @endif
        @if (session('error'))
            showNotification("{{ session('error') }}", 'error');
        @endif
    </script>
</body>
</html> 