<?php

namespace App\Models\Shop;

class OrderResult
{
    public function __construct(
        public bool   $ok,
        public string $orderId,
        public float  $total,
        public ?string $paymentTxn = null,
        public array $notes = [],
    ) {}
}
