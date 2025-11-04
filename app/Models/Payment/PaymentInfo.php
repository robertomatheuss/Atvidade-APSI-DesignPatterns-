<?php

namespace App\Models\Payment;

class PaymentInfo
{
    public function __construct(
        public string $payerId,
        public float  $amount,
        public array  $meta = []
    ) {}
}
