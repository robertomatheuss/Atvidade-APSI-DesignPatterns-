<?php

namespace App\Services\PaymentAdapter;

interface LegacyPaymentProcessor
{
    # Interface legada
    
    public function processPayment(string $orderId, float $amount): bool;
}
