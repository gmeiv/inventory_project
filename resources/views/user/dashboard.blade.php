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
                <form action="{{ route('user.browse') }}" method="GET" style="display:inline;">
                    <button type="submit" class="grid-item"><i class="fas fa-box-open"></i> Browse Items</button>
                </form>
                <form action="" method="GET" style="display:inline;">
                    <button type="submit" class="grid-item"><i class="fas fa-hand-holding"></i> Request Borrow</button>
                </form>
                <form action="{{ route('user.myBorrowings') }}" method="GET" style="display:inline;">
                    <button type="submit" class="grid-item"><i class="fas fa-clipboard-list"></i> My Borrowings</button>
                </form>
                <form action="{{ route('announcements.user_index') }}" method="GET" style="display:inline;">
                <button type="submit" class="grid-item"><i class="fas fa-bullhorn"></i> Announcements</button>
            </form>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="grid-item"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
                
            </div>
        </div>

    </div>
</body>
</html>
