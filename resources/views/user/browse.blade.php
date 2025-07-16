<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Items to Borrow</title>
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
    <h1 class="title">Browse Items to Borrow</h1>

    <div class="header-tools" style="display: flex; gap: 8px; margin-bottom: 15px;">
        <input type="text" id="searchInput" placeholder="Search by Serial Number, Name, or Category..." onkeyup="filterTable()" style="padding: 8px; border-radius: 5px; border: none; width: 280px;">

        <div class="filter-dropdown">
            <button onclick="toggleFilterDropdown()" class="filter-btn">
                <i class="fas fa-filter"></i> Filter
            </button>
            <div id="filterOptions" class="dropdown-content">
                <a href="#" onclick="setSortField(1)">Serial Number</a>
                <a href="#" onclick="setSortField(2)">Name</a>
                <a href="#" onclick="setSortField(3)">Category</a>
                <a href="#" onclick="setSortField(4)">Stocks</a>
            </div>
        </div>

        <button class="arrow-btn" onclick="toggleSortDirection()">
            <span id="arrowIcon">Sort ↑</span>
        </button>
    </div>

    <table class="history-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Serial Number</th>
                <th>Name</th>
                <th>Category</th>
                <th>Stocks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr class="{{ $item->stocks <= 1 ? 'low-stock' : '' }}">
                    <td>
                        @if($item->serial_image)
                            <img src="{{ asset('storage/' . $item->serial_image) }}" alt="Serial Image" width="100" height="100" style="object-fit: cover;">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $item->serial_number }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->stocks }}</td>
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

<!-- Confirm Borrow Popup -->
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

<!-- Notification -->
<div class="notification-container" id="notificationContainer"></div>

<script>
    let currentSortCol = 1;
    let currentSortDir = 'asc';

    function toggleFilterDropdown() {
        const dropdown = document.getElementById('filterOptions');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    function setSortField(colIndex) {
        currentSortCol = colIndex;
        sortTable(currentSortCol, currentSortDir);
        document.getElementById('filterOptions').style.display = 'none';
    }

    function toggleSortDirection() {
        currentSortDir = currentSortDir === 'asc' ? 'desc' : 'asc';
        document.getElementById('arrowIcon').textContent = currentSortDir === 'asc' ? 'Sort ↑' : 'Sort ↓';
        sortTable(currentSortCol, currentSortDir);
    }

    function sortTable(colIndex, direction = 'asc') {
        const table = document.querySelector('.history-table');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        rows.sort((a, b) => {
            const aText = a.cells[colIndex]?.textContent.trim().toUpperCase() || '';
            const bText = b.cells[colIndex]?.textContent.trim().toUpperCase() || '';
            const aNum = parseFloat(aText);
            const bNum = parseFloat(bText);

            if (!isNaN(aNum) && !isNaN(bNum)) {
                return direction === 'asc' ? aNum - bNum : bNum - aNum;
            }

            return direction === 'asc' ? aText.localeCompare(bText) : bText.localeCompare(aText);
        });

        rows.forEach(row => tbody.appendChild(row));
    }

    function filterTable() {
        const input = document.getElementById('searchInput').value.toUpperCase();
        const rows = document.querySelectorAll('.history-table tbody tr');
        rows.forEach(row => {
            const serial_number = row.cells[1].textContent.toUpperCase();
            const name = row.cells[2].textContent.toUpperCase();
            const category = row.cells[3].textContent.toUpperCase();
            row.style.display = (serial_number.includes(input) || name.includes(input) || category.includes(input)) ? '' : 'none';
        });
    }

    function showConfirmPopup(action, serialNumber, itemName) {
        const popup = document.getElementById('confirmPopup');
        const title = document.getElementById('popupTitle');
        const message = document.getElementById('popupMessage');
        const confirmBtn = document.getElementById('confirmBtn');
        const form = document.getElementById('actionForm');

        const baseRoute = "{{ url('/borrow-request') }}";

        if (action === 'borrow') {
            title.textContent = 'Confirm Borrow';
            message.textContent = `Are you sure you want to borrow ${itemName} (${serialNumber})?`;
            form.action = `${baseRoute}/${serialNumber}`;
        }

        confirmBtn.onclick = function () {
            form.submit();
        };

        popup.style.display = 'flex';
    }

    function hideConfirmPopup() {
        document.getElementById('confirmPopup').style.display = 'none';
    }

    document.getElementById('confirmPopup').addEventListener('click', function (e) {
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

        notification.innerHTML =
            `<div class="notification-content">
                <i class="${icon} notification-icon"></i>
                <span class="notification-message">${message}</span>
            </div>
            <button class="notification-close" onclick="removeNotification(this)">&times;</button>`;

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
