<?php

namespace App\Services\PriceCalculatorStrategy\Estrategies\Discount;

class FixedDiscount implements DiscountStrategy
{
    public function __construct(private float $discount) {}

    public function applyDiscount(float $amount): float
    {
        return max(0, $amount - $this->discount);
    }
}
