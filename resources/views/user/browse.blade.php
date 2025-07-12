<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Items to Borrow</title>
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <!-- Back Button -->
    <a href="{{ url('user.dashboard') }}" class="back-button">
        &larr; Back to Dashboard
    </a>

    <div class="items-wrapper">

        <!-- Header -->
        <div class="header-row">
            <h1 class="title">Browse Items to Borrow</h1>
            <input type="text" id="searchInput" placeholder="Search by Serial Number or Name..." onkeyup="filterTable()">
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Serial Number</th>
                    <th>Name</th>
                    <th>Stocks</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="{{ $item->stocks <= 1 ? 'low-stock' : '' }}">
                    <td>
                        @if($item->serial_image)
                            <img src="{{ asset('storage/' . $item->serial_image) }}" alt="Serial Image" width="100px" height="100px" style="object-fit: cover;">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $item->serial_number }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->stocks }}</td>
                    <td>{{ $item->location }}</td>
                    <td>
                        @if($item->stocks > 0)
                        <button type="button" class="action-btn-borrow" onclick="showConfirmPopup('borrow', '{{ $item->serial_number }}', '{{ $item->name }}')">
                            <i class="fas fa-hand-paper"></i> Borrow
                        </button>
                        @else
                        <span class="out-of-stock">Out of Stock</span>
                        @endif
                    </td>
                </tr>
                @endforeach
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
        function filterTable() {
            const input = document.getElementById('searchInput').value.toUpperCase();
            const rows = document.querySelectorAll('.items-table tbody tr');
            rows.forEach(row => {
                const serial_number = row.cells[1].textContent.toUpperCase();
                const name = row.cells[2].textContent.toUpperCase();
                row.style.display = (serial_number.includes(input) || name.includes(input)) ? '' : 'none';
            });
        }

        function showConfirmPopup(action, serialNumber, itemName) {
            const popup = document.getElementById('confirmPopup');
            const title = document.getElementById('popupTitle');
            const message = document.getElementById('popupMessage');
            const confirmBtn = document.getElementById('confirmBtn');
            const form = document.getElementById('actionForm');

            if (action === 'borrow') {
                title.textContent = 'Confirm Borrow';
                message.textContent = `Are you sure you want to borrow ${itemName} (${serialNumber})?`;
                form.action = `/borrow-request/${serialNumber}`;
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