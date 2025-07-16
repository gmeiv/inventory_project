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

        .filter-btn, .arrow-btn {
            background: linear-gradient(to right, #003366, #4da6ff);
            border: none;
            padding: 8px 12px;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .filter-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 8px 12px;
            display: block;
            text-decoration: none;
        }

        .dropdown-content a:hover {
            background-color: #f0f0f0;
        }

        .add-btn-wrapper {
            text-align: right;
            margin-top: 1rem;
        }

        .add-btn {
            background-color: #003366;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <a href="{{ url('admin.dashboard') }}" class="back-button">&larr; Back to Dashboard</a>

    <div class="items-wrapper">
        <div class="header-row">
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

        <div class="add-btn-wrapper">
            <button onclick="openAddModal()" class="add-btn" type="button">
                <i class="fas fa-plus"></i> Add Item
            </button>
        </div>

        <!-- Modal -->
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

        <!-- Error Popup -->
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
            const modal = document.getElementById('itemModal');
            if (event.target === modal) {
                closeModal();
            }
        };

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
