<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function checkoutItems(Request $request)
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

        $shipment = Shipment::create([
            'cart_id'               => $carts->first()->cart_id,
            'total_amount'          => $totalAmount,
            'shipment_item_status'  => 'pending',
            'shipment_method'       => 'courier',
            'payment_method'        => 'cash_on_delivery',
            'payment_status'        => 'pending',
            'shipment_date'         => now(),
            'items'                 => json_encode($selectedItems)
        ]);

        Cart::whereIn('cart_id', $selectedItems)->delete();

        return redirect()->route('shop.orderSummary', ['shipment' => $shipment->shipment_id])
            ->with('success', 'Order placed successfully');
    }

    public function showOrderSummary(Shipment $shipment)
    {
        return view('pages.items.order_summary', compact('shipment'));
    }
}
