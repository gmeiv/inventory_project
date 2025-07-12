<!DOCTYPE html>
<html>
<head>
    <title>Announcement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/announcement.css') }}">
</head>
<body>
<div class="container py-5">
    <!-- Back Button -->
    <div class="mb-2">
        <a href="{{ route('admin.dashboard') }}" class="back-button">&larr; Back to Dashboard</a>
    </div>

    <!-- Title -->
    <h2 class="text-center mb-3">Announcement</h2>

    <!-- Add Button aligned right -->
    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-darkblue" onclick="openAddModal()">+ Add Announcement</button>
    </div>

    @if($announcements->count() > 0)
    @foreach($announcements as $announcement)
    <div class="announcement-box mb-3">
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

        <div class="d-flex justify-content-between align-items-start">
            <p class="mb-0 flex-grow-1 pe-3">{{ $announcement->description }}</p>
            <div class="d-flex gap-2 align-items-center">
                <button class="btn btn-sm btn-primary" onclick='openEditModal(@json($announcementData))'>
                    Edit
                </button>
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