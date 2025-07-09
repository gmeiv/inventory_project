<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|max:255|unique:items,serial_number',
            'name' => 'required|string|max:255',
            'stocks' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'serial_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['serial_number', 'name', 'stocks', 'location']);

        // Handle serial_image upload if present
        if ($request->hasFile('serial_image')) {
            $data['serial_image'] = $request->file('serial_image')->store('serial_images', 'public');
        }

        Item::create($data);

        return redirect()->route('items.index')->with('success', 'Item added successfully!');
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stocks' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'serial_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'stocks', 'location']);

        // Handle serial_image upload if present
        if ($request->hasFile('serial_image')) {
            $data['serial_image'] = $request->file('serial_image')->store('serial_images', 'public');
        }

        $item->update($data);

        return redirect()->route('items.index')->with('success', 'Item updated successfully!');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully!');
    }
}
