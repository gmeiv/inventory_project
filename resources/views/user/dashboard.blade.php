<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ARICC Inventory System</title>
    <link rel="stylesheet" href="{{ asset('css/MYAPP.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/confirm-popup.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>ARICC INVENTORY SYSTEM</h1>
        </div>

        <div class="grid-wrapper">
            <div class="grid-container">
                <button class="grid-item"><i class="fas fa-user-circle"></i> My Account</button>
                <form action="{{ route('user.browse') }}" method="GET" style="display:inline;">
                    <button type="submit" class="grid-item"><i class="fas fa-box-open"></i> Browse Items</button>
                </form>
                <form action="" method="GET" style="display:inline;">
                    <button type="submit" class="grid-item"><i class="fas fa-hand-holding"></i> Request Borrow</button>
                </form>
                <form action="{{ route('user.myBorrowings') }}" method="GET" style="display:inline;">
                    <button type="submit" class="grid-item"><i class="fas fa-clipboard-list"></i> My Borrowings</button>
                </form>
                <form action="{{ route('announcements.user_index') }}" method="GET" style="display:inline;">
                <button type="submit" class="grid-item"><i class="fas fa-bullhorn"></i> Announcements</button>
            </form>
                <button class="grid-item" onclick="showConfirmPopup('logout')"><i class="fas fa-sign-out-alt"></i> Logout</button>
                
            </div>
        </div>

    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

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

    <script>
        function showConfirmPopup(action) {
            const popup = document.getElementById('confirmPopup');
            const title = document.getElementById('popupTitle');
            const message = document.getElementById('popupMessage');
            const confirmBtn = document.getElementById('confirmBtn');

            if (action === 'logout') {
                title.textContent = 'Confirm Logout';
                message.textContent = 'Are you sure you want to logout?';
                confirmBtn.onclick = function() {
                    document.getElementById('logout-form').submit();
                };
            }

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
    </script>
</body>
</html>
