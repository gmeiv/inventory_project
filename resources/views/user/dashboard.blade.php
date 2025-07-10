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
                <div class="grid-item"><i class="fas fa-user"></i> My Account</div>
                <div class="grid-item"><i class="fas fa-box-open" ><a href="{{ route('user.browse') }}"></i> Browse Items</a></div>
                <div class="grid-item"><i class="fas fa-hand-holding"><a href=""></i> Request Borrow</a></div>
                <div class="grid-item"><i class="fas fa-clipboard-list"></i> My Borrowings</div>
                <div class="grid-item"><i class="fas fa-undo-alt"></i> Return Items</div>
                <div class="grid-item"><i class="fas fa-bullhorn"></i> Announcements</div>
                <div class="grid-item"><i class="fas fa-sign-out-alt" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></i> Logout</div>
                
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</body>
</html>
