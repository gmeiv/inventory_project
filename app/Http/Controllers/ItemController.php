<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::orderBy('created_at', 'desc')->get();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        if ($request->serial_number !== $request->serial_number_original) {
            $request->validate([
                'serial_number' => 'required|unique:items,serial_number',
                'name' => 'required',
                'total_stocks' => 'required|integer|min:0',
                'location' => 'required',
                'category' => 'required|string|max:255'
            ]);
        } else {
            $request->validate([
                'serial_number' => 'required',
                'name' => 'required',
                'total_stocks' => 'required|integer|min:0',
                'location' => 'required',
                'category' => 'required|string|max:255'
            ]);
        }

        $data = $request->only(['serial_number', 'name', 'total_stocks', 'location', 'category']);
        $data['stocks'] = $request->total_stocks; // Set current stocks to total stocks on create

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

    public function update(Request $request, $serial_number)
    {
        if ($request->serial_number !== $request->serial_number_original) {
            $request->validate([
                'serial_number' => 'required|unique:items,serial_number',
                'name' => 'required',
                'total_stocks' => 'required|integer|min:0',
                'location' => 'required',
                'category' => 'required|string|max:255'
            ]);
        } else {
            $request->validate([
                'serial_number' => 'required',
                'name' => 'required',
                'total_stocks' => 'required|integer|min:0',
                'location' => 'required',
                'category' => 'required|string|max:255'
            ]);
        }

        $item = Item::where('serial_number', $serial_number)->firstOrFail();

        $item->serial_number = $request->serial_number;
        $item->name = $request->name;
        $item->total_stocks = $request->total_stocks;
        $item->location = $request->location;
        $item->category = $request->category;

        if ($request->hasFile('serial_image')) {
            $item->serial_image = $request->file('serial_image')->store('serial_images', 'public');
        }

        $item->save();

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully!');
    }
}
