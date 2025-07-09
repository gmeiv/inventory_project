<h2>Add New Item</h2>
<form method="POST" action="{{ route('items.store') }}">
    @csrf
    <label>Name:</label>
    <input type="text" name="name" required><br>
    <label>Stocks:</label>
    <input type="number" name="stocks" required min="0"><br>
    <button type="submit">Add</button>
</form>
