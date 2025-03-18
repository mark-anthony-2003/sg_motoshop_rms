<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function showItemsTable()
    {
        $items = Item::all();
        return view('admin.inventory_management.item.index', compact('items'));
    }

    public function showItemDetail(Item $item)
    {
        return view('admin.inventory_management.item.show', compact('item'));
    }

    public function showItemForm()
    {
        return view('admin.inventory_management.item.create');
    }

    public function editItem(Item $item)
    {
        return view('admin.inventory_management.item.create', compact('item'));
    }

    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'item_name'     => 'required|string|max:100',
            'item_image'    => 'nullable|image|mimes:png,jpg|max:5000',
            'price'         => 'required|integer',
            'stocks'        => 'required|integer',
            'item_status'   => 'required|in:in_stock,out_of_stock'
        ]);

        $validated['item_status'] = ($validated['stocks'] == 0) ? 'out_of_stock' : 'in_stock';

        $itemImagePath = null;
        if ($request->hasFile('item_image')) {
            $itemImagePath = $request->file('item_image')->store('item_images', 'public');
        }

        $item = Item::create([
            'item_name'     => $validated['item_name'],
            'item_image'    => $itemImagePath,
            'price'         => $validated['price'],
            'stocks'        => $validated['stocks'],
            'item_status'   => $validated['item_status']
        ]);

        if (!$item) {
            return redirect()->back()->withErrors(['error' => 'Failed to store item.']);
        }

        return redirect()->route('items-table')->with('success', 'Item created successfully');
    }

    public function updateItem(Request $request, Item $item)
    {
        $validated = $request->validate([
            'item_name'     => 'required|string|max:100',
            'item_image'    => 'nullable|image|mimes:png,jpg|max:2048',
            'price'         => 'required|integer',
            'stocks'        => 'required|integer',
            'item_status'   => 'required|in:in_stock,out_of_stock'
        ]);

        $itemImagePath = $item->item_image;
        if ($request->hasFile('item_image')) {
            $itemImagePath = $request->file('item_image')->store('item_images', 'public');
        }

        $item->update([
            'item_name'     => $validated['item_name'],
            'item_image'    => $itemImagePath,
            'price'         => $validated['price'],
            'stocks'        => $validated['stocks'],
            'item_status'   => $validated['item_status']
        ]);

        return redirect()->route('items-table')->with('success', 'Item updated successfully');
    }

    public function deleteItem(Item $item)
    {
        $item->delete();
        return redirect()->route('items-table')->with('success', 'Item deleted successfully');
    }
}
