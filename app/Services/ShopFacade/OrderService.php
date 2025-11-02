<?php

namespace App\Services\ShopFacade;

use Illuminate\Support\Str;

class OrderService
{
    public function generateOrderId(): string
    {
        return 'ORD-'.Str::upper(Str::random(8));
    }
}
