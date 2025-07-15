<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Items Inventory</title>
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
    <link rel="stylesheet" href="{{ asset('css/request-history.css') }}">
    <link rel="stylesheet" href="{{ asset('css/error-popup.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        input[disabled] {
            background-color: #f0f0f0;
            color: #888;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <a href="{{ url('admin.dashboard') }}" class="back-button">&larr; Back to Dashboard</a>

    <div class="items-wrapper">
        <div class="header-row">
            <h1 class="title">Items Inventory</h1>
            <input type="text" id="searchInput" placeholder="Search by Serial Number or Name..." onkeyup="filterTable()" style="width: 20rem;">
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <table class="items-table history-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th class="sortable" onclick="sortTable(1)">Serial Number <span id="sort-indicator-1"></span></th>
                    <th class="sortable" onclick="sortTable(2)">Name <span id="sort-indicator-2"></span></th>
                    <th class="sortable" onclick="sortTable(3)">Stocks <span id="sort-indicator-3"></span></th>
                    <th class="sortable" onclick="sortTable(4)">Location <span id="sort-indicator-4"></span></th>
                    <th>Actions</th>
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
                        <button class="action-btn edit" type="button" onclick="openEditModal(
                            '{{ $item->serial_number }}', 
                            '{{ addslashes($item->name) }}', 
                            {{ $item->stocks }}, 
                            '{{ addslashes($item->location) }}',
                            '{{ route('items.update', $item->serial_number) }}')">
                            <i class="fas fa-pen"></i> Edit
                        </button>
                        <form action="{{ route('items.destroy', $item->serial_number) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="add-btn-wrapper">
            <button onclick="openAddModal()" class="add-btn" type="button">
                <i class="fas fa-plus"></i> Add Item
            </button>
        </div>

       
        <div id="itemModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2 id="modalTitle">Add Item</h2>
                <form id="itemForm" method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
    @csrf


    <input type="hidden" name="serial_number" id="serialNumber">


    <input type="hidden" name="serial_number_original" id="serial_number_original">

    <label for="serial_image">Serial Image</label>
    <input type="file" name="serial_image" id="serial_image" accept="image/*">

    <label for="serial_number">Serial Number</label>
    <input type="text" name="serial_number" id="serial_number" required disabled>

    <label for="name">Name</label>
    <input type="text" name="name" id="name" required>

    <label for="stocks">Stocks</label>
    <input type="number" name="stocks" id="stocks" required min="0">

    <label for="location">Location</label>
    <input type="text" name="location" id="location" required>

    <button type="submit" class="modal-btn">Save Item</button>
</form>

            </div>
        </div>

        
        <div id="errorPopup">
            <p><strong>The serial number is already taken.</strong></p>
            <button onclick="closeErrorPopup()">Okay</button>
        </div>
    </div>

    <script>
        function openAddModal() {
    const form = document.getElementById('itemForm');
    document.getElementById('modalTitle').innerText = 'Add Item';
    form.action = "{{ route('items.store') }}";

    const methodField = form.querySelector('input[name="_method"]');
    if (methodField) methodField.remove();

    document.getElementById('serialNumber').value = '';
    document.getElementById('serial_number_original').value = '';
    document.getElementById('serial_number').value = '';
    document.getElementById('serial_number').disabled = false;

    document.getElementById('name').value = '';
    document.getElementById('stocks').value = '';
    document.getElementById('location').value = '';

    document.getElementById('itemModal').style.display = 'block';
}


        function openEditModal(serialNumber, name, stocks, location, actionUrl) {
    const form = document.getElementById('itemForm');
    document.getElementById('modalTitle').innerText = 'Edit Item';
    form.action = actionUrl;

    let methodField = form.querySelector('input[name="_method"]');
    if (!methodField) {
        methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        form.appendChild(methodField);
    } else {
        methodField.value = 'PUT';
    }

    document.getElementById('serialNumber').value = serialNumber;
    document.getElementById('serial_number_original').value = serialNumber;
    document.getElementById('serial_number').value = serialNumber;
    document.getElementById('serial_number').disabled = true;

    document.getElementById('name').value = name;
    document.getElementById('stocks').value = stocks;
    document.getElementById('location').value = location;

    document.getElementById('itemModal').style.display = 'block';
}


        function closeModal() {
            document.getElementById('itemModal').style.display = 'none';
        }

        function closeErrorPopup() {
            document.getElementById('errorPopup').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('itemModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        function filterTable() {
            const input = document.getElementById('searchInput').value.toUpperCase();
            const rows = document.querySelectorAll('.history-table tbody tr');
            rows.forEach(row => {
                const serial_number = row.cells[1].textContent.toUpperCase();
                const name = row.cells[2].textContent.toUpperCase();
                row.style.display = (serial_number.includes(input) || name.includes(input)) ? '' : 'none';
            });
        }
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

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                @if (old('_method') === 'PUT')
                    openEditModal(
                        "{{ old('serial_number') }}",
                        "{{ old('name') }}",
                        "{{ old('stocks') }}",
                        "{{ old('location') }}",
                        "{{ url('items') }}/{{ old('serial_number') }}"
                    );
                @else
                    openAddModal();
                @endif

                @if ($errors->has('serial_number'))
                    document.getElementById('errorPopup').style.display = 'block';
                    document.getElementById('serial_number').focus();
                    document.getElementById('serial_number').value = "{{ old('serial_number') }}";
                @endif

                document.getElementById('name').value = "{{ old('name') }}";
                document.getElementById('stocks').value = "{{ old('stocks') }}";
                document.getElementById('location').value = "{{ old('location') }}";
            });
        </script>
    @endif
</body>
</html>
