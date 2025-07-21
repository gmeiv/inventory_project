<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admins List</title>
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admins.css') }}">

</head>
<body>

    <a href="{{ url('admin.dashboard') }}" class="back-button">&larr; Back to Dashboard</a>

    <div class="items-wrapper">
        <h1 class="title">Admin Accounts</h1>
        <div class="header-row">
            <input type="text" id="searchInput" placeholder="Search by Name or Email..." onkeyup="filterTable()">
        </div>
        <a href="{{ route('admin_register') }}">
            <button class="add-button"><i class="fas fa-plus"></i> Add Admin</button>
        </a>
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif
        <table class="items-table">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Employment Type</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->surname }}, {{ $admin->firstname }} {{ $admin->middlename }}</td>
                    <td>{{ $admin->department }}</td>
                    <td>{{ $admin->position }}</td>
                    <td>{{ $admin->employment_type }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <form action="{{ route('admin.delete', $admin->id) }}" method="POST" onsubmit="return confirm('Delete this admin?')">
                            @csrf
                            @method('DELETE')
                            <button class="action-btn"><i class="fas fa-trash"></i></button>
                        </form>
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
                const name = row.cells[0].textContent.toUpperCase();
                const email = row.cells[4].textContent.toUpperCase();
                row.style.display = (name.includes(input) || email.includes(input)) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
