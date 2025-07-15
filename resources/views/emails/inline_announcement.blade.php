<!DOCTYPE html>
<html>
<head>
    <title>ARICC Inventory - New Announcement</title>
</head>
<body>
    <h2>{{ $announcement->title }}</h2>
    <p><strong>Date:</strong> {{ $announcement->date }}</p>
    <p><strong>Time:</strong> {{ $announcement->time }}</p>
    <p>{{ $announcement->description }}</p>
    <br>
    <p>Best regards,<br><strong>ARICC Admin</strong></p>
</body>
</html>
