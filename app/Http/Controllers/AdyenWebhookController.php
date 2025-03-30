<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\HmacValidator;
use App\Models\Shipment;

class AdyenWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $hmacValidator = new HmacValidator();
        $hmacKey = env('ADYEN_WEBHOOK_HMAC_KEY');
        $notificationItem = $request->input('notificationItems')[0]['NotificationRequestItem'];

        if (!$hmacValidator->isValidHmac($notificationItem, $hmacKey)) {
            Log::warning('Invalid Adyen Webhook signature.');
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        Log::info('Adyen Webhook Received: ', $notificationItem);

        $reference = $notificationItem['merchantReference'] ?? null;
        $eventCode = $notificationItem['eventCode'] ?? null;
        $success = $notificationItem['success'] === 'true';

        if ($reference && $success) {
            if ($eventCode === 'AUTHORISATION') {
                $this->markOrderAsPaid($reference);
                Log::info("Order $reference marked as PAID.");
            } elseif ($eventCode === 'CANCELLATION') {
                $this->cancelOrder($reference);
                Log::info("Order $reference has been CANCELED.");
            }
        }

        return response()->json(['status' => 'success']);
    }

    private function markOrderAsPaid($reference)
    {
        Shipment::where('payment_reference', $reference)
            ->update(['payment_status' => 'paid']);
    }

    private function cancelOrder($reference)
    {
        Shipment::where('payment_reference', $reference)
            ->update(['payment_status' => 'canceled']);
    }
}

