<h2>Add New Item</h2>

<form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
    @csrf

    <label for="serial_number">Serial Number:</label>
    <input type="text" name="serial_number" required><br>

    <label for="name">Name:</label>
    <input type="text" name="name" required><br>

    <label for="category">Category:</label>
    <input type="text" name="category" required><br>

    <label for="stocks">Stocks:</label>
    <input type="number" name="stocks" required min="0"><br>

    <label for="location">Location:</label>
    <input type="text" name="location" required><br>

    <label for="serial_image">Serial Image:</label>
    <input type="file" name="serial_image" accept="image/*"><br>

    <button type="submit">Add</button>
</form>
