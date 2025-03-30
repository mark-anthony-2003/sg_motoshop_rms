<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function checkoutCartItems(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);
        $quantities = $request->input('quantities', []);

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'No items selected for checkout.');
        }

        $carts = Cart::whereIn('cart_id', $selectedItems)
            ->where('user_id', Auth::id())
            ->with('item')
            ->get();
        
        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'No valid items found in the cart.');
        }
        
        $totalAmount = 0;
        $shipmentItems = [];

        foreach ($carts as $cart) {
            $item = $cart->item;

            if (isset($quantities[$cart->cart_id])) {
                $cart->quantity = $quantities[$cart->cart_id];
                $cart->sub_total = $cart->quantity * $item->price;
                $cart->save();

                $item->decrement('stocks', $cart->quantity);

                $shipmentItems[] = [
                    'item_id'   => $item->item_id,
                    'quantity'  => $cart->quantity,
                    'sub_total' => $cart->sub_total
                ];
            }
            $totalAmount += $cart->sub_total;
        }

        session([
            'checkoutCartItems' => $selectedItems
        ]);

        return redirect()->route('shop.orderSummary');
    }

    public function showOrderSummary()
    {
        $selectedItems = session('checkoutCartItems' ,[]);

        $carts = Cart::whereIn('cart_id', $selectedItems)
            ->where('user_id', Auth::id())
            ->with('item')
            ->get();
        $totalAmount = $carts->sum('sub_total');
        $user = Auth::user();

        return view('pages.items.order_summary', compact('selectedItems' ,'carts', 'totalAmount', 'user'));
    }
}
