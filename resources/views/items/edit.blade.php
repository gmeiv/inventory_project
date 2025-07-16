<h2>Edit Item</h2>

<form method="POST" action="{{ route('items.update', $item->serial_number) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="serial_number">Serial Number:</label>
    <input type="text" name="serial_number" value="{{ $item->serial_number }}" required><br>

    <input type="hidden" name="serial_number_original" value="{{ $item->serial_number }}">

    <label for="name">Name:</label>
    <input type="text" name="name" value="{{ $item->name }}" required><br>

    <label for="category">Category:</label>
    <input type="text" name="category" value="{{ $item->category }}" required><br>

    <label for="stocks">Stocks:</label>
    <input type="number" name="stocks" value="{{ $item->stocks }}" required min="0"><br>

    <label for="location">Location:</label>
    <input type="text" name="location" value="{{ $item->location }}" required><br>

    <label for="serial_image">Serial Image:</label>
    <input type="file" name="serial_image" accept="image/*"><br>
    @if($item->serial_image)
        <p>Current Image:</p>
        <img src="{{ asset('storage/' . $item->serial_image) }}" alt="Current Image" width="100">
    @endif

    <button type="submit">Update</button>
</form>
