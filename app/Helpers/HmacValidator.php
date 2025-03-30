<?php

namespace App\Helpers;

class HmacValidator
{
    public function isValidHmac(array $notificationItem, string $hmacKey): bool
    {
        if (!isset($notificationItem['hmacSignature'])) {
            return false;
        }

        // Build HMAC string based on Adyen's expected structure
        $hmacString = $notificationItem['merchantReference'] . $notificationItem['eventCode'];

        // Calculate the expected HMAC signature
        $calculatedHmac = base64_encode(hash_hmac('sha256', $hmacString, pack("H*", $hmacKey), true));

        return hash_equals($calculatedHmac, $notificationItem['hmacSignature']);
    }
}
