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

        .filter-dropdown {
            position: relative;
        }

        .filter-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            border: 1px solid #ccc;
            z-index: 99;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 5px;
        }

        .dropdown-content a {
            color: #000;
            padding: 10px 12px;
            text-decoration: none;
            display: block;
            font-size: 14px;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .arrow-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .arrow-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<a href="{{ url('admin.dashboard') }}" class="back-button">&larr; Back to Dashboard</a>

<div class="items-wrapper">
    <h1 class="title">Items Inventory</h1>

    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 20px;">
        <input type="text" id="searchInput" placeholder="Search by Serial Number or Name..." onkeyup="filterTable()" style="padding: 8px; border-radius: 5px; border: none; width: 250px;">

        <div class="filter-dropdown">
            <button onclick="toggleFilterDropdown()" class="filter-btn">
                <i class="fas fa-filter"></i> Filter
            </button>
            <div id="filterOptions" class="dropdown-content">
                <a href="#" onclick="setSortField(1)">Serial Number</a>
                <a href="#" onclick="setSortField(2)">Name</a>
                <a href="#" onclick="setSortField(3)">Stocks</a>
                <a href="#" onclick="setSortField(4)">Location</a>
            </div>
        </div>

        <button class="arrow-btn" onclick="toggleSortDirection()">
            <span id="arrowIcon">Sort ↑</span>
        </button>
    </div>

    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <table class="items-table history-table">
        <thead>
        <tr>
            <th>Image</th>
            <th>Serial Number</th>
            <th>Name</th>
            <th>Stocks</th>
            <th>Location</th>
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

    <div id="errorPopup">
        <p><strong>The serial number is already taken.</strong></p>
        <button onclick="closeErrorPopup()">Okay</button>
    </div>
</div>

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
            row.style.display = (serial_number.includes(input) || name.includes(input)) ? '' : 'none';
        });
    }

    window.onclick = function(event) {
        if (!event.target.matches('.filter-btn')) {
            document.getElementById('filterOptions').style.display = 'none';
        }
    };
</script>
</body>
</html>
