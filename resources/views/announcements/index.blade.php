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

    <div class="top-buttons mb-3 d-flex justify-content-between">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">&larr; Back</a>
        <button class="btn btn-darkblue" onclick="openAddModal()">+ Add Announcement</button>
    </div>

    @if($announcements->count() > 0)
    @foreach($announcements as $announcement)
    <div class="announcement-box">
        @php
            $announcementData = [
                'id' => $announcement->id,
                'title' => $announcement->title,
                'date' => $announcement->date,
                'time' => $announcement->time,
                'description' => $announcement->description,
            ];
        @endphp

        <h4 class="text-uppercase">{{ $announcement->title }}</h4>
        <p><strong>Date:</strong> {{ $announcement->date }} | <strong>Time:</strong> {{ $announcement->time }}</p>

        <!-- Description and buttons in same row -->
        <div class="d-flex justify-content-between align-items-start">
    <p class="mb-0 flex-grow-1 pe-3">{{ $announcement->description }}</p>

    <div class="d-flex gap-2 align-items-center">
        <!-- Edit Button -->
        <button class="btn btn-sm btn-primary"
            onclick='openEditModal(@json($announcementData))'>
            Edit
        </button>

        <!-- Delete Button -->
        <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" class="m-0 p-0">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">
                Delete
            </button>
        </form>
    </div>
</div>

    </div>
@endforeach

    @else
        <p class="text-center">Nothing's here</p>
    @endif
</div>

<!-- Shared Add/Edit Modal -->
<div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="announcementForm" method="POST" action="{{ route('announcements.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="announcement_id" id="announcementId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Announcement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="announcementTitle" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" id="announcementDate" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Time</label>
                        <input type="time" name="time" id="announcementTime" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="announcementDescription" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-darkblue" id="submitButton">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JS Scripts AFTER HTML is loaded -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let modalInstance = null;

    document.addEventListener('DOMContentLoaded', () => {
        const modalElement = document.getElementById('announcementModal');
        modalInstance = new bootstrap.Modal(modalElement);
    });

    function openAddModal() {
        document.getElementById('modalTitle').textContent = 'Add Announcement';
        document.getElementById('announcementForm').action = "{{ route('announcements.store') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('announcementId').value = '';
        document.getElementById('announcementTitle').value = '';
        document.getElementById('announcementDate').value = '';
        document.getElementById('announcementTime').value = '';
        document.getElementById('announcementDescription').value = '';
        modalInstance.show();
    }

    function openEditModal(data) {
        document.getElementById('modalTitle').textContent = 'Edit Announcement';
        document.getElementById('announcementForm').action = "{{ url('/announcements') }}/" + data.id;

        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('announcementId').value = data.id;
        document.getElementById('announcementTitle').value = data.title;
        document.getElementById('announcementDate').value = data.date;
        document.getElementById('announcementTime').value = data.time;
        document.getElementById('announcementDescription').value = data.description;
        modalInstance.show();
    }
</script>
</body>
</html>
