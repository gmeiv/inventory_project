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

            <button class="grid-item" type="button"><i class="fas fa-user-circle"></i> My Account</button>
            <button class="grid-item" type="button"><i class="fas fa-users"></i> Members</button>
            <button class="grid-item" type="button"><i class="fas fa-handshake"></i> Accept Request</button>
            <a href="{{ route('items.index') }}" class="grid-item"><i class="fas fa-boxes"></i> Items</a>
            <button class="grid-item" type="button"><i class="fas fa-exclamation-triangle"></i> Low Stocks</button>
            <button class="grid-item" type="button"><i class="fas fa-bullhorn"></i> Announcements</button>
            <button class="grid-item" type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</button>
           
        </div>

        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</body>
</html>
