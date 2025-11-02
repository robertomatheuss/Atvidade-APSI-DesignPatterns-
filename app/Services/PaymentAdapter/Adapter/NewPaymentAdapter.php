<?php

namespace App\Services\PaymentAdapter\Adapter;

use App\Services\PaymentAdapter\LegacyPaymentProcessor;
use App\Services\PaymentAdapter\NewPaymentSystem;
use App\Services\PaymentAdapter\PaymentRequestDTO;

/**
 * Adapter: faz o novo sistema "parecer" a interface legada.
 * Implementa LegacyPaymentProcessor e delega ao NewPaymentSystem.
 */
class NewPaymentAdapter implements LegacyPaymentProcessor
{
    public function __construct(private NewPaymentSystem $newSystem) {}

    public function processPayment(string $orderId, float $amount): bool
    {
        $req = new PaymentRequestDTO($orderId, $amount);
        $result = $this->newSystem->executePayment($req);

        return (bool)($result['success'] ?? false);
    }
}
