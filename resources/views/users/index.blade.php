<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registered Members</title>
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <a href="{{ route('admin.dashboard') }}" class="back-button">&larr; Back to Dashboard</a>

    <div class="items-wrapper">
        <div class="header-row">
            <h1 class="title">Registered Members</h1>
            <input type="text" id="searchInput" placeholder="Search by Name or Email..." onkeyup="filterTable()">
        </div>



        <table class="items-table">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Course</th>
                    <th>Year Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->surname }}, {{ $user->firstname }} {{ $user->middlename }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->department }}</td>
                    <td>{{ $user->course }}</td>
                    <td>{{ $user->year_level }}</td>
                    <td>
                        <form action="{{ route('user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Delete this member?')">
                            @csrf
                            @method('DELETE')
                            <button class="action-btn"><i class="fas fa-trash"></i> </button>
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
                const email = row.cells[1].textContent.toUpperCase();
                row.style.display = (name.includes(input) || email.includes(input)) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
