<h2>Edit Item</h2>
<form method="POST" action="{{ route('items.update', $item->id) }}">
    @csrf
    @method('PUT')
    <label>Name:</label>
    <input type="text" name="name" value="{{ $item->name }}" required><br>
    <label>Stocks:</label>
    <input type="number" name="stocks" value="{{ $item->stocks }}" required min="0"><br>
    <button type="submit">Update</button>
</form>
