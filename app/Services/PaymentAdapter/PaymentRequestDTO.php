<?php

namespace App\Services\PaymentAdapter;

class PaymentRequestDTO
{
    public function __construct(
        public string $orderId,
        public float  $amount
    ) {}
}
