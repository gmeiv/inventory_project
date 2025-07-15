<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Borrow Requests</title>
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
    <link rel="stylesheet" href="{{ asset('css/error-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <a href="{{ route('admin.dashboard') }}" class="back-button">&larr; Back to Dashboard</a>

    <div class="items-wrapper">
        <div class="header-row">
            <h1 class="title">Pending Borrow Requests</h1>
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        <table class="items-table">
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
                            <button type="button" class="action-btn confirm" onclick="showConfirmPopup('accept', {{ $request->id }}, '{{ $request->user->firstname ?? 'Unknown' }} {{ $request->user->surname ?? '' }}', '{{ $request->item->name ?? 'Unknown Item' }}')">
                                <i class="fas fa-check"></i> Accept Request
                            </button>
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

    <!-- Hidden Form -->
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

            const baseRoute = "{{ url('/admin/accept-request') }}"; 

            if (action === 'accept') {
                title.textContent = 'Accept Borrow Request';
                message.textContent = `Are you sure you want to accept the borrow request from ${userName} for item ${itemName}?`;
                form.action = `${baseRoute}/${requestId}`; 
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
