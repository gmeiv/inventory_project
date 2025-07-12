<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Announcement</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- ARICC global styles -->
    <link rel="stylesheet" href="{{ asset('css/announcement.css') }}"> <!-- Shared announcement design -->
</head>
<body>
    <div class="announcement-container">
        <h2 class="text-center mb-4">Announcement</h2>

        <div class="header-row">
            <a href="{{ route('user.dashboard') }}" class="btn btn-back">&larr; Back</a>
        </div>

        @if($announcements->count() > 0)
            @foreach($announcements as $announcement)
                <div class="announcement-box">
                    <h4>{{ $announcement->title }}</h4>
                    <p><strong>Date:</strong> {{ $announcement->date }} | <strong>Time:</strong> {{ $announcement->time }}</p>
                    <p>{{ $announcement->description }}</p>
                </div>
            @endforeach
        @else
            <p class="text-center">Nothing's here</p>
        @endif
    </div>
</body>
</html>
