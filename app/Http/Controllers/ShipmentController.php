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
        $selectedItems = $request->input('selectedItems', []);
        $quantities = $request->input('quantities', []);

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'No items selected for checkout.');
        }

        $carts = Cart::whereIn('cart_id', $selectedItems)
            ->where('user_id', Auth::id())
            ->with('item')
            ->get();

        $totalAmount = 0;
        foreach ($carts as $cart) {
            $cart->update(['quantity' => $quantities[$cart->item->item_id] ?? $cart->quantity]);
            $totalAmount += $cart->sub_total;
        }

        // store shipment details
        $shipment = Shipment::create([
            'cart_id'           => $carts->first()->cart_id,
            'total_amount'      => $totalAmount,
            'shipment_status'   => 'pending',
            'shipment_method'   => 'courier',
            'payment_method'    => 'cash_on_delivery',
            'payment_status'    => 'unpaid',
            'shipment_date'     => now()
        ]);

        return redirect()->route('shop.orderSummary', ['shipment' => $shipment->shipment_id]);
    }

    public function showOrderSummary(Shipment $shipment)
    {
        return view('shop.order_summary', compact('shipment'));
    }
}
