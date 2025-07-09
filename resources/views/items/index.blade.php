<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Items Inventory</title>
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <!-- Back Button -->
    <a href="{{ url('admin.dashboard') }}" class="back-button">
        &larr; Back to Dashboard
    </a>

    <div class="items-wrapper">

        <!-- Header -->
        <div class="header-row">
            <h1 class="title">Items Inventory</h1>
            <input type="text" id="searchInput" placeholder="Search by Serial Number or Name..." onkeyup="filterTable()" style="width: 20rem;">
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <!-- Items Table -->
        <table class="items-table">
            <!-- Table Header -->
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
                        <button 
                            class="action-btn edit" 
                            type="button"
                            onclick="openEditModal(
                                '{{ $item->serial_number }}', 
                                '{{ addslashes($item->name) }}', 
                                {{ $item->stocks }}, 
                                '{{ addslashes($item->location) }}',
                                '{{ route('items.update', $item->serial_number) }}'
                            )">
                            <i class="fas fa-pen"></i> Edit
                        </button>

                        <form action="{{ route('items.destroy', $item->serial_number) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit" 
                                class="action-btn delete" 
                                onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Add Button -->
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
                <!-- Modal Form -->
                <form id="itemForm" method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="serial_number" id="serialNumber">

                    <label for="serial_image">Serial Image</label>
                    <input type="file" name="serial_image" id="serial_image" accept="image/*">

                    <label for="serial_number">Serial Number</label>
                    <input type="text" name="serial_number" id="serial_number" required>

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

    </div>

    <!-- JavaScript -->
    <script>
        function openAddModal() {
            const form = document.getElementById('itemForm');
            document.getElementById('modalTitle').innerText = 'Add Item';
            form.action = "{{ route('items.store') }}";

            const methodField = form.querySelector('input[name="_method"]');
            if (methodField) methodField.remove();

            document.getElementById('serialNumber').value = '';
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
            document.getElementById('name').value = name;
            document.getElementById('stocks').value = stocks;
            document.getElementById('location').value = location;

            document.getElementById('itemModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('itemModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('itemModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        function filterTable() {
            const input = document.getElementById('searchInput').value.toUpperCase();
            const rows = document.querySelectorAll('.items-table tbody tr');

            rows.forEach(row => {
                const serial_number = row.cells[1].textContent.toUpperCase();
                const name = row.cells[2].textContent.toUpperCase();
                row.style.display = (serial_number.includes(input) || name.includes(input)) ? '' : 'none';
            });
        }
    </script>

</body>
</html>
