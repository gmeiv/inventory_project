<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ARICC Inventory System</title>
    <link rel="stylesheet" href="{{ asset('css/MYAPP.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>ARICC INVENTORY SYSTEM</h1>
        </div>

        <div class="grid-wrapper">
                <div class="grid-container">
            <button class="grid-item"><i class="fas fa-user-circle"></i> My Account</button>
            <form action="{{ route('admins.index') }}" method="GET" style="display:inline;">
                <button type="submit" class="grid-item"><i class="fas fa-user-shield"></i> Employee</button>
            </form>
            <form action="{{ route('admin.acceptRequests') }}" method="GET" style="display:inline;">
                <button type="submit" class="grid-item"><i class="fas fa-handshake"></i> Accept Request</button>
            </form>
            <form action="{{ route('admin.returnRequests') }}" method="GET" style="display:inline;">
                <button type="submit" class="grid-item"><i class="fas fa-undo-alt"></i> Return Requests</button>
            </form>
            <form action="{{ route('items.index') }}" method="GET" style="display:inline;">
                <button type="submit" class="grid-item"><i class="fas fa-boxes"></i> Items</button>
            </form>
            <button class="grid-item"><i class="fas fa-bullhorn"></i> Announcements</button>
            <button class="grid-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>

        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</body>
</html>
