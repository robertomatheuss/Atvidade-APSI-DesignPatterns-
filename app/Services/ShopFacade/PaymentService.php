<?php

namespace App\Services\ShopFacade;

use Illuminate\Support\Str;

class PaymentService
{
    public function charge(float $amount, string $customerId): string
    {
        return $amount > 0 ? 'TXN-'.Str::uuid()->toString() : '';
    }
}
