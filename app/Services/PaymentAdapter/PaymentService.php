<?php

namespace App\Services\PaymentAdapter;

class PaymentService
{
    public function __construct(private LegacyPaymentProcessor $processor) {}

    public function pay(string $orderId, float $amount): bool
    {
        return $this->processor->processPayment($orderId, $amount);
    }
}
