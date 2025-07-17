<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
                'category' => 'required|string|max:255',
                'description' => 'nullable|string', // 🔧
                'image1' => 'nullable|image|max:2048',
                'image2' => 'nullable|image|max:2048',
                'image3' => 'nullable|image|max:2048',
                'image4' => 'nullable|image|max:2048',
                'image5' => 'nullable|image|max:2048',
            ]);
        } else {
            $request->validate([
                'serial_number' => 'required',
                'name' => 'required',
                'total_stocks' => 'required|integer|min:0',
                'location' => 'required',
                'category' => 'required|string|max:255',
                'description' => 'nullable|string', // 🔧
                'image1' => 'nullable|image|max:2048',
                'image2' => 'nullable|image|max:2048',
                'image3' => 'nullable|image|max:2048',
                'image4' => 'nullable|image|max:2048',
                'image5' => 'nullable|image|max:2048',
            ]);
        }

        $data = $request->only(['serial_number', 'name', 'total_stocks', 'location', 'category', 'description']);
$data['stocks'] = $request->total_stocks;

for ($i = 1; $i <= 5; $i++) {
    if ($request->hasFile("image$i")) {
        $data["image$i"] = $request->file("image$i")->store('item_images', 'public');
    }
}


        if ($request->hasFile('serial_image')) {
            $data['serial_image'] = $request->file('serial_image')->store('serial_images', 'public');
        }

        // 🔧 Handle optional images
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("image$i")) {
                $data["image$i"] = $request->file("image$i")->store("item_images", "public");
            }
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
                'category' => 'required|string|max:255',
                'description' => 'nullable|string', // 🔧
                'image1' => 'nullable|image|max:2048',
                'image2' => 'nullable|image|max:2048',
                'image3' => 'nullable|image|max:2048',
                'image4' => 'nullable|image|max:2048',
                'image5' => 'nullable|image|max:2048',
            ]);
        } else {
            $request->validate([
                'serial_number' => 'required',
                'name' => 'required',
                'total_stocks' => 'required|integer|min:0',
                'location' => 'required',
                'category' => 'required|string|max:255',
                'description' => 'nullable|string', // 🔧
                'image1' => 'nullable|image|max:2048',
                'image2' => 'nullable|image|max:2048',
                'image3' => 'nullable|image|max:2048',
                'image4' => 'nullable|image|max:2048',
                'image5' => 'nullable|image|max:2048',
            ]);
        }

        $item = Item::where('serial_number', $serial_number)->firstOrFail();

        $item->serial_number = $request->serial_number;
        $item->name = $request->name;
        $item->total_stocks = $request->total_stocks;
        $item->location = $request->location;
        $item->category = $request->category;
        $item->description = $request->description; // 🔧

        if ($request->hasFile('serial_image')) {
            $item->serial_image = $request->file('serial_image')->store('serial_images', 'public');
        }

        // 🔧 Update optional images
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("image$i")) {
                $item["image$i"] = $request->file("image$i")->store("item_images", "public");
            }
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
