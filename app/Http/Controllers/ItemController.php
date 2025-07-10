<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


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
    $validated = $request->validate([
        'serial_number' => 'required|unique:items,serial_number',
        'name' => 'required|string',
        'stocks' => 'required|integer|min:0',
        'location' => 'required|string',
        'serial_image' => 'nullable|image'
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
            'serial_number' => [
                'required',
                Rule::unique('items')->ignore($item->id), // Adjust if you use serial_number as the primary key
            ],
            'name' => 'required',
            'stocks' => 'required|integer|min:0',
            'location' => 'required',
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
