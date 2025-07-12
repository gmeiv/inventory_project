@extends('layouts.app') <!-- or your admin layout -->

@section('content')
<div class="container py-5 text-white">
    <h2 class="text-center mb-4">Edit Announcement</h2>

    <form action="{{ route('announcements.update', $announcement->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" value="{{ $announcement->title }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" value="{{ $announcement->date }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Time</label>
            <input type="time" name="time" value="{{ $announcement->time }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required>{{ $announcement->description }}</textarea>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('announcements.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
