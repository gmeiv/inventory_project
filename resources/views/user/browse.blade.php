<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Items to Borrow</title>
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
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

        <!-- Flash Message -->
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

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
                        <form action="{{ route('borrow.request', $item->serial_number) }}" method="POST" class="inline-form">
                            @csrf
                            <button type="submit" class="action-btn-borrow">
                                <i class="fas fa-hand-paper"></i> Borrow
                            </button>
                        </form>
                        @else
                        <span class="out-of-stock">Out of Stock</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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
    </script>
</body>
</html>