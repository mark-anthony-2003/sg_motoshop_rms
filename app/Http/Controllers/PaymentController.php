<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Adyen\Client;
use Adyen\Environment;
use Adyen\Model\Checkout\Amount;
use Adyen\Model\Checkout\PaymentRequest;
use Adyen\Service\Checkout\PaymentsApi;
use Exception;
use App\Models\Shipment;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;  // For generating UUIDs
use Illuminate\Support\Facades\Log;  // For logging

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        $totalAmount = (int)($request->totalAmount * 100);
        $user = auth()->user();

        $selectedItems = session('checkoutCartItems', []);

        if ($paymentMethod === 'cash_on_delivery') {
            $this->createOrder($user, $totalAmount, 'cash_on_delivery', $selectedItems, null);
            session()->forget('checkoutCartItems');
            return redirect()->route('payment.success');
        }

        if ($paymentMethod === 'gcash') {
            return $this->processGcashPayment($totalAmount, $selectedItems);
        }

        return back()->with('error', 'Invalid payment method selected.');
    }

    private function processGcashPayment($totalAmount, $carts)
    {
        try {
            $client = new Client();
            $client->setXApiKey(env("ADYEN_API_KEY"));
            $client->setEnvironment(env("ADYEN_ENVIRONMENT") === 'live' ? Environment::LIVE : Environment::TEST);

            // Generate a unique order reference
            $orderReference = 'ORD-' . time() . '-' . auth()->id();

            // Create the request object(s)
            $amount = new Amount();
            $amount
                ->setCurrency("PHP")
                ->setValue($totalAmount);

            // Prepare payment request
            $paymentRequest = new PaymentRequest();
            $paymentRequest
                ->setReference($orderReference)
                ->setAmount($amount)
                ->setMerchantAccount(env("ADYEN_MERCHANT_ACCOUNT"))
                ->setPaymentMethod(['type' => 'mobile', 'issuer' => 'GCash'])
                ->setReturnUrl(route('payment.success'))
                ->setChannel("Web");
            
            // Generate idempotency key
            $requestOptions = [];
            $requestOptions['idempotencyKey'] = (string) Str::uuid();

            // Send payment request
            $service = new PaymentsApi($client);
            $response = $service->payments($paymentRequest, $requestOptions);

            // Log::info('Adyen Payment Request:', (array) $paymentRequest);
            // Log::info('Adyen GCash Response:', (array) $response);

            // Store the order in the Shipment table before redirecting
            $this->createOrder(auth()->user(), $totalAmount, 'gcash', $carts, $orderReference);

            if (isset($response['action']) && isset($response['action']['url'])) {
                $this->createOrder(auth()->user(), $totalAmount, 'gcash', $carts, $orderReference);
                return redirect()->away($response['action']['url']);
            }

            return back()->with('error', 'Failed to initiate GCash payment.');
        } catch (Exception $e) {
            return back()->with('error', 'Payment initiation failed: ' . $e->getMessage());
        }
    }

    private function createOrder($user, $amount, $paymentMethod, $selectedItems, $reference = null)
    {
        // Fetch selected cart items
        $carts = Cart::whereIn('cart_id', $selectedItems)
            ->where('user_id', $user->user_id)
            ->get();

        foreach ($carts as $cart) {
            Shipment::create([
                'cart_id'               => $cart->cart_id,
                'total_amount'          => $amount / 100,
                'shipment_item_status'  => 'pending',
                'shipment_method'       => 'courier',
                'shipment_date'         => now()->toDateString(),
                'payment_method'        => $paymentMethod,
                'payment_status'        => ($paymentMethod === 'cash_on_delivery') ? 'pending' : 'paid',
                'payment_reference'     => $reference
            ]);
        }
    }

    public function paymentSuccess()
    {
        return view('pages.payment.success')->with('success', 'Payment successfully processed.');
    }
}
