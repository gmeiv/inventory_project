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


    <a href="{{ url('user.dashboard') }}" class="back-button">
        &larr; Back to Dashboard
    </a>

    <div class="items-wrapper">


        <div class="header-row">
            <h1 class="title">Browse Items to Borrow</h1>
            <input type="text" id="searchInput" placeholder="Search by Serial Number or Name..." onkeyup="filterTable()">
        </div>

      
        <table class="history-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th class="sortable" onclick="sortTable(1)">Serial Number <span id="sort-indicator-1"></span></th>
                    <th class="sortable" onclick="sortTable(2)">Name <span id="sort-indicator-2"></span></th>
                    <th class="sortable" onclick="sortTable(3)">Stocks <span id="sort-indicator-3"></span></th>
                    <th class="sortable" onclick="sortTable(4)">Location <span id="sort-indicator-4"></span></th>
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
        function filterTable() {
            const input = document.getElementById('searchInput').value.toUpperCase();
            const rows = document.querySelectorAll('.history-table tbody tr');
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

    const baseRoute = "{{ url('/borrow-request') }}"; 

    if (action === 'borrow') {
        title.textContent = 'Confirm Borrow';
        message.textContent = `Are you sure you want to borrow ${itemName} (${serialNumber})?`;
        form.action = `${baseRoute}/${serialNumber}`;
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
    <script>
let lastSortedCol = null;
let lastSortDir = 'asc';

function sortTable(n) {
    const table = document.querySelector('.history-table');
    const tbody = table.tBodies[0];
    let rows = Array.from(tbody.querySelectorAll('tr'));
    if (rows.length < 2) return;

    // Determine direction
    let dir = 'asc';
    if (lastSortedCol === n && lastSortDir === 'asc') {
        dir = 'desc';
    }
    lastSortedCol = n;
    lastSortDir = dir;

    // Remove all indicators
    for (let i = 0; i < 6; i++) {
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
            if (n === 1 || n === 3) { // Serial Number or Stocks columns
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
            rows = Array.from(tbody.querySelectorAll('tr'));
            switching = true;
        }
    }
}
</script>
</body>
</html>