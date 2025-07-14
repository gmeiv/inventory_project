<!DOCTYPE html>
<html>
<head>
    <title>Announcement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/announcement.css') }}">
</head>
<body>
<div class="container py-5">

    <div class="mb-2">
        <a href="{{ route('user.dashboard') }}" class="back-button">&larr; Back to Dashboard</a>
    </div>

    <h2 class="text-center mb-3">Announcement</h2>

    @if($announcements->count() > 0)
    @foreach($announcements as $announcement)
    <div class="announcement-box mb-3">
        <h4 class="text-uppercase">{{ $announcement->title }}</h4>
        <p><strong>Date:</strong> {{ $announcement->date }} | <strong>Time:</strong> {{ $announcement->time }}</p>
        <p class="mb-0">{{ $announcement->description }}</p>
    </div>
    @endforeach
    @else
        <p class="text-center">Nothing's here</p>
    @endif
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
