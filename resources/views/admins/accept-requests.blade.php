<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Borrow Requests</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">
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
                    <th>Item Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pendingRequests as $request)
                    <tr>
                        <td>{{ $request->user->firstname ?? 'Unknown' }} {{ $request->user->surname ?? '' }}</td>
                        <td>
                            @if($request->item)
                                {{ $request->item->name }}
                            @else
                                <span style="color: #999;">Item not found</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="accept-requests-action-btn" onclick="showConfirmPopup('accept', {{ $request->id }}, '{{ $request->user->firstname ?? 'Unknown' }} {{ $request->user->surname ?? '' }}', '{{ $request->item->name ?? 'Unknown Item' }}')">Accept Request</button>
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
       function showConfirmPopup(action, requestId, userName, itemName) {
        const popup = document.getElementById('confirmPopup');
        const title = document.getElementById('popupTitle');
        const message = document.getElementById('popupMessage');
        const confirmBtn = document.getElementById('confirmBtn');
        const form = document.getElementById('actionForm');

        const baseRoute = "{{ url('/admin/accept-request') }}"; // Blade inserts full base URL

        if (action === 'accept') {
            title.textContent = 'Accept Borrow Request';
            message.textContent = `Are you sure you want to accept the borrow request from ${userName} for item ${itemName}?`;
            form.action = `${baseRoute}/${requestId}`; // Full dynamic action
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