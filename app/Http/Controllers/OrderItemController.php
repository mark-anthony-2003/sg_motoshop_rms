<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function showItemCards()
    {
        $items = Item::all();
        return view('pages.items.index', compact('items'));
    }

    public function showItemCardDetail(Item $orderItemId)
    {
        $popularItems = Item::orderBy('sold', 'desc')->take(6)->get();
        return view('pages.items.order_item', compact('orderItemId', 'popularItems'));
    }

    public function addToCartItem(Request $request, Item $orderItemId)
    {
        $quantity = $request->input('quantity', 1);
        $quantity = min($quantity, $orderItemId->stocks);

        if ($orderItemId->item_status === 'in_stock' && $quantity > 0) {
            $cart = Cart::where('item_id', $orderItemId->item_id)
                ->where('user_id', auth()->user()->user_id)
                ->first();
            
            if ($cart) {
                $cart->increment('quantity', $quantity);
                $cart->sub_total = $cart->quantity * $orderItemId->price;
                $cart->save();
            } else {
                Cart::create([
                    'item_id'   => $orderItemId->item_id,
                    'user_id'   => auth()->user()->user_id,
                    'quantity'  => $quantity,
                    'sub_total' => $orderItemId->price * $quantity
                ]);
            }
            $orderItemId->decrement('stocks', $quantity);

            return redirect()->route('shop.items')->with('success', 'Item added to cart successfully!');
        }
        return redirect()->back()->with('error', 'Item is out of stock or invalid quantity!');
    }
}
