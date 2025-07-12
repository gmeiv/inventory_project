<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Borrowings</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">
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
                            <button type="button" class="accept-requests-action-btn" onclick="showConfirmPopup('return', {{ $borrow->id }}, '{{ $borrow->serial_number }}')"><i class="fas fa-undo-alt"></i> Return Item</button>
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

    <!-- Confirmation Popup -->
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

    <!-- Hidden form for submission -->
    <form id="actionForm" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Notification Container -->
    <div class="notification-container" id="notificationContainer"></div>

    <script>
        function showConfirmPopup(action, borrowId, serialNumber) {
        const popup = document.getElementById('confirmPopup');
        const title = document.getElementById('popupTitle');
        const message = document.getElementById('popupMessage');
        const confirmBtn = document.getElementById('confirmBtn');
        const form = document.getElementById('actionForm');

        const returnRoute = "{{ url('/user/return-item') }}"; // Blade-generated base

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
            const popup = document.getElementById('confirmPopup');
            popup.style.display = 'none';
        }

        // Close popup when clicking outside
        document.getElementById('confirmPopup').addEventListener('click', function(e) {
            if (e.target === this) {
                hideConfirmPopup();
            }
        });

        // Show notification function
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
            
            // Auto remove after 5 seconds
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

        // Check for flash messages and show as notifications
        @if (session('success'))
            showNotification("{{ session('success') }}", 'success');
        @endif

        @if (session('error'))
            showNotification("{{ session('error') }}", 'error');
        @endif
    </script>
</body>
</html> 