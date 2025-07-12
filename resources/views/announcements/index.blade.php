<!DOCTYPE html>
<html>
<head>
    <title>Announcement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/announcement.css') }}">
</head>
<body>
<div class="container py-5">
    <h2 class="text-center mb-4">Announcement</h2>

    <div class="top-buttons mb-3">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">&larr; Back</a>
        <button class="btn btn-darkblue" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">+ Add Announcement</button>
    </div>

    @if($announcements->count() > 0)
        @foreach($announcements as $announcement)
            <div class="announcement-box">
                <h4 class="text-uppercase">{{ $announcement->title }}</h4>
                <p><strong>Date:</strong> {{ $announcement->date }} | <strong>Time:</strong> {{ $announcement->time }}</p>
                <p>{{ $announcement->description }}</p>
            </div>
        @endforeach
    @else
        <p class="text-center">Nothing's here</p>
    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-labelledby="addAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('announcements.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Announcement</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Time</label>
                        <input type="time" name="time" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-darkblue">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>